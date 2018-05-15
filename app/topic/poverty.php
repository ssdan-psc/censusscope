<?php $page_title='Poverty'; ?>
<?php include '../includes/head.inc'; ?>
<?php

$m_2016 = array(
"B0001",
"B1009",
"B1012",
"B1013",
"B1014",
"B1015",
"B1016",
"B1017",
"B1160",
"B1161",
"B1162",
"B1163",
"B1164",
"B1165",
"B1177",
"B1178",
"B1179",
"B1180",
"B1181",
"B1182",
"B1194",
"B1197",
"B1195",
"B1196",
"B1198",
"B1199",
"B1202",
"B1207",
"B1223",
"B1224",
"B1225",
"B1226",
"B1227",
"B1228",
"B1229",
"B1230",
"B1231",
"B1232",
"B1239",
"B1240",
"B1241",
"B1242",
"B1244",
"B1252",
"B1253",
"B1246",
"B1254",
"B1248",
"B1255",
);


$m_2010 = array(
"B1014",
"B1239",
"B1240",
"B1241",
"B1162",
"B1179",
"B1196",
"B1229",
"B1232"
);


$m_2015 = array(
"B1014",
"B1239",
"B1240",
"B1241",
"B1162",
"B1179",
"B1196",
"B1229",
"B1232"
);

$q_2016 = getMeasures($m_2016,"2016",$geoid);
$q_2010 = getMeasures($m_2010,"2010",$geoid);
$q_2015 = getMeasures($m_2015,"2015",$geoid);
?>
<div class="row">
	
	<h1>Poverty</h1>
	
	 <?php include '../includes/location.inc'; ?>

</div>
<div class="row">

	<div class="col-md-6">
	
	<p>The 2016 poverty threshold for a family of four in the continental United States with two related children was $xx,xxx. However, poverty thresholds are misleading because they do not provide an accurate picture of what a “poor” family’s life is like. According to the National Center for Children in poverty, most families of four would have to make twice their assigned Poverty Threshold in order to provide their children with basic necessities, such as housing, food, and health care.</p>
	
	</div>

  	<div class="col-md-6 text-center">
		<img src="/new/topics/files/map-example.png" alt="" />
	</div>
  	
  
</div>

