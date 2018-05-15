<div class="col-md-6">
	<h3 style="display: inline-block;"><i class="fas fa-map-marker-alt"></i>
	<?php print $location; ?></h3> <a href="#" class="show-form"> change location</a>
</div>

<div class="col-md-6">	
	<form id="geo_select" action="<?php print basename($_SERVER['PHP_SELF']); ?>" type="GET" class="well">
	<div class="pull-right"><a href="#" id="hide-location">Hide</a></div>
	<h4>Change location</h4>
	<label for="level">1. Geographic Level:</label> 
	<select id="level">
			<option>-Please choose-</option>
			<option value="state">State</option>
			<option value="county">County</option>
			<option value="metro">Metro</option>
	</select>
	
	<div id="state-wrapper">
	<label for="geo">2. Choose a state:</label> 
	<select id="state">
			<option>-Please choose-</option>
			<?php print get_states('Test_3_9'); ?>
	</select>
	</div>
	
	<div id="stateselect-wrapper">
	<label for="geo">2. Choose a state:</label> 
	<select id="state-select">
			<option>-Please choose-</option>
			<?php print get_states('Test_3_9'); ?>
	</select>
	</div>
	
	<div id="county-wrapper">
	
	</div>
	
	<div id="metro-wrapper">
	</div>
	
    <input id="go-button" disabled class="btn btn-primary" type="submit" value="Show results" />
    </form>
</div>