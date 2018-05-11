<?php

function get_states($table){
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
	 //$query = "SELECT NAME,STATE,GEOID FROM " . $table . " WHERE SUMLEV = '40'";
	 $query = "SELECT distinct NAME,STATE,GEOID FROM " . $table . " WHERE GEOID LIKE '040%'";
	 
	 
	 foreach ($conn->query($query) as $row) {
	 	
	 	$geo_options .= '<option value="'.$row['GEOID'].'" data-state="'.$row['STATE'].'">'.$row['NAME'].'</option>';
	 }
	 return $geo_options;
}

?>