jQuery(document).ready(function() {

	function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\jQuery&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|jQuery)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
	}

	
	var topic = getParameterByName('topic');	
	var year =  getParameterByName('year');
	var geo =  getParameterByName('geo');
    /*var param = window.location.search.substring(1).split("=")[0];
    if (param == 'topic') {
        var topic = window.location.search.substring(1).split("=")[1];
    } 
    else {
        console.log("Need topic"); // TODO: Change error message & handling
    }*/

    var pieChart;
    var lineChart;
    var barChart;
    var table = document.getElementById("Table");
    var pyramidChart;

    var pie_ctx = document.getElementById("pieChart");
    var line_ctx = document.getElementById("lineChart");
    var bar_ctx = document.getElementById("barChart");
    var pyramid_ctx = document.getElementById("pyramidChart");

    var pie_csv;
    var trend_csv;
    var stacked_csv;
    var table_csv;
    var pyramid_csv;
    
    


    var pyramid_opts = {
        "options": {
            "scales": {
                "xAxes": [{
                    "stacked": true,
                    "ticks": {
                        "callback": function(value, index, values) {
                            return Math.abs(value);
                        }
                    }
                }],
                "yAxes": [{
                    "stacked": true
                }]
            },
            "tooltips": {
                "callbacks": {
                    "label": function(tooltipItems, data) {
                        return Math.abs(parseInt(tooltipItems.xLabel))
                    }
                }
            }
        }
    };

    create_table = function(table, jsondata) {
        var thead = document.createElement('thead');
        for (var i = 0; i < jsondata[0].length; i++) {
            var th = document.createElement('th');
            th.appendChild(document.createTextNode(jsondata[0][i]));
            thead.appendChild(th);
        }

        table.appendChild(thead);

        var tbody = document.createElement('tbody');
        for (var i = 1; i < jsondata.length - 1; i++) {
            var tr = document.createElement('tr');
            for (var j = 0; j < jsondata[i].length; j++) {
                var td = document.createElement('td');
                td.appendChild(document.createTextNode(jsondata[i][j]));
                tr.appendChild(td);
            }
            tbody.appendChild(tr);
        }

        table.appendChild(tbody);

        jQuery('Table').dynatable({
            table: {
                headRowSelector: 'thead'
            },
            features: {
                paginate: false,
                search: false,
                recordCount: false,
                perPageSelect: false,
                pushState: false
            }
        });

    };

   

    download_csv = function(chartVariable) {
        var csv;

        if (chartVariable == 'pie') {
            csv = pie_csv
        } else if (chartVariable == 'trend') {
            csv = trend_csv
        } else if (chartVariable == 'stacked') {
            csv = stacked_csv
        } else if (chartVariable == 'pyramid') {
            csv = pyramid_csv
        }

        var hiddenElement = document.createElement('a');
        hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
        hiddenElement.download = topic + '_' + chartVariable + '.csv';
        hiddenElement.click();
    };


    download_img = function(chartVariable) {

        var img;

        if (chartVariable == 'pie') {
            img = pieChart.toBase64Image();
        } else if (chartVariable == 'trend') {
            img = lineChart.toBase64Image();
        } else if (chartVariable == 'stacked') {
            img = barChart.toBase64Image();
        }

        var hiddenElement = document.createElement('a');
        hiddenElement.target = '_blank';
        hiddenElement.href = img;
        hiddenElement.download = topic + '_' + chartVariable + '.png';
        hiddenElement.click();
    };


    jQuery("#chart_form").on("submit", function (event) {
        event.preventDefault();

        var geo = jQuery('#geo').val();
        var year = jQuery( "select#year option:checked" ).val();
		var topic = jQuery('#topic').val();
        console.log('../api/api.php?method=hello&format=json&geo=' + geo + '&year=' + year + '&topic=' + topic);
        jQuery.ajax({
            async: false,
            type: 'GET',
            //url: 'http://censusscope.org/new/api/api.php?method=hello&format=json&geo=' + geo + '&year=' + year + '&topic=' + topic,
            url: '../new/sites/all/themes/censcope/api/api.php?method=hello&format=json&geo=' + geo + '&year=' + year + '&topic=' + topic,

            success: function (data) {
               
                var pie_data = data['data']['pie'];
                var trend_data = data['data']['trend']
                var stacked_data = data['data']['stacked']
                var table_data = data['data']['table']
                var pyramid_data = data['data']['pyramid']

                if ('error' in pie_data) {
                    pie_ctx.getContext('2d').font = "20px Helvetica";
                    pie_ctx.getContext('2d').fillText(pie_data['error'], 50, 50);
                } else {
                    try { 
                        //pieChart.destroy();
                    } finally {
                        console.log(pie_data);
                        var full_pie_json = JSON.parse(pie_data['chart']);
                        pie_csv = pie_data['csv'];
                        pieChart = new Chart(pie_ctx, full_pie_json);
                    }
                }
/*
                if ('error' in trend_data) {
                    line_ctx.getContext('2d').font = "20px Helvetica";
                    line_ctx.getContext('2d').fillText(trend_data['error'], 50, 50);
                } else {
                    try { 
                        lineChart.destroy(); 
                    } finally {
                        var full_line_json = JSON.parse(trend_data['chart']);
                        trend_csv = trend_data['csv'];
                        lineChart = new Chart(line_ctx, full_line_json);
                    }
                }
*/
               

               
                if ('error' in stacked_data) {
                    bar_ctx.getContext('2d').font = "20px Helvetica";
                    bar_ctx.getContext('2d').fillText(stacked_data['error'], 50, 50);
                } else {
                    try { 
                        if(barChart){barChart.destroy();}
                    } finally {
                        var full_stacked_json = JSON.parse(stacked_data['chart']);
                        
                        stacked_csv = stacked_data['csv'];
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
full_stacked_json = {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [{
                label: 'Dataset 1',
                backgroundColor: "#FF6384",
                data: [
                    '10',
                    '8',
                    '10',
                    '5',
                    '12',
                    '18',
                    '22',
                ]
            },{
                label: 'Dataset 2',
                backgroundColor: "#166a8f",
                data: [
                    '20',
                    '22',
                    '45',
                    '32',
                    '4',
                    '4',
                    '10',
                ]
            }]

        };
        
console.log(full_stacked_json);

var ctx = document.getElementById("barChart").getContext("2d");
window.myBar = new Chart(ctx, {
                type: 'bar',
                data: full_stacked_json,
                options: {
                    title:{
                        display:true,
                        text:"Test Bar Chart - Stacked"
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
                        
                        
       
                        //barChart = new Chart(bar_ctx, full_stacked_json);
                    }
                }
/*
                if ('error' in table_data) {
                    table.innerHTML = table_data['error'];
                    console.log(table_data['error']);
                } else {
                    convert_camelcase = function(str) {
                        str = str.replace('"','')
                        if (str.length == 1) {
                            return str.toLowerCase();
                        } else {
                            //From http://stackoverflow.com/questions/2970525/converting-any-string-into-camel-case
                            return str.replace(/(?:^\w|[A-Z]|\b\w|\s+)/g, function(match, index) {
                                if (+match === 0) return ""; // or if (/\s+/.test(match)) for white spaces
                                return index == 0 ? match.toLowerCase() : match.toUpperCase();
                            });
                        }
                    };

                    update_dynatable = function(table, newData) {

                        var dynatable = jQuery(table).data('dynatable');
                        var recordCount = dynatable.settings.dataset.originalRecords.length;
                
                        //remove all existing records from this table
                        for (i = 0; i < recordCount; i++) {
                            dynatable.settings.dataset.originalRecords.pop();
                        }

                        var lines = newData.split("\n");
                        lines.pop();
                        var cols = lines[0].split(",");
              
                        for (i = 1; i < lines.length; i++) {
                            var newRecord = {}
                            var entries = lines[i].split(",")
                            for (j = 0; j < entries.length; j++) {
                                var colCamel = convert_camelcase(cols[j]);
                                newRecord[colCamel] = entries[j];
                            }
                            dynatable.settings.dataset.originalRecords.push(newRecord)
                        }
                
                        dynatable.process();
                    };

                    update_dynatable(table, data['data']['table']['csv']);

                }

                if ('error' in pyramid_data) {
                    pyramid_ctx.getContext('2d').font = "20px Helvetica";
                    pyramid_ctx.getContext('2d').fillText(pyramid_data['error'], 50, 50);
                } else {
                    try { 
                        pyramidChart.destroy();
                    } finally {
                        var partial_json = JSON.parse(pyramid_data['chart']);
                        var full_pyramid_json = jQuery.extend({}, partial_json, pyramid_opts);
                        pyramid_csv = pyramid_data['csv'];
                        pyramidChart = new Chart(pyramid_ctx, full_pyramid_json)
                    }
                }*/

            },
            error: function (xhr, status, error) {
		// TODO: 
                pie_ctx.getContext('2d').font = "20px Helvetica";
                pie_ctx.getContext('2d').fillText(xhr.status + ' Error: ' + xhr.responseText, 50, 50);
            }

        });
    });
});
