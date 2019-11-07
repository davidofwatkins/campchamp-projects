<?php
    echo $this->Html->css(array("admin-add-hall", "jcrop/jquery.Jcrop.min"));
    echo $this->Html->script(array("jcrop/js/jquery.Jcrop.min", "add-res-imagehandler", "imagemap-builder", "jquery-maphiglight/jquery.maphilight.min", "floorplan-add-to-page"));
    
    $editing = false;
    if (isset($halldata)) {
        $editing = true;
        $halldata = $halldata[0];
        $hall = $halldata["Hall"];
        $floors = $halldata["Floor"];
        $images = $halldata["HallImage"];
    }
    
    //debug($halldata);
?>

<script>
    $(document).ready(function() {
        $("#tabnav .tab").click(function() {
            $(".page").hide();
            $("#" + $(this).attr("data-for")).show();
            return false;
        });
    });
</script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
    //Initialize Google Map!
    function initialize() {
            var mapOptions = {
                    center: new google.maps.LatLng(<?php if ($editing) echo $hall["map_coords"]; else echo "44.47334717045448, -73.20396423339844"; ?>),
                    zoom: 16,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("location-chooser"), mapOptions);
            
            var centralCampus = new google.maps.Marker({
                    position: new google.maps.LatLng(44.47334717045448, -73.20396423339844),
                    map: map,
                    title: "Central Campus",
                    icon: "<?= $this->webroot ?>/img/maps-marker-blue-c.png"
            });
            
            var newRes = new google.maps.Marker({
                <?php if ($editing) echo "position: new google.maps.LatLng(" . $hall["map_coords"] . "),"; ?>
                map: map,
                title: "New Residence"
            })

            google.maps.event.addListener(map, 'click', function(event) {
               console.log(event.latLng.lat() + ',' + event.latLng.lng());
               //Move the marker on the map to this location
               newRes.setPosition(new google.maps.LatLng(event.latLng.lat(), event.latLng.lng()));
               
               //Save the coordinates for upload to the server
               $("#mapcoords").val(event.latLng.lat() + ',' + event.latLng.lng());
            });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>

<h1>Add Residence Hall</h1>

<form id="editdorm" method="post" action="<?php echo $this->webroot; ?>admin/submitres" enctype="multipart/form-data">
<?php if ($editing) echo '<input type="hidden" name="editing" value="' . $hall["id"] . '" />'; ?>
<div id="tabnav">
    <a class="tab" href="#" data-for="general">General</a>
    <a class="tab" href="#" data-for="images">Images</a>
    <a class="tab" href="#" data-for="rooms">Rooms</a>
</div>
<div class="info-box">
    <div id="general" class="page">

        <h2 class="label">Location:</h2>
        <div id="location-chooser"></div>
        <!--<iframe id="location-chooser" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="//maps.google.com/maps?q=<?php if ($editing) echo $hall["map_coords"]; ?>&amp;ie=UTF8&amp;ll=<?php if ($editing) echo $hall["map_coords"]; ?>&amp;spn=0.001682,0.004128&amp;t=m&amp;z=14&amp;iwloc=near&amp;output=embed"></iframe>-->
        
        <input type="hidden" id="mapcoords" name="mapcoords" class="mapcoords" value="<?php if ($editing) echo $hall["map_coords"]; ?>" />
        
        <div class="leftright" id="leftsettings">
            <h2 class="label">Residence Name:</h2>
            <input id="dormname" name="dormname" type="text" value="<?php if ($editing) echo $hall["name"]; ?>" />
            <p><b>Residence ID:</b> <input id="id_name" name="id_name" type="text" value="<?php if ($editing) echo $hall["id_name"]; ?>" /></p>
            <p class="description">The residence ID will be used in URLs to specify this residence hall.</p>
            <p id="arrangement-wrapper">
                <b>Housing Arrangement:</b>
                <select id="arrangement" name="arrangement">
                    <option value="dormatory" <?php
                        if ($editing) {
                            if ($hall["living_type"] == "dormatory")
                                echo 'selected="selected"';
                        }
                    ?>>Dormitory</option>
                    <option value="apartment" <?php
                        if ($editing) {
                            if ($hall["living_type"] == "apartment")
                                echo 'selected="selected"';
                        }
                    ?>>Apartment</option>
                </select>
            </p>
            <h2 class="label">Foursquare ID:</h2>
            <p class="description">The foursquare ID can be found at the end of the URL for the appropriate venue page on Foursquare.com</p>
            <p><span style="color: gray;">foursquare.com/v/venue-name/</span><input type="text" name="foursquareid" id="foursquareid" value="<?php if ($editing) echo $hall["foursquare_id"]; ?>" /></p>
        </div>
        <div class="leftright" id="rightsettings">
            <h2 class="label">Description:</h2>
        <textarea id="description" name="description" placeholder="Compose a description for this residence hall, here."><?php if ($editing) echo $hall["description"]; ?></textarea>
        </div>
    </div>

    <div id="images" class="page">
        <p class="description">Each residence hall listing will display a slideshow of images uploaded here.</p>
        <input type="file" class="imageupload" name="picture1" />
        <input type="hidden" class="cropcoords" name="cropcoords1" />
        <div class="frame"></div>
        <div id="gallery">
            <?php
                if ($editing) {
                    foreach ($images as $image) {
                        echo '<img src="' . $this->webroot . "img/resimages/" . $image["img_uri"] . '" />';
                    }
                }
            ?>
        </div>
    </div>

    <div id="rooms" class="page">
        <p>To add a floor to this residence hall, click the button below. Once the image appears, click the edit button to draw a room location on the image and fill out the appropriate details.</p>

        <input type="file" class="floorplan-upload" name="floorplan1" />

        <!--<div class="floorplan-container">
            <img class="floorplan" usemap="#map2" src="images/resfloorplans/cushing1.png" />
            <map name="map2" id="map2"></map>
            <a href="#" class="button switchmodes">Click here to add a room</a>
        </div>-->
        <!--<div class="floorplan-container">
            <img class="floorplan" usemap="#map1" src="images/resfloorplans/cushing1.png" />
            <map name="map1" id="map1"></map>
            <a href="#" class="button switchmodes">Click here to add a room</a>
        </div>-->
        
        <script>
            window.addEventListener("load", function() {
                
                var numFloors = <?= sizeof($floors) ?>;
                for (var i = 1; i <= numFloors; i++) {
                    initializeRoomEditor(".floorplan-container:eq(" + (i - 1) + ")", "#map" + i);
                }                
            });
        </script>
        
        
        <?php
            if ($editing) {
                
                $roomDataCounter = 1;
                
                $i = 1;
                foreach ($floors as $floor) {
                    echo '<div class="floorplan-container">';
                    echo '<p>Floor Number: <input type="number" id="floor' . $i . 'num" class="floornumber" value="' . $floor["floor_num"] .'" required /></p>';
                    echo '<input type="hidden" id="floor_id" value="' . $floor["id"] . '" />';
                    echo '<img class="floorplan" usemap="#map' . $i . '" src="' . $this->webroot . "img/resfloorplans/" . $floor["floorplan_img_uri"] . '" />';
                    echo '<map name="map' . $i . '" id="map' . $i . '">';
                    
                    $roomDataCounterLoopStartValue = $roomDataCounter;
                    $j = 1;
                    foreach ($floor["Room"] as $room) {
                        echo '<area shape="rect" coords="' . $room["floorplan_coords"] . '" href="#" data-roomdetailsform="roomdata' . $roomDataCounter .'">';
                        $roomDataCounter++;
                        $j++;
                    }
                    
                    echo '</map>';
                    echo '<a href="#" class="button switchmodes">Click here to add a room</a>';
                    
                    $j = 1;
                    foreach ($floor["Room"] as $room) {
                        echo '<input type="hidden" id="roomdata' . $roomDataCounterLoopStartValue . '" value="rmid=' . $room["id"] . ';rmnum=' . $room["room_num"] . ';rmcapacity=' . $room["max_occupancy"] . ';rmsize=' . $room["sqft"] . ';rmgender=' . $room["gender_restriction"] . ';rmyear=any;rmcoords=' . $room["floorplan_coords"] . '">';
                        $roomDataCounterLoopStartValue++;
                        $j++;
                    }
                    
                    echo '</div>';
                    
                    $i++;
                }
            }
        ?>

        <!-- Popup will be copied into the appropriate floorplan-container when used -->
        <div class="popup">
            <h1>Enter Details:</h1>
            <input type="hidden" id="roomid" />
            <table>
                <tr><td>Room Number:</td><td><input type="number" id="roomnum" /></td></tr>
                <tr><td>Room Capacity:</td><td><input type="number" id="roomcapacity" /></td></tr>
                <tr><td>Room Size:</td><td><input type="number" id="roomsize" /> sq. ft.</td></tr>
                <tr>
                    <td>Room Gender:</td>
                    <td>
                        <select id="roomgender">
                            <option value="mixed">Mixed</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Year restrictions:</td>
                    <td>
                        <select id="roomyear">
                            <option value="any">Any class</option>
                            <option value="2013">Class of 2013</option>
                            <option value="2014">Class of 2014</option>
                            <option value="2015">Class of 2015</option>
                            <option value="2016">Class of 2016</option>
                            <option value="2017">Class of 2017</option>
                        </select>
                    </td>
                </tr>
            </table>
            <input type="hidden" class="tmpcoords" />
            <input type="hidden" class="savedDataId" />
            <a class="button" href="#">Done</a>
        </div>
    </div>
</div>
<input type="submit" id="submit" value="<?php if ($editing) echo "Edit Hall"; else echo "Add Hall"; ?>" />
</form>