<div class="row well">

	<div class="col-md-6">
		

  	<canvas id="canvas1"></canvas>
  	<div id="bar-legend" class="legend"></div>
  	<script>
        var barChartData = {
            labels: ["Total Population", "Under 18", "18 to 64","65 and over"],
            datasets: [{
                label: ["Less than 50% of Poverty Level"],
                backgroundColor: "#E8DCC4",
                stack: 'Bar 1',
                data: [
                    <?php
					print $q_2016[0]["B1012"].",".$q_2016[0]["B1160"].",".$q_2016[0]["B1177"].",".$q_2016[0]["B1194"];
                    ?>
                ]
            }, 
            {
                label: ["50 to 99% of Poverty Level"],
                backgroundColor: "#C49A41",
                stack: 'Bar 1',
                data: [
                    <?php
					print            $q_2016[0]["B1013"].",".$q_2016[0]["B1161"].",".$q_2016[0]["B1178"].",".$q_2016[0]["B1195"];
					?>
                ]
            },
            {
                label: ["100 to 149% of Poverty Level"],
                backgroundColor: "#405578",
                stack: 'Bar 1',
                data: [  
                	<?php
					print            $q_2016[0]["B1015"].",".$q_2016[0]["B1163"].",".$q_2016[0]["B1180"].",".$q_2016[0]["B1197"];
					?>
                ]
            },
             {
                label: ["150 to 199% of Poverty Level"],
                backgroundColor: "#8E9094",
                stack: 'Bar 1',
                data: [
                    <?php
					print            $q_2016[0]["B1016"].",".$q_2016[0]["B1164"].",".$q_2016[0]["B1181"].",".$q_2016[0]["B1198"];
					?>
                ]
            },
            
            {
                label: ["200% or more of Poverty Level"],
                backgroundColor: "#4172C4",
                stack: 'Bar 1',
                data: [
                    <?php
					print            $q_2016[0]["B1017"].",".$q_2016[0]["B1165"].",".$q_2016[0]["B1182"].",".$q_2016[0]["B1199"];
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
                    label: "Total",
                    backgroundColor: "#E8DCC4",
                    borderColor: "#E8DCC4",
                    data: [
                       <?php print            $q_2010[0]["B1014"].",".$q_2015[0]["B1014"].",".$q_2016[0]["B1014"];
					?>
                    ],
                    fill: false,
                },{
                    label: "Nativity (Native Born)",
                    backgroundColor: "#C4BAA6",
                    borderColor: "#C4BAA6",
                    data: [
                       <?php print            $q_2010[0]["B1239"].",".$q_2015[0]["B1239"].",".$q_2016[0]["B1239"];
					?>
                    ],
                    fill: false,
                },{
                    label: "Nativity (Foreign-Born, Naturalized Citizen)",
                    backgroundColor: "#857E70",
                    borderColor: "#857E70",
                    data: [
                       <?php print            $q_2010[0]["B1240"].",".$q_2015[0]["B1240"].",".$q_2016[0]["B1240"];
					?>
                    ],
                    fill: false,
                },{
                    label: "Nativity (Foreign-Born, Non-citizen)",
                    backgroundColor: "#8E9094",
                    borderColor: "#8E9094",
                    data: [
                       <?php print            $q_2010[0]["B1241"].",".$q_2015[0]["B1241"].",".$q_2016[0]["B1241"];
					?>
                    ],
                    fill: false,
                },{
                    label: "Age (Less than 18)",
                    backgroundColor: "#535457",
                    borderColor: "#535457",
                    data: [
                       <?php print            $q_2010[0]["B1162"].",".$q_2015[0]["B1162"].",".$q_2016[0]["B1162"];
					?>
                    ],
                    fill: false,
                },{
                    label: "Age (18-64)",
                    backgroundColor: "#3B3C3D",
                    borderColor: "#3B3C3D",
                    data: [
                       <?php print            $q_2010[0]["B1179"].",".$q_2015[0]["B1179"].",".$q_2016[0]["B1179"];
					?>
                    ],
                    fill: false,
                },{
                    label: "Age (65+)",
                    backgroundColor: "#4172C4",
                    borderColor: "#4172C4",
                    data: [
                       <?php print            $q_2010[0]["B1196"].",".$q_2015[0]["B1196"].",".$q_2016[0]["B1196"];
					?>
                    ],
                    fill: false,
                },{
                    label: "Education (Less than HS)",
                    backgroundColor: "#365FA3",
                    borderColor: "#365FA3",
                    data: [
                       <?php print            $q_2010[0]["B1229"].",".$q_2015[0]["B1229"].",".$q_2016[0]["B1229"];
					?>
                    ],
                    fill: false,
                },{
                    label: "Education (Bachelor's Degree or higher)",
                    backgroundColor: "#1D3257",
                    borderColor: "#1D3257",
                    data: [
                       <?php print            $q_2010[0]["B1232"].",".$q_2015[0]["B1232"].",".$q_2016[0]["B1232"];
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
                    text:'Poverty Rates for Selected Groups, 2000-16*'
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
            var myBar = new Chart(ctx, {
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
                        text:" Ratio of Income to Poverty Level for Selected Groups, 2016*"
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
		<caption>Poverty Rates for Selected Groups, 2016*</caption>
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
			<td>Total Population in Poverty</td>
			<td>
			<?php print number_format($q_2016[0]["B1009"]); ?>
			</td>
			<td>
			<?php print $q_2016[0]["B1014"]; ?>%
			</td>
		</tr>
		
		<tr>
			<td><strong>Share of Seelcted Groups Living in Poverty</strong></td>
			<td></td>
			<td></td>
		</tr>
		
		<tr>
			<td>Males</td>
			<td>
			<?php print number_format($q_2016[0]["B1202"]); ?>
			</td>
			<td>
			<?php print $q_2016[0]["B1227"]; ?>%
			</td>
		</tr>
		
		<tr>
			<td>Females</td>
			<td>
			<?php print number_format($q_2016[0]["B1207"]); ?>
			</td>
			<td>
			<?php print $q_2016[0]["B1228"]; ?>%
			</td>
		</tr>
		
		<tr>
			<td>Population in Family Households</td>
			<td>
			<?php print number_format($q_2016[0]["B1242"]); ?>
			</td>
			<td>
			<?php  print $q_2016[0]["B1252"]; ?>%
			</td>
		</tr>
		
		<tr>
			<td>Population in Married-Couple Families</td>
			<td>
			<?php print number_format($q_2016[0]["B1244"]); ?>
			</td>
			<td>
			<?php print $q_2016[0]["B1253"]; ?>%
			</td>
		</tr>
		
		<tr>
			<td>Population in Single-Parent HHs (Male-headed)</td>
			<td>
			<?php print number_format($q_2016[0]["B1246"]); ?>
			</td>
			<td>
			<?php print $q_2016[0]["B1254"]; ?>
			</td>
		</tr>
		
		<tr>
			<td>Population in Single-Parent HHs (Female-headed)</td>
			<td>
			<?php print number_format($q_2016[0]["B1248"]); ?>
			</td>
			<td>
			<?php print $q_2016[0]["B1255"]; ?>%
			</td>
		</tr>
		
		<tr>
			<td>Less than High School Graduate</td>
			<td>
			<?php print number_format($q_2016[0]["B1223"]); ?>
			</td>
			<td>
			<?php print $q_2016[0]["B1229"]; ?>%
			</td>
		</tr>
		
		<tr>
			<td>High School Graduate but no further education</td>
			<td>
			<?php print number_format($q_2016[0]["B1224"]); ?>
			</td>
			<td>
			<?php print $q_2016[0]["B1230"]; ?>%
			</td>
		</tr>
		
		<tr>
			<td>Some College or Associate's Degree</td>
			<td>
			<?php print number_format($q_2016[0]["B1225"]); ?>
			</td>
			<td>
			<?php print $q_2016[0]["B1231"]; ?>%
			</td>
		</tr>
		
		<tr>
			<td>Bachelor's Degree or higher</td>
			<td>
			<?php print number_format($q_2016[0]["B1226"]); ?>
			</td>
			<td>
			<?php print $q_2016[0]["B1232"]; ?>%
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