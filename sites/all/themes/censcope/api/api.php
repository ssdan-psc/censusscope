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
include 'bar_json.php';



// --- Step 1: Initialize variables and functions

/**
 * Deliver HTTP Response
 * @param string $format The desired HTTP response content type: [json, html, xml]
 * @param string $api_response The desired HTTP response data
 * @return void
 **/
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

	}elseif( strcasecmp($format,'xml') == 0 ){

		// Set HTTP Response Content Type
		header('Content-Type: application/xml; charset=utf-8');

		// Format data into an XML response (This is only good at handling string data, not arrays)
		$xml_response = '<?xml version="1.0" encoding="UTF-8"?>'."\n".
			'<response>'."\n".
			"\t".'<code>'.$api_response['code'].'</code>'."\n".
			"\t".'<data>'.$api_response['data'].'</data>'."\n".
			'</response>';

		// Deliver formatted data
		echo $xml_response;

	}else{

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
	1 => array('HTTP Response' => 200, 'Message' => 'Success'),
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
	$year = $_GET['year'];
	$measures = $_GET['measures'];
	$response['code'] = 1;
	$response['status'] = $api_response_code[$response['code'] ]['HTTP Response'];

	$pie_data = array();

	//die($measures);
	//$measures = array('B50111','B50110','B50112');


	// Pie
	$cols = get_cols_2($topic, 'pie', $conn,$measures);
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

		$query .= " FROM " . $table . " WHERE NAME='" . $geo . "' AND year=" . $year;

		$labels = $data_labels;
		$data = array();

		// Add headers to csv
		$csv = '';
		foreach ($data_labels as $label){
			$csv .= $label;
			if ($label != end($data_labels)) {$csv .= ",";}
		}

		$csv .= "\n";
		foreach ($conn->query($query) as $row) {
			for($i = 0; $i < count($data_labels); $i++) {
				array_push($pie_data, $row[$i]);
				if($row[$i]==null){$row[$i]='0';}
				$csv .= $row[$i];
				if($i != count($data_labels) - 1) {
					$csv .= ",";
				}
			}

			$csv .= "\n";
		}

		$pie_call = "python json_builder_new.py pie \"". implode(',', $labels)."\" ".implode(',',$pie_data);
		$pie_chart = exec($pie_call);
		$data['pie'] = array("csv" => $csv, "chart" => $pie_chart);
	} else{
		$data['pie'] = array("error" =>  "placeholder error message");
	}
	
	
	
	
	// Stacked
	$cols = get_cols_2($topic, 'stacked_bar', $conn,$measures);
	if (count($cols) > 0) {
		$data_labels = array();
		$query = "SELECT Year";
		foreach ($cols as $col) {
			$query .=  "," . $col['col'];
			
			$col['label'] = str_replace(',',' -',$col['label']);
			array_push($data_labels, $col['label']);
		}
	$bar_chart = bar_json($data_labels, $pie_data, $year);
	

	
	/*
	// Trend
	$cols = get_cols($topic, 'trend', $conn);
	if (count($cols) > 0) {
		$data_labels = array("Year");
		$query = "SELECT Year";
		foreach ($cols as $col) {
			$query .=  "," . $col['col'];
			array_push($data_labels, $col['label']);
		}

		$query .= " FROM " . $table . " WHERE AreaName='" . $geo . "'";

		$labels = array();
		$trend_data = array();

		// Add headers to csv
		$csv = '';
		foreach ($data_labels as $label){
			$csv .= $label;
			if ($label != end($data_labels)) {$csv .= ",";}
		}

		$csv .= "\n";

		foreach ($conn->query($query) as $row) {
			array_push($labels, $row[0]);
			array_push($trend_data, $row[1]);
			$csv .= $row[0] . "," . $row[1] . "\n";
		}
		
		$trend_call = "python json_builder_new.py line \"". implode(',', $labels)."\" ".$topic." ".implode(',',$trend_data);
		$trend_chart = exec($trend_call);
		$data['trend'] = array("csv" => $csv, "chart" => $trend_chart);
	 } 
	 else { 
	      	$data['trend'] = array("error" =>  "placeholder error message");
	 }
	 */
	

/*
		$query .= " FROM " . $table . " WHERE NAME='" . $geo . "' AND year=" . $year;

		$labels = array();
		
		// Add headers to csv
		$csv = '';
		foreach ($data_labels as $label){
			$csv .= $label;
			if ($label != end($data_labels)) {$csv .= ",";}
		}

		$csv .= "\n";
		$year_datasets = array();

		

		foreach ($conn->query($query) as $row) {
			
			array_push($labels, $row[0]);
			$new_dataset = array();
			for($i = 0; $i < count($data_labels); $i++) {
			
				$csv .= $row[$i];
				if ($i != count($data_labels) - 1) {
					$csv .= ",";
				}

				if($i != 0) {
					if($row[$i]==null){$row[$i]='0';}
					array_push($new_dataset, $row[$i]);
				}
			}

			array_push($year_datasets, $new_dataset);
			$csv .= "\n";
		}

		$datasets = array();
		for($j = 0; $j < count($data_labels) - 1; $j++) {
		       $new_dataset = array();
		       
		       
		       
		       foreach($year_datasets as $year) {
		           array_push($new_dataset, $year[$j]);
		       }
		       array_push($datasets, $new_dataset);
		}*/
	

		//$bar_call = "python json_builder_new.py bar \"". implode(',', $data_labels)."\" \"".implode(',',  $pie_data)."\" \"";

		//$bar_call = "python json_builder_new.py bar \"". implode(',', $data_labels)."\" \"".implode(',',  $pie_data)."\" \"".implode(',',  $pie_data);
		
		//$bar_chart = bar_json(implode(',', $data_labels), implode(',',  $pie_data), $year);
		
		/*foreach($datasets as $dataset) {
			bar_call .= implode(',', $dataset);
			if ($dataset != end($datasets)) {
				$bar_call .= "&";
			}
		}*/
		

		$data['stacked'] = array("csv" => $csv, "chart" => $bar_chart);
	 } else { 
	 	$data['stacked'] = array("error" =>  "placeholder error message");
	}

	// Table
	$cols = get_cols($topic, 'tbl', $conn);
	if (count($cols) > 0) {
		$data_labels = array("Year");
		$query = "SELECT Year";
		foreach ($cols as $col) {
			$query .=  "," . $col['col'];
			array_push($data_labels, $col['label']);
		}

		$query .= " FROM " . $table . " WHERE AreaName='" . $geo . "'";

		// Add headers to csv
		$csv = '';
		foreach ($data_labels as $label){
			$csv .= $label;
			if ($label != end($data_labels)) {$csv .= ",";}
		}

		$csv .= "\n";

		foreach ($conn->query($query) as $row) {
			$csv .= $row[0] . "," . $row[1] . "\n";
		}

		$data['table'] = array("csv" => $csv);
	}else {
		$data['table'] = array("error" => "placeholder error message");
	}
