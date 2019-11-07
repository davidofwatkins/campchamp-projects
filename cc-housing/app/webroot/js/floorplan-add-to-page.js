/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var mapCounter;// = $(".map").length + 1;
var floorplanCounter;// = $(".floorplan-upload").length + 1;

//var mapCounter = 2;
//var floorplanCounter = 2;


$(document).ready(function() {
    
    mapCounter = $("map").length + 1;
    floorplanCounter = $(".floorplan-upload").length + 1;
    
    enableFloorplanUpload($(".floorplan-upload").get(0))
    
});

function enableFloorplanUpload(button) {
    button.onchange = function() {
        //alert("changed");
        
        $('<div class="floorplan-container"></div>').insertAfter("input.floorplan-upload:first");
        
        handleFiles(this.files, $(".floorplan-container:first").get(0), function() {
            $(".floorplan-container:first").prepend('<p>Floor Number: <input type="number" class="floornumber" required /></p>');
            $(".floorplan-container:first").append('<map name="map' + mapCounter + '" id="map' + mapCounter + '"></map>');
            $(".floorplan-container:first").append('<a href="#" class="button switchmodes">Click here to add a room</a>');
            $(".floorplan-container:first img").addClass("floorplan");
            $(".floorplan-container:first img").attr("usemap", "#map" + mapCounter);
            
            initializeRoomEditor(".floorplan-container:first", "#map" + mapCounter);
            
            mapCounter++;
            
            $(".floorplan-upload").css("display", "none");
            $('<input type="file" class="floorplan-upload" name="floorplan' + floorplanCounter + '" />').insertBefore("input.floorplan-upload:first");
            
            floorplanCounter++;
            
            enableFloorplanUpload($(".floorplan-upload").get(0))
            
        });
    }
}