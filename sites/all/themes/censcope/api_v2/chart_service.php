<?php
define('DRUPAL_ROOT', '../../../../..');
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
$nid = $_GET['nid'];
$section = $_GET['section'];
$node = node_load($nid);
//print_r($node);
$field_name = 'field_chart_'.$section;
$chart = $node->{$field_name}['und']['0']['value'];
/*$measures_1 = $node->field_measures['und'];
$m = '';
foreach($measures_1 as $measure){
	$m .= implode(",", $measure);
}*/
print $chart;
?>