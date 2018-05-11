<?php $page_title='Education Attainment'; ?>
<?php include '../includes/head.inc'; ?>


<?php
$m_2010 = array(
"B50505",
"B50110",
"B50111",
"B50112",
"B50512",
"B50513",
"B50113",
"B50520",
"B50521",
"B50522",
"B50523"
);

$m_2015 = array(
"B50505",
"B50110",
"B50111",
"B50112",
"B50512",
"B50513",
"B50113",
"B50520",
"B50521",
"B50522",
"B50523"
);

$m_2016 = array(
"B0001",
"B5001",
"B5024",
"B50502",
"B50503",
"B50504",
"B50505",
"B50107",
"B50108",
"B50110",
"B50111",
"B50501",
"B50512",
"B50513",
"B50112",
"B50514",
"B50515",
"B50503",
"B50516",
"B50517",
"B50504",
"B50518",
"B50519",
"B50505",
"B50520",
"B50521",
"B50523",
"B50556",
"B50557",
"B50558",
"B50559",
"B50560",
"B50561",
"B50562",
"B50563",
"B50564",
"B50565",
"B50566",
"B50567",
"B50568",
"B50569",
"B50570",
"B50571",
"B50572",
"B50573",
"B50574",
"B50575"
);

$q_2016 = getMeasures($m_2016,"2016",$geoid);
$q_2015 = getMeasures($m_2015,"2015",$geoid);
$q_2010 = getMeasures($m_2010,"2010",$geoid);

?>


<div class="row">
	
	<h1>Educational Attainment</h1>
	
	 <?php include '../includes/location.inc'; ?>

</div>
<div class="row">

	<div class="col-md-6">
	
	<p>The Census reports on the level of education attained by adults age 25 and older. Our elderly population grew up in a time when education attainment was typically lower, and college attendance was less widespread. As this population is succeeded by younger and increasingly well-educated cohorts, the percent of the population that has attained higher levels of education slowly increases. Not only has the number of diplomas and degrees increased, but their percentage in the population has also increased, indicating a growth in attainment greater than the relative growth in national population.
</p>
	
	</div>

  	<div class="col-md-6 text-center">
  	
  	<script>
  	$(document).ready(function(){
  	 $('.slider-for').slick({
  		slidesToShow: 1,
  		slidesToScroll: 1,
  		arrows: false,
  		fade: true,
  		asNavFor: '.slider-nav'
	});
	$('.slider-nav').slick({
  		slidesToShow: 3,
  		slidesToScroll: 1,
  		asNavFor: '.slider-for',
  		dots: false,
  		centerMode: true,
  		focusOnSelect: true
	});
	});
  	
  	</script>
  	<div class="slider slider-for">
	<div><img src="/new/topics/files/map-example.png" alt="" /></div>
	<div><img src="/new/topics/files/map-1.jpg" alt="" /></div>
	<div><img src="/new/topics/files/map-2.jpg" alt="" /></div>
	</div>
	<div class="slider slider-nav">
	<div><img src="/new/topics/files/map-example.png" alt="" /></div>
	<div><img src="/new/topics/files/map-1.jpg" alt="" /></div>
	<div><img src="/new/topics/files/map-2.jpg" alt="" /></div>
	</div>
  	
		
	</div>
  	
  
</div>

