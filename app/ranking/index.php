<?php $page_title='Educational Attainment Population Ranking'; ?>
<?php include '../includes/head.inc'; ?>

<div class="row">
	
	<h1>Educational Attainment Ranking of Population 25 and Over</h1>
	
	 <?php //include '../includes/location.inc'; ?>

</div>
<script>
$(document).ready( function () {

	$('input[name=sumlev]').on('change', function() {
		$('#sumlevchange').submit();
	});
	
    $('#ranking').DataTable({
    	 "pageLength": 100,
    	 "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]]
    	 //"order": [4, 'desc'] 
    });
});
</script>
<div class="row">
<?php
if(isset($_GET['sumlev'])){
	 $sumlev = $_GET['sumlev'];
}
else {
	$sumlev = "310";
}
?>

<div class="col-md-12">
	
<form id="sumlevchange" action="index.php" method="get">
<p>Select the geographical units you want ranked.</p>
<div><input type="radio" name="sumlev" value="310" id="metros-radio" <?php if( $sumlev == '310'){print 'checked';}?>/> <label for="metros-radio">Metros</label></div>
<div><input type="radio" name="sumlev" value="40"  id="states-radio" <?php if( $sumlev == '40'){print 'checked';}?>/> <label for="states-radio">States</label></div>
</form>
	
<?php
/*
Pull measures B50107, B50111, B5024, B50504, B50502, B50505, B5001 
for states (SUMLEVEL = 40), metros (SUMLEVEL = 310) , counties
*/
	
$m_2016 = array(
"B50107",
"B50111", 
"B5024",
"B50504",
"B50502",
"B50505",
"B5001" 
);



$q_2016 = getMeasuresByGeoLevel($m_2016,"2016",$sumlev);


print '<div class="table-responsive">';
print '<table id="ranking" class="data-table table-striped table-hover">';
print '<caption>Educational Attainment of Population 25 and Over for Metro Areas Ranked by Percent</caption>';
print '<thead>';
print '<tr>';
print '<th>Metro Area</th>';
print '<th>Number LTHS</th>';
print '<th>LTHS %</th>';
print '<th>Number of Bachelor Degree</th>';
print '<th>Bachelor Degree %</th>';
print '<th>Grad. Degree #</th>';
print '<th>Grad. Degree %</th>';
print '<th>Universe (Total Pop. Age 25+)</th>';
print '</tr>';
print '</thead>';
print '<tbody>';
foreach($q_2016 as $key => $val) {
	print '<tr>';
	print '<td>'.$val["NAME"].'</td>';
	print '<td>'.$val["B50107"].'</td>';
	print '<td>'.$val["B50111"].'</td>';
	print '<td>'.$val["B5024"].'</td>';
	print '<td>'.$val["B50504"].'</td>';
	print '<td>'.$val["B50502"].'</td>';
	print '<td>'.$val["B50505"].'</td>';
	print '<td>'.$val["B5001"].'</td>';
	print '</tr>';
}
print '</tbody>';
print '</table>';
print '</div>';



?>
	
</div>


</div>


<?php //include '../includes/foot-note.inc'; ?>

<?php include '../includes/foot.inc'; ?>