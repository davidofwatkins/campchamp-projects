<?php
    
    echo $this->Html->css(array("jquery-basic-slider/bjqs", "browser-dorm-details", "foursquare"));
    echo $this->Html->script(array("foursquare-access", "jquery-maphiglight/jquery.maphilight.min", "jquery-basic-slider/js/bjqs-1.3.min", "floorplan-popup-builder"));
    
    $halldetails = $halldata[0]["Hall"];
    $floors = $halldata[0]["Floor"];
    $images = $halldata[0]["HallImage"];
                
?>

<script>
    $(document).ready(function() {

        //Dorm picture slideshow
        $("#pictures-module").bjqs({
            height: 435,
            width: 544,
            showcontrols: false,
            keyboardnav : false,
            usecaptions : false,
            randomstart : true,
            animtype: 'fade',
            automatic: true
        });

        //Room picker slider
        $("#floorplan-slider").bjqs({
            height: 409,
            width: 635,
            showcontrols: false,
            keyboardnav : false,
            usecaptions : false,
            randomstart : false,
            animtype: 'slide',
            automatic: false
        });

        //Remove numbers from sliders
        $("ol.bjqs-markers li a").html("");
        var i = 1;
        $("#floorplan-module ol.bjqs-markers li a").each(function() {
            if (i == 1) $(this).html("1st floor");
            else if (i == 2) $(this).html("2nd floor");
            else if (i == 3) $(this).html("3rd floor");
            else if (i == 4) $(this).html("4th floor");
            else if (i == 5) $(this).html("5th floor");
            else if (i == 6) $(this).html("6th floor");
            else if (i == 7) $(this).html("7th floor");
            else if (i == 8) $(this).html("8th floor");
            else if (i == 9) $(this).html("9th floor");
            else if (i == 10) $(this).html("10th floor");
            i++;
        });

    });
