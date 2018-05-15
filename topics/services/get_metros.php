<?php
include '../includes/config.inc';
//$state = $_POST['state'];
// define the table to use for this topic
$table = "Test_3_9";

function queryAllDB($query){
$host = $db_host;
$db   = $db_name;
$user = $db_user;
$pass = $db_password;
$charset = "utf8mb4";
$port = $db_port;
$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
$opt = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
);

$pdo = new PDO($dsn, $user, $pass, $opt);
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
//$query = "SELECT distinct NAME,GEOID FROM " . $table . " WHERE STATE =? AND SUMLEVEL = 160";
$query = "SELECT distinct NAME,GEOID FROM " . $table . " WHERE SUMLEVEL = 310";
//$query_params = array($state);
$metros = queryAllDB($query);

$geo_options = ''; 
foreach ($metros as $row) {
$geo_options .= '<option value="'.$row['GEOID'].'">'.$row['NAME'].'</option>';
}
	 
echo '<label for="metro">3. Choose a metro</label> <select id="metro" name="geoid">'.$geo_options.'</select>';

?>