<?php
    echo $this->Html->css(array("admin-manage-halls"));  
    
    //echo "<pre>" . print_r($halls, true) . "</pre>";
?>

<h1>Manage Residence Halls</h1>
        
<?php

    foreach ($halls as $hall) {
        $hallImages = $hall["HallImage"];
        $hallFloors = $hall["Floor"];
        $hall = $hall["Hall"];
        
        $totalAvailability = 0;
        $totalResidents = 0;
        foreach ($hallFloors as $floors) {
            foreach ($floors["Room"] as $room) {
                //foreach($rooms as $room) {
                    $totalAvailability += $room["max_occupancy"];
                    $totalResidents += sizeOf($room["User"]);
                //}
            }
        }
        
        $emptySpots = $totalAvailability - $totalResidents;
        
        //echo "<h1>" . $totalResidents . " of " . $totalAvailability . "</h1>";
        
        echo '<div class="info-box">';
        echo '<img class="dorm-pic" src="' . $this->webroot . 'img/resimages/' . $hallImages[0]["img_uri"] . '" />';
        echo '<div class="dorm-desc">';
        echo '<h1 class="dorm-name">' . $hall["name"] . '</h1>' . $hall["description"];
        echo '<p><b>Availability:</b> ' . $emptySpots . " of " . $totalAvailability . '</p>';
        echo '<div style="clear: both;"></div>';
        echo '</div>';
        echo '<a href="' . $this->webroot . "halls/view/" . $hall["id_name"] . '" class="view-dorm button" target="_blank">View Dorm</a> ';
        echo '<a href="' . $this->webroot . "admin/edit/" . $hall["id_name"] . '" class="edit-dorm button">Edit</a>';
        echo '</div>';
    }

?>
<!--<div class="info-box">
    <img class="dorm-pic" src="<?php echo $this->webroot; ?>img/resimages/cushing1.jpg" />
    <div class="dorm-desc">
        <h1 class="dorm-name">Cushing Hall</h1>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        <p><b>Availability:</b> 10 of 44 (3 rooms of 15)</p>
    </div>
    <div style="clear: both"></div>
    <a href="#" class="view-dorm button">View Dorm</a>
    <a href="#" class="edit-dorm button">Edit</a>
</div>
<div class="info-box">
                <img class="dorm-pic" src="<?php echo $this->webroot; ?>img/resimages/cushing1.jpg" />
    <div class="dorm-desc">
        <h1 class="dorm-name">Cushing Hall</h1>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        <p><b>Availability:</b> 10 of 44 (3 rooms of 15)</p>
    </div>
    <div style="clear: both"></div>
    <a href="#" class="view-dorm button">View Dorm</a>
    <a href="#" class="edit-dorm button">Edit</a>
</div>
<div class="info-box">
                <img class="dorm-pic" src="<?php echo $this->webroot; ?>img/resimages/cushing1.jpg" />
    <div class="dorm-desc">
        <h1 class="dorm-name">Cushing Hall</h1>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        <p><b>Availability:</b> 10 of 44 (3 rooms of 15)</p>
    </div>
    <div style="clear: both"></div>
    <a href="#" class="view-dorm button">View Dorm</a>
    <a href="#" class="edit-dorm button">Edit</a>
</div>
<div class="info-box">
                <img class="dorm-pic" src="<?php echo $this->webroot; ?>img/resimages/cushing1.jpg" />
    <div class="dorm-desc">
        <h1 class="dorm-name">Cushing Hall</h1>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        <p><b>Availability:</b> 10 of 44 (3 rooms of 15)</p>
    </div>
    <div style="clear: both"></div>
    <a href="#" class="view-dorm button">View Dorm</a>
    <a href="#" class="edit-dorm button">Edit</a>
</div>
<div class="info-box">
                <img class="dorm-pic" src="<?php echo $this->webroot; ?>img/resimages/cushing1.jpg" />
    <div class="dorm-desc">
        <h1 class="dorm-name">Cushing Hall</h1>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        <p><b>Availability:</b> 10 of 44 (3 rooms of 15)</p>
    </div>
    <div style="clear: both"></div>
    <a href="#" class="view-dorm button">View Dorm</a>
    <a href="#" class="edit-dorm button">Edit</a>
</div>-->