</script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
    //Initialize Google Map!
    function initialize() {
            var mapOptions = {
                    center: new google.maps.LatLng(<?= $halldetails["map_coords"] ?>),
                    zoom: 16,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("mapdetails"), mapOptions);

            var resMarker = new google.maps.Marker({
                    position: new google.maps.LatLng(<?= $halldetails["map_coords"] ?>),
                    map: map,
                    title: "<?= $halldetails["name"] ?>"
            });
            
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


<div id="dorm-details">
    <?php
        echo '<pre style="text-align: left;">';
        //print_r($halldata);
        echo "</pre>";
        /*foreach ($hallList as $hall) {
            echo "<p>" . $hall . "</p>";
        }*/
    ?>
    <form id="form" method="post" action="<?php echo $this->Html->url( '/', true ); ?>halls/details/<?= $halldetails["id_name"] ?>">
        <div class="info-module" id="pictures-module">
            <ul class="bjqs">
                <?php
                    foreach ($images as $resimg) {
                        echo '<li><img src="' . $this->webroot . 'img/resimages/' . $resimg["img_uri"] . '" /></li>';
                    }
                ?>
                <!--<li><img src="<?php echo $this->webroot; ?>img/resimages/cushing1.jpg" /></li>
                <li><img src="<?php echo $this->webroot; ?>img/resimages/mcdonald.jpg" /></li>-->
            </ul>
        </div>
        <div class="info-module" id="floorplan-module">
            <h2>Select a room from the floorplan below for more information:</h2>
            <div id="floorplan-slider">
                <ul class="bjqs">
                    <?php
                        $i = 1;
                        foreach($floors as $floor) {
                            echo '<li><img src="' . $this->webroot . 'img/resfloorplans/' . $floor["floorplan_img_uri"] . '" usemap="#imagemap-' . $halldetails["id_name"] . '-' . $i . '" class="floorplan" /></li>';
                            $i++;
                        }
                    ?>
                    <!--<li><img src="<?php echo $this->webroot; ?>img/resfloorplans/cushing1.png" usemap="#imagemap-cushing-1" class="floorplan" /></li>
                    <li><img src="<?php echo $this->webroot; ?>img/resfloorplans/cushing1.png" /></li>
                    <li><img src="<?php echo $this->webroot; ?>img/resfloorplans/cushing1.png" /></li>-->
                </ul>
            </div>
            <div class="popup">
                <h1>Room <span id="roomnum"></span></h1>
                <p><b>Room Gender</b>: <span id="gender"></span></p>
                <p><b>Availability</b>: <span id="availability"></span></p>
                <p><b>Room Size</b>: <span id="sqft"></span> sq. ft.</p>
                <div class="availability-bar">
                    <div class="availability-filler"></div>
                </div>
                <input type="submit" value="Reserve" />
            </div>
        </div>
        <?php
            $i = 1;
            foreach ($floors as $floor) {
                
                echo '<map name="imagemap-' . $halldetails["id_name"] . '-' . $i .'" class="rooms-map" id="imagemap-' . $halldetails["id_name"] . '-' . $i .'">';
                
                foreach ($floor["Room"] as $room) {
                    
                    $numResidents = sizeof($room["User"]);
                    $maxResidents = $room["max_occupancy"];
                    $spacesTaken = $maxResidents - $numResidents;
                    $spacesLeft = $maxResidents - $spacesTaken;
                    $availability = $spacesLeft . "/" . $maxResidents;
                    
                    echo '<area id="rm' . $room["id"] .  '" shape="rect" coords="' . $room["floorplan_coords"] . '" href="#" alt="Room ' . $room["room_num"] . '" data-roomnum="' . $room["room_num"] . '" data-gender="' . $room["gender_restriction"] . '" data-availability="' . $availability . '" data-sqft="' . $room["sqft"] . '" />';
                }
                
                echo '</map>';
                $i++;
            }
        ?>
        <!--<map name="imagemap-cushing-1" class="rooms-map" id="imagemap-cushing-1">
            <area id="room101" shape="rect" coords="27,135,144,327" href="#"  alt="Room 101" data-roomnum="101" data-gender="male" data-availability="1/3" data-sqft="23" />
            <area shape="rect" coords="472,85,621,175" href="#"  alt="Room 102" data-roomnum="102" data-gender="male" data-availability="2/3" data-sqft="25" />
            <area shape="rect" coords="257,86,395,188" href="#"  alt="Room 103" data-roomnum="103" data-gender="female" data-availability="3/3" data-sqft="20" />
            <area shape="rect" coords="150,200,202,258" href="#"  alt="Room 104" data-roomnum="104" data-gender="male" data-availability="3/4" data-sqft="21" />
            <area shape="rect" coords="470,179,620,325" href="#"  alt="Room 105" data-roomnum="105" data-gender="female" data-availability="1/5" data-sqft="25" />
            <area shape="rect" coords="257,192,395,325" href="#"  alt="Room 106" data-roomnum="106" data-gender="male" data-availability="2/4" data-sqft="25"/>
        </map>-->
        <div class="info-module" id="dorm-description">
            <h1>About <?= $halldetails["name"] ?></h1>
            <p><?= $halldetails["description"] ?></p>
        </div>
        <div class="info-module" id="dorm-map">
            <h1>Distance to Campus: <?= $halldetails["campus_distance"] ?> miles</h1>
            <div id="mapdetails"></div>
            <!--<iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=<?= $halldetails["map_coords"] ?>&amp;ie=UTF8&amp;ll=<?= $halldetails["map_coords"] ?>&amp;spn=0.001682,0.004128&amp;t=m&amp;z=14&amp;iwloc=near&amp;output=embed"></iframe>
            <iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=d&amp;source=s_d&amp;saddr=cushing+hall,+burlington,+vt&amp;daddr=champlain+college,+burlington,+vt&amp;hl=en&amp;geocode=FQGcpgId4Pui-ymx6frOUHrKTDFgCPe5yrf5Rw%3BFXGdpgIdRwOj-yHY3xqcigmfoCkNq8dJV3rKTDHY3xqcigmfoA&amp;aq=&amp;sll=43.343479,-71.974886&amp;sspn=3.339605,8.453979&amp;t=m&amp;mra=ls&amp;ie=UTF8&amp;ll=44.473707,-73.204941&amp;spn=0.00067,0.00114&amp;z=19&amp;output=embed"></iframe>-->
        </div>
        <script>
            $(document).ready(function() {
            getTips("<?= $halldetails["foursquare_id"] ?>", function(tips) {
                formatTipData(tips, $("#foursquare .inner-wrapper"));
            });
        });    
        </script>
        <div class="info-module" id="foursquare">
            <h1>Foursquare Tips</h1>
            
            <div class="inner-wrapper">
                <div class="no-foursquare">
                    <img src="<?= $this->webroot ?>img/foursquare-icon.png" />
                    <h2>No one's left a tip yet!</h2>
                    <p>Check in at <?= $halldetails["name"] ?> and be the first to leave a tip! Or if you've already been there, <a href="https://foursquare.com/v/cushing-hall/<?= $halldetails["foursquare_id"] ?>" target="_blank">leave a tip right now</a>!</p>
                </div>
            </div>
        </div>
    </form>
</div>