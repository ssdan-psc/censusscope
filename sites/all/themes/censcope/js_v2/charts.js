jQuery(document).ready(function() {

     var countyCook = getCookie("county");
	 var stateCook = getCookie("stateId");
	 var stateName = getCookie("state");
     
     if (stateCook != "" && stateCook != null) {
     	setGeo(stateCook,stateName,countyCook);
     }
     
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
	
	var geo =  getParameterByName('geo');
	
	var newurl = new URL(window.location.href);
    var searchParams = newurl.searchParams;

	var measures = searchParams.getAll("measures[]");
	var year =  searchParams.getAll('year[]');

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

	

    

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCookie() {
    var user = getCookie("username");
    if (user != "") {
        alert("Welcome again " + user);
    } else {
        user = prompt("Please enter your name:", "");
        if (user != "" && user != null) {
            setCookie("username", user, 365);
        }
    }
}

function setGeo(stateCook,stateName,countyCook){
	 jQuery('#geo').val(stateName);
     showCounties(stateCook,stateName,countyCook);
}
window.getMeasure = function(mid,year,geoid) {

	$.ajax({
        type: 'POST',
        dataType: 'text',
        url: 'http://www.censusscope.org/new/sites/all/themes/censcope/api_v2/get_measure.php',
        data: {
        	mid: mid,
        	year: year,
        	geoid: geoid
        },
        success: function (data) {
        	return data;
        }
    });
    
}

function showCounties(state,statename,county){
	 $.ajax({
        type: 'POST',
        dataType: 'html',
        url: 'http://www.censusscope.org/new/sites/all/themes/censcope/api_v2/get_counties.php',
        data: {state: state},
        success: function (data) {
        	$('#county-wrapper').empty();
        	$('#county-wrapper').append(data);
        },
        complete: function(data) {
        	if(county !== null && county !==''){jQuery('#county').val(county);}
        	//updateResults();
        }
    });
}    
    
function updateResults(formid,geoid){
		
		var geo ='';
		var state = '';
		var year = '';
        state = jQuery('#geo').val();
        stateId = jQuery('#geo').find(':selected').data('state');
			
		// set state cookies
        setCookie("state", state, 365);
        setCookie("stateId", stateId, 365);
        	
        var county= jQuery('#county').val();

        // set county cookie
        setCookie("county", county, 365);   
        
        if(county !== null && county !=''){
        	geo = county;
        }
        else {
        	geo = state;
        }
		console.log(geo);
		var topic = jQuery('#topic').val();
		var measures_string = '';
		
		var form = '';
		if(formid){
		form = '#'+formid;
		}
		else {
		form = '#chart_form';
		}
		
		var m_selector = form + ' input[name^="measures"]';
		var y_selector = form + " select#year option:checked";
		
		$(m_selector).each(function() {
    		var m = $(this).val();
    		measures_string += '&measures%5B%5D=' + m;
		});

		$(y_selector).each(function() {
    		var y = $(this).val();
    		year += '&year%5B%5D=' + y;
		});

		/*
		$.each(measures, function (index,value) {
			measures_string += '&measures%5B%5D=' + value;
		});
		*/
		
		
		var chart1 = document.getElementById("chart_1").getContext("2d");
		renderChart1(chart1,geo);
		
	/*	

        jQuery.ajax({
            async: false,
            type: 'GET',
            url: 'http://censusscope.org/new/sites/all/themes/censcope/api_v2/api.php?method=hello&format=json&geo=' + geo + '&year=' + year + '&topic=' + topic + measures_string,

      success: function (data) {
   
       var chartnum =  form.substr(form.length - 1);
       var chartFunc = 'renderChart'+chartnum;
        try { 
         if(window['barChart'+chartnum]){window['barChart'+chartnum].destroy();}
        } 
        finally {
         window['ctx'+chartnum]
          = document.getElementById("chart_"+chartnum).getContext("2d");
         window[chartFunc](window['ctx'+chartnum],data);
		}

            },
      error: function (xhr, status, error) {
			console.log(error);
            }

        });
        
        */
	}    

	jQuery(document).ready(function(){
		//updateResults();
	});

    jQuery("#chart_form").on("submit", function (event) {
        event.preventDefault();
    	var forms = $('.chart_form');
    	var geoid = $('#county').val();
    	$(forms).each(function(){
    		var formid = $(this).attr('id');
    		updateResults(formid,geoid);
    	});
    });
    
    jQuery('#geo').on("change",function(event){
    	event.preventDefault();
    	var state = jQuery('#geo').find(':selected').data('state');
    	showCounties(state);
    });
    
});