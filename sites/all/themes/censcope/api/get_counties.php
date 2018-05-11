<?php

$state = $_POST['state'];  
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
	 $query = "SELECT NAME FROM " . $table . " WHERE SUMLEV = '50' AND STATE ='".$state ."'";
	 
	 foreach ($conn->query($query) as $row) {
	 	
	 	$geo_options .= '<option value="'.$row['NAME'].'">'.$row['NAME'].'</option>';
	 }
	 
	 echo '<label for="county">County:</label> <select id="county" name="county">'.$geo_options.'</select>';


?>