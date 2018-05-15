$(document).ready(function() {

// show/hide the form
$('.show-form').on('click', function(event){
	event.preventDefault();
	$('#geo_select').slideDown();
});

$('#hide-location').on('click', function(event){
	event.preventDefault();
	$('#geo_select').slideUp();
});



// user changes level
$('#level').on("change",function(event){
    	event.preventDefault();
    	var level = $('#level').find(':selected').val();

    
    	// Reset form
    	$('#state').prop('name','');
    	$('#go-button').prop('disabled', true);     $('#state-wrapper,#county-wrapper,#metro-wrapper,#stateselect-wrapper').hide();
    	
    	// show states. done.
    	if(level == 'state'){
    		$('#state-wrapper').show();
    		$('#state').prop('name','geoid');
    		$('#go-button').prop('disabled', false);
    	}
    	
    	// if county show states first, then load counties
    	if(level == 'county'){
    		$('#stateselect-wrapper').show();
    	}
    	
    	// if metro, show all the metros TO-DO: let users select a state first. need a db column that relates states to metros to enable this.
    	if(level == 'metro'){
    		//$('#stateselect-wrapper').show();
    		showMetros();
    	}
    	
});


// handle state selection
$('#state-select').on("change",function(event){
    	event.preventDefault();
    	var state = $('#state-select').find(':selected').data('state');
    	var level = $('#level').find(':selected').val();
    	
    	// if level is county show counties
    	if(level == 'county') {
    		showCounties(state);
    	}
    	
    	// if level is metro show metros
    	/*if(level == 'metro') {
    		showMetros(state);
    	}*/
});


function showCounties(state){
	 $.ajax({
        type: 'POST',
        dataType: 'html',
        url: 'http://www.censusscope.org/new/topics/services/get_counties.php',
        data: {state: state},
        success: function (data) {
        	$('#county-wrapper').empty();
        	$('#county-wrapper').append(data);
        	$('#county-wrapper').show();
        	$('#go-button').prop('disabled', false);
        },
    });
} 


function showMetros(){
	 $.ajax({
        type: 'POST',
        dataType: 'html',
        url: 'http://www.censusscope.org/new/topics/services/get_metros.php',
       // data: {state: state},
        success: function (data) {
        console.log(data);
        	$('#metro-wrapper').empty();
        	$('#metro-wrapper').append(data);
        	$('#metro-wrapper').show();
        	$('#go-button').prop('disabled', false);
        },
    });
} 











/*

cookie stuff, decided not to use

     var countyCook = getCookie("county");
	 var stateCook = getCookie("stateId");
	 var stateName = getCookie("state");
     
     if (stateCook != "" && stateCook != null) {
     	setGeo(stateCook,stateName,countyCook);
     }
     
     function setGeo(stateCook,stateName){
	 $('#state').val(stateName);
     showCounties(stateCook,stateName);
}
     
function getParameterByName(name, url) {
    	if (!url) url = window.location.href;
   		name = name.replace(/[\[\]]/g, "\\$&");
    	var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    	if (!results) return null;
    	if (!results[2]) return '';
    	return decodeURIComponent(results[2].replace(/\+/g, " "));
}
	
var geo =  getParameterByName('geoid');



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

function updateCookies(geoid){
		
		var geo ='';
		var state = '';
		var year = '';
        state = $('#state').val();
        stateId = $('#state').find(':selected').data('state');
			
		// set state cookies
        setCookie("state", state, 365);
        setCookie("stateId", stateId, 365);
        	
        var county= $('#county').val();

        // set county cookie
        setCookie("county", county, 365);   
}  

*/

    
});