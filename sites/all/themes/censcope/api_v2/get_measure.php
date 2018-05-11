<?php

$mid = $_POST['mid']; 
$year = $_POST['year'];
$geoid = $_POST['geoid'];

/*
$mid = $_GET['mid']; 
$year = $_GET['year'];
$geoid = $_GET['geoid'];
*/

// Connect to MySQL
$servername = "webapps4-mysql.miserver.it.umich.edu";
$username = "censcope";
$password = "ChangeMeNow2017_censcope";
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
	 
	 $geo_options = '';
	 $query = "SELECT ".$mid." FROM " . $table . " WHERE year ='".$year ."' AND GEOID ='".$geoid ."'";

	 foreach ($conn->query($query) as $row) {
		echo $row[$mid];
	}
?>