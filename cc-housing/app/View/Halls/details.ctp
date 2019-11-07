<?php
    echo $this->Html->css(array("confirm"));
    echo $this->Html->script(array("jquery-ui.min"));  
?>

<?php
    echo "<pre>";
    //print_r($halldata);
    //print_r($roomdata);
    //print_r($allusers);
    echo "</pre>";
    
    $hall = $halldata[0]["Hall"];
    $hallImage = $halldata[0]["HallImage"][0]["img_uri"];
    $room = $roomdata[0]["Room"];
    $numOccupied = sizeof($roomdata[0]["User"]);
    $availability = $room["max_occupancy"] - $numOccupied;
?>

<script>
    $(document).ready(function() {
        $("#chosen-roommates").autocomplete({
            source: [
                <?php
                    foreach ($allusers as $user) {
                        //echo '"' . $user["User"]["firstname"] . " " . $user["User"]["lastname"] . ' <span style=\'display: none;\'>HELLO</span>",';
                    }
                    
                    $first = true;
                    foreach ($allusers as $user) {
                        if (!$first) echo ",";
                        $first = false;
                        echo "{";
                        echo 'value: "' . $user["User"]["username"] . '",';
                        echo 'label: "' . $user["User"]["firstname"] . " " . $user["User"]["lastname"] . '",';
                        echo 'desc: "' . $user["User"]["username"] . '"';
                        echo "}";
                    }
                ?>
                /*"David Watkins",
                "Elias Ranz-Schleifer",
                "Ryan Warner",
                "Sarah Pettitt",
                "Mark Zuckerburg",
                "Kevin Rose",
                "Eric Schmidt",
                "Vic Gondotra",
                "Ryan Teixeira",
                "James Lawson",
                "Tyler Schena"*/
            ],
            autofocus: true,
            close: function() { console.pause; }
        });
    });
    
    $(document).ready(function() {
        //add checkbox functionality
    });
</script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
    //Initialize Google Map!
    function initialize() {
            var mapOptions = {
                    center: new google.maps.LatLng(<?= $hall["map_coords"] ?>),
                    zoom: 18,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("map"), mapOptions);

            var resMarker = new google.maps.Marker({
                    position: new google.maps.LatLng(<?= $hall["map_coords"] ?>),
                    map: map,
                    title: "<?= $hall["name"] ?>"
            });
            
            /*var centralCampus = new google.maps.Marker({
                    position: new google.maps.LatLng(44.47334717045448, -73.20396423339844 ),
                    map: map,
                    title: "Central Campus",
                    icon: "<?= $this->webroot ?>/img/maps-marker-blue-c.png"
            });*/

            google.maps.event.addListener(map, 'click', function(event) {
               console.log(event.latLng.lat() + ',' + event.latLng.lng());
            });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>

<h1><?php echo $hall["name"] . " - Room " . $room["room_num"]; ?></h1>
<?php
    echo $this->Form->create('User', array(
        "type" => "post",
        "controller" => "User",
        "action" => "registerRoom"
    ));
?>

<?php echo $this->Session->flash(); ?>

<div class="info-box">
    <img id="dorm-pic" src="<?php echo $this->webroot ?>img/resimages/<?= $hallImage ?>" />
    <div class="detail-content" id="hall-overview">
        <h2>Hall &amp; Room Overview:</h2>
        <p>Room Capacity: <?= $room["max_occupancy"] ?></p>
        <p>Room Availability: <?= $availability ?></p>
        <p>Room Size: <?= $room["sqft"] ?> sq. ft.</p>
        <p>Living Style: <?= $hall["living_type"] ?></p>
        <p>Gender: <?= $room["gender_restriction"] ?></p>
        <p>Distance from central campus: <?= $hall["campus_distance"] ?> miles</p>
    </div>
    <div style="clear: both;"></div>
</div>
<div class="info-box">
    <div id="map"></div>
    <!--<iframe id="map" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=<?= $hall["map_coords"] ?>&amp;ie=UTF8&amp;ll=<?= $hall["map_coords"] ?>&amp;spn=0.001682,0.004128&amp;t=m&amp;z=14&amp;iwloc=near&amp;output=embed"></iframe>-->
    <div class="detail-content">
        <h2>Roommates</h2>
        <p id="roommate-explanation">
            You can pull in roommates who may not yet have access to housing registration. Once you click "register," they will receive an email asking them to confirm your choice, and they will have 6 hours to accept your request before their spaces are given up.<p>
        <p id="allowed-roommates">You can invite <b><?= $availability - 1 ?></b> roommates for this room:</p>
        <p><input type="text" id="chosen-roommates" name="chosen-roommates" placeholder="Type a student name here"/>
    </div>
    <div style="clear: both;"></div>
</div>

<p id="agreement">
    <input type="checkbox" id="agreement-checkbox" name="agreement-checkbox" />
    <label for="agreement-checkbox">I agree to Champlain College's living agreement (available <a href="#">here</a>).</label>
</p>
<input type="hidden" name="room_id" value="<?= $room["id"] ?>" />


<?php
    echo $this->Form->end(array(
        "label" => "Register Room",
        "id" => "register-room"
    ));
?>
<!--<input type="submit" id="register-room" value="Register Room" disabled="disabled" />-->