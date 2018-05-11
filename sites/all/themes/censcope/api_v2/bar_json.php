<?php

function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}

function bar_json($data_labels,$data,$year){

$data_combined = array_combine($data_labels,$data);
$datasets = array();

foreach($data_combined as $key => $val){
	$datasets[] = array(
			'label' => $key,
         	'backgroundColor'=> '#'.random_color(),
         	'data' => array($val)
         	);
}

$full_stacked_json = array(
         'labels' => array($year),
         'datasets' => $datasets
);

/*
example:
$full_stacked_json = array(
         'labels' => array('2010'),
         'datasets' => array(   	
         	array(
         	'label' => 'Percent population 25 years and over Bachelors degree or higher',
         	'backgroundColor'=> '#FF6384',
         	'data' => array('20')
         	),
         	array(
         	'label' => 'Percent population less than high school graduate - GED - or equivalent',
         	'backgroundColor'=> '#166a8f',
         	'data' => array('8')
         	)
         ),
     );
*/

return $full_stacked_json;
}
?>