<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html>
<head>
<title></title>
<style>
@import url("http://www.censusscope.org/new/sites/all/themes/censcope/css/bootstrap.css?p2cvwb");
</style>
</head>
<body >
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
<script src="/new/topics/js/topics.js"></script>
<link href="/new/topics/css/style.css" rel="stylesheet" type="text/css" />
<link href="https://use.fontawesome.com/releases/v5.0.7/css/all.css" rel="stylesheet">


<header>
<div class="container">

<div class="row">
	<div class="col-md-12">
	<p class="site-name">CensusScope</p>
	</div>
</div>

</div>
</header>

<div class="main-container container-fluid topic-page">
<div class="container">

<?php 
// enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// define the table to use for this topic
//$table = "combined101415";
$table = "Test_3_9";

// include the databse code
include 'database-dev.inc';
include 'states.inc';
?>