<div class="row well">

	<div class="col-md-6">
		

  	<canvas id="canvas1"></canvas>
  	<div id="bar-legend" class="legend"></div>
  	<script>
        var barChartData = {
            labels: ["Total Population", "Males", "Females"],
            datasets: [{
                label: ["Less than HS degree"],
                backgroundColor: "#E8DCC4",
                stack: 'Bar 1',
                data: [
                    <?php
					print $q_2016[0]["B50111"].",".$q_2016[0]["B50512"].",".$q_2016[0]["B50513"];
                    ?>
                ]
            }, 
            {
                label: ["HS Grad"],
                backgroundColor: "#C49A41",
                stack: 'Bar 1',
                data: [
                    <?php
					print            $q_2016[0]["B50112"].",".$q_2016[0]["B50514"].",".$q_2016[0]["B50515"];
					?>
                ]
            },
            {
                label: ["Some College"],
                backgroundColor: "#405578",
                stack: 'Bar 1',
                data: [  
                	<?php
					print            $q_2016[0]["B50503"].",".$q_2016[0]["B50516"].",".$q_2016[0]["B50517"];
					?>
                ]
            },
             {
                label: ["Bachelor degree"],
                backgroundColor: "#8E9094",
                stack: 'Bar 1',
                data: [
                    <?php
					print            $q_2016[0]["B50504"].",".$q_2016[0]["B50518"].",".$q_2016[0]["B50519"];
					?>
                ]
            },
            
            {
                label: ["Grad or Professional degree"],
                backgroundColor: "#4172C4",
                stack: 'Bar 1',
                data: [
                    <?php
					print            $q_2016[0]["B50505"].",".$q_2016[0]["B50520"].",".$q_2016[0]["B50521"];
					?>
                ]
            },
            
            
           
            
            ]

        };     
    </script>
  	

  	
	</div>

	<div class="col-md-6">
	
	
	
	<canvas id="canvas2"></canvas>
	<div id="line-legend" class="legend"></div>
	<script>
        var years = ["2010","2015","2016"];
        var config = {
            type: 'line',
            data: {
                labels: ["2010","2015","2016"],
                datasets: [{
                    label: "LTHS (Total)",
                    backgroundColor: "#E8DCC4",
                    borderColor: "#E8DCC4",
                    data: [
                       <?php print            $q_2010[0]["B50111"].",".$q_2015[0]["B50111"].",".$q_2016[0]["B50111"];
					?>
                    ],
                    fill: false,
                },{
                    label: "LTHS (Males)",
                    backgroundColor: "#C4BAA6",
                    borderColor: "#C4BAA6",
                    data: [
                       <?php print            $q_2010[0]["B50512"].",".$q_2015[0]["B50512"].",".$q_2016[0]["B50512"];
					?>
                    ],
                    fill: false,
                },{
                    label: "LTHS (Females)",
                    backgroundColor: "#857E70",
                    borderColor: "#857E70",
                    data: [
                       <?php print            $q_2010[0]["B50513"].",".$q_2015[0]["B50513"].",".$q_2016[0]["B50513"];
					?>
                    ],
                    fill: false,
                },{
                    label: "Bachelors or greater (Total)",
                    backgroundColor: "#8E9094",
                    borderColor: "#8E9094",
                    data: [
                       <?php print            $q_2010[0]["B50110"].",".$q_2015[0]["B50110"].",".$q_2016[0]["B50110"];
					?>
                    ],
                    fill: false,
                },{
                    label: "Bachelors or greater (Males)",
                    backgroundColor: "#535457",
                    borderColor: "#535457",
                    data: [
                       <?php print            $q_2010[0]["B50522"].",".$q_2015[0]["B50522"].",".getMeasure("B50522","2016",$geoid);
					?>
                    ],
                    fill: false,
                },{
                    label: "Bachelors or greater (Females)",
                    backgroundColor: "#3B3C3D",
                    borderColor: "#3B3C3D",
                    data: [
                       <?php print            $q_2010[0]["B50523"].",".$q_2015[0]["B50523"].",".$q_2016[0]["B50523"];
					?>
                    ],
                    fill: false,
                },{
                    label: "Graduate or professional degree (total)",
                    backgroundColor: "#4172C4",
                    borderColor: "#4172C4",
                    data: [
                       <?php print            $q_2010[0]["B50505"].",".$q_2015[0]["B50505"].",".$q_2016[0]["B50505"];
					?>
                    ],
                    fill: false,
                },{
                    label: "Graduate or professional degree (males)",
                    backgroundColor: "#365FA3",
                    borderColor: "#365FA3",
                    data: [
                       <?php print            $q_2010[0]["B50520"].",".$q_2015[0]["B50520"].",".$q_2016[0]["B50520"];
					?>
                    ],
                    fill: false,
                },{
                    label: "Graduate or professional degree (females)",
                    backgroundColor: "#1D3257",
                    borderColor: "#1D3257",
                    data: [
                       <?php print            $q_2010[0]["B50521"].",".$q_2015[0]["B50521"].",".$q_2016[0]["B50521"];
					?>
                    ],
                    fill: false,
                }
                ]
            },
            options: {
            	
            	legend:{
                		display: false,
                		position: 'bottom'
                },
                legendCallback: function(chart) {
   						 var text = [];
    				     text.push('<ul>');
                         for (var i=0; i<chart.data.datasets.length; i++) {
                        
                         text.push('<li>');
                         text.push('<span class="legend-box" style="background-color:' +    chart.data.datasets[i].backgroundColor + '"></span> ' + chart.data.datasets[i].label);
                          text.push('</li>');
                }
                    text.push('</ul>');
                    return text.join("");
  				},
            
                responsive: true,
                title:{
                    display:true,
                    text:'Educational Attainment Rates for Age 25+, 2010-2016*'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Year'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Percentage'
                        }
                    }]
                }
            }
        };

        window.onload = function() {
            
            // Line chart
            var ctx = document.getElementById("canvas2").getContext("2d");
            window.myLine = new Chart(ctx, config);
            
            
            
            // Bar chart
            var ctx = document.getElementById("canvas1").getContext("2d");
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                options: {
                
                	legend:{
                		display: false,
                		position: 'bottom'
                	},
                	 legendCallback: function(chart) {
   						 var text = [];
    				     text.push('<ul>');
                         for (var i=0; i<chart.data.datasets.length; i++) {
                    
                         text.push('<li>');
                         text.push('<span class="legend-box"  style="background-color:' +    chart.data.datasets[i].backgroundColor + '"></span> ' + chart.data.datasets[i].label);
                          text.push('</li>');
                    }
                    text.push('</ul>');
                    return text.join("");
  					},
                
                    title:{
                        display:true,
                        text:"Educational Attainment for Age 25+ in Selected Groups, 2016*"
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false
                    },
                    responsive: true,
                    scales: {
                        xAxes: [{
                            stacked: true,
                        }],
                        yAxes: [{
                            stacked: true
                        }]
                    }
                }
            });
            
            
            document.getElementById('bar-legend').innerHTML = myBar.generateLegend();
             
             document.getElementById('line-legend').innerHTML = myLine.generateLegend();
            
            
        };
    </script>
	
	
	
	
	
	</div>