/*
	// Pyramid
	$cols1 = get_cols($topic, 'pyramid1', $conn);
	$cols2 = get_cols($topic, 'pyramid2', $conn);
	if (count($cols1) > 0 && count($cols2) > 0) {
		$labels = array();
		$query1 = "SELECT ";
		foreach ($cols1 as $col) {
			$query1 .= $col['col'];
			array_push($labels, $col['label']);
			if ($col != end($cols1)) {
				$query1 .= ",";
			}
		}

		// TODO: Change hardcoded table
		$query1 .= " FROM " . "popPyramid2014_15" . " WHERE Name='" . $geo . "'";

		$query2 = "SELECT ";
		foreach ($cols2 as $col) {
			$query2 .= $col['col'];
			if ($col != end($cols2)) {
				$query2 .= ",";
			}
		}

		$list1 = array();
		foreach ($conn->query($query1) as $row) {
			for ($i = 0; $i < count($row) / 2; $i++) {
    			array_push($list1, $row[$i] * -1.0);
			}
		}

		// TODO: Change hardcoded table
		$list2 = array();
		$query2 .= " FROM " . "popPyramid2014_15" . " WHERE Name='" . $geo . "'";
		foreach ($conn->query($query2) as $row) {
			for ($i = 0; $i < count($row) / 2; $i++) {
    			array_push($list2, $row[$i]);
			}
		}

		$csv = '';
		$csv .= 'Sex, '.implode(',', $labels)."\n";
		$csv .= 'Male, '.implode(',', $list1)."\n";
		$csv .= "Female,  ".implode(',', $list2)."\n";

		$pyramid_call = "python json_builder_new.py pyramid \"". implode(',', array_reverse($labels))."\" Male,Female ".implode(',',array_reverse($list1))." ".implode(',', array_reverse($list2));
		$pyramid_chart = exec($pyramid_call);
		$data['pyramid'] = array("csv" => $csv, "chart" => $pyramid_chart);
	} else {
		$data['pyramid'] = array("error" => "placeholder error message");
	}
*/
	
	$response['data'] = $data;
}

// --- Step 4: Deliver Response

// Return Response to browser
deliver_response($_GET['format'], $response);

?>