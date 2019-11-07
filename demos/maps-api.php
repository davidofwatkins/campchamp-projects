<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map-canvas { 
		width: 500px;
		height: 500px;
		margin: 200px auto;
		box-shadow: 0 0 20px gray;
		border: 1px solid black;
	}
    </style>
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?sensor=false">
    </script>
    <script type="text/javascript">
	function initialize() {
		var mapOptions = {
			center: new google.maps.LatLng(44.473336, -73.204804),
			zoom: 19,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
		
		var myLatlng = new google.maps.LatLng(44.473336, -73.204804);
		var marker = new google.maps.Marker({
			position: myLatlng,
			map: map,
			title: "Cushing Hall!"
		});
		
		google.maps.event.addListener(map, 'click', function(event) {
		   alert('Lat: ' + event.latLng.lat() + ' and Longitude is: ' + event.latLng.lng());
		});
	}
	google.maps.event.addDomListener(window, 'load', initialize);
    </script>
  </head>
  <body>
    <div id="map-canvas"/>
  </body>
</html>