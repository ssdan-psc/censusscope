<?php

function get_cols($topic, $chart, $conn,$measures) {
	//$query = "SELECT measure, label FROM censcope_measures WHERE subject=" . "'" . $topic . "'" . " LIMIT 22";
    //$query = "SELECT measure, label FROM censcope_measures WHERE subject=" . "'" . $topic . "'";
    //$query = "SELECT measure, label FROM censcope_measures WHERE subject=" . "'" . $topic . "' AND (measure = 'B50111' OR measure = 'B50110' OR measure = 'B50112')";
    
    if(count($measures)>0){
    $where_measures = '';
    $i = 0;
    foreach($measures as $measure) {
    if($i == 0){
    	$where_measures .= "measure = '".$measure."'";
    }
    else {
    	$where_measures .= " OR measure = '".$measure."'";
    }
    $i++;
    }
    $query = "SELECT measure, label FROM censcope_measures WHERE subject=" . "'" . $topic . "' AND (".$where_measures.");";
	}
	else {
	$query = "SELECT measure, label FROM censcope_measures WHERE subject=" . "'" . $topic . "';";
	}
    
    //die($query);
    
    $cols = array();    // cols = [[col0, label0], [col1, label1], ... , [coln, labeln]]
    foreach ($conn->query($query) as $row) {
    	array_push($cols, array('col' => $row['measure'], 'label' => $row['label']));
    }
    return $cols;
}

?>