<?php


function dbConnect(){

	static $connection;
	
	if(!isset($connection)) {
	$host = "webapps4-mysql.miserver.it.umich.edu";
	$db   = "censcope";
	$user = "censcope";
	$pass = "lsH6TnU2$5k4";
	$charset = "utf8mb4";
	$port = "3306";
	$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
	$opt = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
    PDO::ATTR_PERSISTENT => true,
	);
	$connection = new PDO($dsn, $user, $pass, $opt);
	}
	if($connection === false) {  
        die('<p>database connection failed</p>');
    }
 	return $connection;
}


function queryDB($query,$query_params){

$pdo = dbConnect();
$stmt = $pdo->query($query);
try{
	$stmt->execute($query_params);
	$results = $stmt->fetchColumn();
	return $results;
}
catch (PDOException $e) {
    echo 'PDO error: ' . $e->getMessage();
}

}


function queryDBAll($query,$query_params){

$pdo = dbConnect();
$stmt = $pdo->query($query);
try{
	$stmt->execute($query_params);
	$results = $stmt->fetchAll();
	return $results;
}
catch (PDOException $e) {
    echo 'PDO error: ' . $e->getMessage();
}

}



// get geoid from URL or set default to United States
$geoid = isset($_GET['geoid']) ? $_GET['geoid']  : '01000US';
if($geoid){
	$query = 'SELECT NAME FROM ' . $table . ' WHERE GEOID = ? LIMIT 1';
	$query_params = array($geoid);
	$location = queryDB($query,$query_params);
}

function getMeasure($mid,$year,$geoid){
	global $table;
	$query = "SELECT ".$mid." FROM " . $table . " WHERE year = ? AND GEOID = ?";
	$query_params = array($year,$geoid);
	return queryDB($query,$query_params);
}

function getMeasures($mids,$year,$geoid){
	global $table;
	$mids = implode(",",$mids);
	$query = "SELECT DISTINCT ".$mids." FROM " . $table . " WHERE year = ? AND GEOID = ?";
	$query_params = array($year,$geoid);
	return queryDBAll($query,$query_params);
}

function getMeasuresByGeoLevel($mids,$year,$sumlev){
	global $table;
	$mids = implode(",",$mids);
	$query = "SELECT DISTINCT ".$mids.", NAME FROM " . $table . " WHERE year = ? AND SUMLEVEL = ?";
	$query_params = array($year,$sumlev);
	return queryDBAll($query,$query_params);
}

?>