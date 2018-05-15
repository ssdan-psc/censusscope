<?php 
// enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// define the table to use for this topic
//$table = "combined101415";
$table = "Test_3_9";

// include the databse code
include 'database.inc';
include 'states.inc';
?>
<!DOCTYPE html>
<html>
<head>
<title><?php print $page_title.' | '.$location; ?></title>
<style>
@import url("http://www.censusscope.org/new/sites/all/themes/censcope/css/bootstrap.css?p2cvwb");
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
<script src="/new/topics/js/topics.js"></script>
<link href="/new/topics/css/style.css" rel="stylesheet" type="text/css" />
<link href="https://use.fontawesome.com/releases/v5.0.7/css/all.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="../slick/slick-theme.css"/>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>
<script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

</head>
<body >



<header>
<div class="container">

<div class="row">
	<div class="col-md-12">
	<p class="site-name">CensusScope</p>

	
	
	
	
<!-- begin menu -->	

<nav role="navigation">
<ul class="menu nav navbar-nav"><li class="first leaf"><a href="/new/about">About</a></li>
<li class="last expanded dropdown"><a href="/new/topics/educational-attainment" title="" data-target="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Topics <span class="caret"></span></a><ul class="dropdown-menu"><li class="first leaf"><a href="http://www.censusscope.org/new/topics/topic/educational-attainment.php" title="">Educational Attainment</a></li>
<li class="last leaf"><a href="http://www.censusscope.org/new/topics/topic/poverty.php" title="">Poverty</a></li>
</ul></li>
</ul>
</nav>
	
<!-- end menu -->	
	
	
	
	
	
	
	</div>
</div>

</div>
</header>

<div class="main-container container-fluid topic-page">
<div class="container">



