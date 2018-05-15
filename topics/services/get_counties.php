<?php
include '../includes/config.inc';
$state = $_POST['state'];
// define the table to use for this topic
$table = "Test_3_9";

function queryAllDB($query,$query_params){
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
$query = "SELECT distinct NAME,GEOID FROM " . $table . " WHERE STATE =? AND SUMLEVEL = 50";
$query_params = array($state);
$counties = queryAllDB($query,$query_params);

$geo_options = ''; 
foreach ($counties as $row) {
$geo_options .= '<option value="'.$row['GEOID'].'">'.$row['NAME'].'</option>';
}
	 
echo '<label for="county">3. Choose a county</label> <select id="county" name="geoid">'.$geo_options.'</select>';

?>