</div>

<div class="row">


	<div class="col-md-6">
	
	<div class="table-responsive">	
		<table class="data-table table-striped table-hover">
		<caption>Educational Attainment for Age 25+ in Selected Groups, 2016*</caption>
		<thead>
		<tr>
			<th>Group</th>
			<th>Number</th>
			<th>Percent</th>
		</tr>	
		</thead>
		<tbody>
		<tr>
			<td>Total Population</td>
			<td>
			<?php print number_format($q_2016[0]["B0001"]); ?>
			</td>
			<td></td>
		</tr>
		<tr>
			<td>Total Population 25 and over</td>
			<td>
			<?php print number_format($q_2016[0]["B5001"]); ?>
			</td>
			<td></td>
		</tr>
		<tr>
			<td>Less than High School Degree</td>
			<td>
			<?php print number_format($q_2016[0]["B50107"]); ?>
			</td>
			<td>
			<?php print $q_2016[0]["B50111"]; ?>%
			</td>
		</tr>
		<tr>
			<td>High school graduate</td>
			<td>
			<?php print number_format($q_2016[0]["B50108"]); ?>
			</td>
			<td>
			<?php print $q_2016[0]["B50112"]; ?>%
			</td>
		</tr>
		<tr>
			<td>Some college or Associate's Degree</td>
			<td>
			<?php print number_format($q_2016[0]["B50501"]); ?>
			</td>
			<td>
			<?php print $q_2016[0]["B50503"]; ?>%
			</td>
		</tr>
		<tr>
			<td>Bachelor's degree</td>
			<td>
			<?php print number_format($q_2016[0]["B5024"]); ?>
			</td><td>
			<?php print $q_2016[0]["B50504"]; ?>%
			</td>
		</tr>
		<tr>
			<td>Graduate or professional degree</td>
			<td>
			<?php print number_format($q_2016[0]["B50502"]); ?>
			</td><td>
			<?php print $q_2016[0]["B50505"]; ?>%
			</td>
		</tr>
		<tr>
			<td>25 to 34 Less than High School Deg</td>
			<td>
			<?php print number_format($q_2016[0]["B50556"]); ?>
			</td><td>
			<?php print $q_2016[0]["B50561"]; ?>%
			</td>
		</tr>
		<tr>
			<td>25 to 34 Bachelor's Deg or higher</td>
			<td>
			<?php print number_format($q_2016[0]["B50557"]); ?>
			</td><td>
			<?php print $q_2016[0]["B50562"]; ?>%
			</td>
		</tr>
		<tr>
			<td>25 to 34 Grad or Prof Degree</td>
			<td>
			<?php print number_format($q_2016[0]["B50558"]); ?>
			</td><td>
			<?php print $q_2016[0]["B50563"]; ?>%
			</td>
		</tr>
		<tr>
			<td>65+ Less than High School Deg</td>
			<td>
			<?php print number_format($q_2016[0]["B50566"]); ?>
			</td><td>
			<?php print $q_2016[0]["B50571"]; ?>%
			</td>
		</tr>
		<tr>
			<td>65+ Bachelor's Degree or higher</td>
			<td>
			<?php print number_format($q_2016[0]["B50567"]); ?>
			</td><td>
			<?php print $q_2016[0]["B50572"]; ?>%
			</td>
		</tr>
		<tr>
			<td>65+ Graduate or professional degree</td>
			<td>
			<?php print number_format($q_2016[0]["B50568"]); ?>
			</td><td>
			<?php print $q_2016[0]["B50573"]; ?>%
			</td>
		</tr>
		<tr>
			<td>Male, 25 to 34 Bachelor's Deg or Higher</td>
			<td>
			<?php print number_format($q_2016[0]["B50559"]); ?>
			</td><td>
			<?php print $q_2016[0]["B50564"]; ?>%
			</td>
		</tr>
		<tr>
			<td>Female, 25 to 34, Bachelor's Deg or Higher</td>
			<td>
			<?php print number_format($q_2016[0]["B50560"]); ?>
			</td><td>
			<?php print $q_2016[0]["B50565"]; ?>%
			</td>
		</tr>
		<tr>
			<td>Male, 65+, Bachelor's Deg or Higher</td>
			<td>
			<?php print number_format($q_2016[0]["B50569"]); ?>
			</td><td>
			<?php print $q_2016[0]["B50574"]; ?>%
			</td>
		</tr>
		<tr>
			<td>Female, 65+, Bachelor's Deg or Higher</td>
			<td>
			<?php print number_format($q_2016[0]["B50570"]); ?>
			</td><td>
			<?php print $q_2016[0]["B50575"]; ?>%
			</td>
		</tr>
		</tbody>
		</table>
	
	</div>
	</div>
	<div class="col-md-6"></div>

</div>



<?php include '../includes/foot-note.inc'; ?>

<?php include '../includes/foot.inc'; ?>