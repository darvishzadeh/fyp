<script src="http://maps.googleapis.com/maps/api/js"></script>

<div class="row">
	<div class="col-md-0 col-sm-8">
		<div id="map-wrapper">
				<div id="map-canvas" class="mapping"></div>
		</div>
	</div>


	<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.1','packages':['gauge']}]}"></script>

	
	<div class="col-md-4 col-sm-4">
		<div id="gauges"></div>
	</div>
</div>

<hr />

<?php

$query = $conn->query("SELECT `id`, `latlong` FROM `stations`;");


$row = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<script>
var visibleMarkers = [];
(function() {
	var locations = [
	<?php
	foreach ($row as $value) {
		$latLong = explode(',', $value['latlong']);
		echo "\t['Station #" . $value['id'] . "', " . $latLong[0] . ", " . $latLong[1] . ", " . $value['id'] . "]";
		if (end($row) != $value)
			echo ",\n";
		else
			echo "\n";
	}
	?>
	];


	var map = new google.maps.Map(document.getElementById("map-canvas"), {
		zoom: 14,
		center: new google.maps.LatLng(31.0698849,101.6933901),
		mapTypeId: google.maps.MapTypeId.TERRAIN
	});

	var infowindow = new google.maps.InfoWindow();

	var allMarkers = [];
	var marker, i;
	var bounds = new google.maps.LatLngBounds();


	for (i = 0; i < locations.length; i++) {  
		marker = new google.maps.Marker({
			stationId: locations[i][3],
			position: new google.maps.LatLng(locations[i][1], locations[i][2]),
			map: map
		});

		bounds.extend(marker.position);

		allMarkers.push(marker);

		google.maps.event.addListener(marker, 'click', (function(marker, i) {
			return function() {
				infowindow.setContent('<a target="_blank" href="./?p=station&id=' + marker.stationId + '">' + locations[i][0] + '</a>');
				infowindow.open(map, marker);
			}
		})(marker, i));
	}



	var chart = new google.visualization.Gauge(document.getElementById('gauges'));

	var options = {
		width: 250, height: 520,
		redFrom: 90, redTo: 100,
		yellowFrom:75, yellowTo: 90,
		minorTicks: 5
	};

	function refreshData (visibleMarkers) {
		$.post( "gauges.php", { 'stations[]': visibleMarkers } ).done(function( response ) {
			data = google.visualization.arrayToDataTable(JSON.parse(response));
			chart.draw(data, options);
		});		
	}



	map.fitBounds(bounds);

	google.maps.event.addListener(map,'idle', function (){
		visibleMarkers = [];
		$('#listOfItems').empty().html('<ul></ul>');
		for (var i = 0; i < allMarkers.length; i++) {
			if (map.getBounds().contains(allMarkers[i].getPosition())) {
				visibleMarkers.push(allMarkers[i]['stationId']);
			}
		}
		refreshData(visibleMarkers);
	});

	google.maps.event.addDomListener(window, "resize", function() {
		var center = map.getCenter();
		google.maps.event.trigger(map, "resize");
		map.setCenter(center); 
	});
})();
</script>