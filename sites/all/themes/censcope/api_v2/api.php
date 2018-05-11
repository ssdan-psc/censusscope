<?php

ini_set('display_errors', 'On');
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/*
	Adapted from http://markroland.com/portfolio/restful-php-api)

	Input:

		$_GET['format'] = [ json | html | xml ]
		$_GET['method'] = []

	Output: A formatted HTTP response
*/

include 'build_json.php';
//include 'bar_json.php';


function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    //return random_color_part() . random_color_part() . random_color_part();
    $f_contents = file("hex_codes.txt");
	$line = $f_contents[array_rand($f_contents)];
	return str_replace(array("\n","\r"),'',$line);
}



function deliver_response($format, $api_response){

	// Define HTTP responses
	$http_response_code = array(
		200 => 'OK',
		400 => 'Bad Request',
		401 => 'Unauthorized',
		403 => 'Forbidden',
		404 => 'Not Found'
	);

	// Set HTTP Response
	header('HTTP/1.1 '.$api_response['status'].' '.$http_response_code[ $api_response['status'] ]);

	// Process different content types
	if( strcasecmp($format,'json') == 0 ){

		// Set HTTP Response Content Type
		header('Content-Type: application/json; charset=utf-8');
		// TODO: Should not allow all origins
		header('Access-Control-Allow-Origin: *');

		// Format data into a JSON response
		$json_response = json_encode($api_response);

		// Deliver formatted data
		echo $json_response;

	}
	else{

		// Set HTTP Response Content Type (This is only good at handling string data, not arrays)
		header('Content-Type: text/html; charset=utf-8');

		// Deliver formatted data
		echo $api_response['data'];

	}

	// End script process
	exit;

}

// Define API response codes and their related HTTP response
$api_response_code = array(
	0 => array('HTTP Response' => 400, 'Message' => 'Unknown Error'),
	1 => array('HTTP Response' => "200", 'Message' => 'Success'),
	2 => array('HTTP Response' => 403, 'Message' => 'HTTPS Required'),
	3 => array('HTTP Response' => 401, 'Message' => 'Authentication Required'),
	4 => array('HTTP Response' => 401, 'Message' => 'Authentication Failed'),
	5 => array('HTTP Response' => 404, 'Message' => 'Invalid Request'),
	6 => array('HTTP Response' => 400, 'Message' => 'Invalid Response Format')
);

// Set default HTTP response of 'ok'
$response['code'] = 0;
$response['status'] = 404;
$response['data'] = NULL;

// Connect to MySQL
$servername = "webapps4-mysql.miserver.it.umich.edu";
$username = "censcope";
$password = "ChangeMeNow2017_censcope";
//$table = 'sample';
//$table = '2015test1';
$table = "combined101415";
$database = "censcope";
$port = '3306';

try {
    $conn = new PDO("mysql:host=".$servername.";port=".$port.";dbname=".$database, $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;    // TODO:
}


// Process Request

// API 
if(strcasecmp($_GET['method'],'hello') == 0){

	$topic = $_GET['topic'];
	$geo = $_GET['geo'];
	$years = $_GET['year'];
	$measures = $_GET['measures'];
	$response['code'] = "1";
	$response['status'] = $api_response_code[$response['code'] ]['HTTP Response'];

$data = array();	
$data['datasets'] = array();
if(count($years)>1){

	foreach($years as $year) {	
	
	$chart_data = array();
	$cols = get_cols($topic, 'stacked_bar', $conn, $measures);
	if (count($cols) > 0){
		$query = "SELECT ";
		$data_labels = array();
		foreach ($cols as $col) {
			$query .= $col['col'];
			if ($col != end($cols)) {
				$query .= ",";
			}
			$col['label'] = str_replace(',',' -',$col['label']);
			array_push($data_labels, $col['label']);
		}

// workaround for GEOIDs with extra zeros. remove after new data is imported.
		$geoshort = substr_replace($geo,'',5,2);
		//$query .= " FROM " . $table . " WHERE GEOID='" . $geo . "' OR GEOID='". $geoshort."' AND year=".$year;	
		$query .= " FROM " . $table . " WHERE GEOID='". $geoshort."' AND year=".$year;
		
		
		$labels = $data_labels;
		foreach ($conn->query($query) as $row) {
			for($i = 0; $i < count($data_labels); $i++) {
			//print $year.' '.$row[$i].' ';
				array_push($chart_data, $row[$i]);
				if($row[$i]==null){$row[$i]='0';}
			}
		}
		} 

		// for stacked bar, should each dataset contain just one value?
		// but then there are more datasets that bar labels... hmm

		$data['labels'][] = $year;
		$data['geoid'][] = $geoshort;

		$datasets = array(
		 'label'=> $data_labels, 
		 'fill' => 'false',
		 'data' => $chart_data,
		 'measureID' => $measures,
		 'backgroundColor'=> random_color(),
		);
			
		//$datasets = json_encode($datasets);
		array_push($data['datasets'], $datasets);

	 
	 }
	 
}

}

//$data = json_encode($data);
$response['data'] = $data;
// Return Response to browser
deliver_response('json', $response);
?>