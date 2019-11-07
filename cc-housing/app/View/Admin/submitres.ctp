<?php

    /*debug($_POST);
    
    debug($_FILES);
    
    $floorsData = stripslashes($_POST["floorsdata"]);
    
    $floorsData = json_decode($floorsData, true);
    
    echo "<p>Data sent from server:</p>";
    debug($floorsData);
    
    echo "<pre>";
    foreach ($floorsData as $floor) {
        
        if ($floor["isNew"] == "true") {
            echo "Create new floor\n";
        }
        else {
            echo "Modify floor (ID = " . $floor["id"] . ")\n";
        }
        
        echo "Set this floor's floor_num to " . $floor["floornum"] . "\n";
        
        foreach ($floor["rooms"] as $room) {
            echo "If there is a room on this floor with coords " . $room["rmcoords"] . ", set the appropriate data\n";
        }
        
        
        echo "\n";
    }
    echo "</pre>";
    
    echo "<p>---------Existing Database Data------------</p>";
    
    debug($halldata);*/
    
?>