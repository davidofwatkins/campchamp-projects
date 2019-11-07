<div id="browser-welcome">
    <h1>Welcome</h1>
    <h2>to the new Champlain College housing registration center</h2>
    <!--<iframe id="mapframe" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=champlain+college&amp;ie=UTF8&amp;hq=champlain+college&amp;t=v&amp;ll=44.474908,-73.203856&amp;spn=0.00647,0.00649&amp;output=embed&iwloc=near"></iframe>-->
    
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript">
        //Initialize Google Map!
	function initialize() {
		var mapOptions = {
			center: new google.maps.LatLng(44.473336, -73.204804),
			zoom: 16,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		var map = new google.maps.Map(document.getElementById("mapframe"), mapOptions);
		
                <?
                
                    foreach ($hallDetails as $hall) {
                        echo 'var marker = new google.maps.Marker({';
                        echo 'position: new google.maps.LatLng(' . $hall["Hall"]["map_coords"] . '),';
                        echo 'map: map,';
                        echo 'title: "' . $hall["Hall"]["name"] . '"';
                        echo '});';
                    }
                
                ?>
                
		var centralCampus = new google.maps.Marker({
			position: new google.maps.LatLng(44.47334717045448, -73.20396423339844 ),
			map: map,
			title: "Central Campus",
                        icon: "<?= $this->webroot ?>/img/maps-marker-blue-c.png"
		});
		
                google.maps.event.addListener(map, 'click', function(event) {
		   console.log(event.latLng.lat() + ',' + event.latLng.lng());
		});
	}
	google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    
    
    <div id="mapframe"></div>
    <p id="welcome-message">
        To get started, take a look at some of our residence halls to the left. Once you think you've found a good fit, select a room and we'll guide you through the rest. If you need assistance at any time, please do not hesitate to call the department of residential life at (802) 860-2702.
    </p>
</div>