
var roomcounter;

$(document).ready(function() {
    //initializeRoomEditor(".floorplan-container:first", "#map1");
    //initializeRoomEditor(".floorplan-container:last", "#map2");
    roomcounter = $("area").length + 1;
    
    $("#editdorm").submit(function() {
        serializeRoomData();
        return true;
    });
    
});

function initializeRoomEditor(parentExpr, mapExpr) {
    var jcrop;
    //startJcrop();
    
    //Make all existing imagemaps clickable
    $("area").unbind("click");
    $("area").click(function() {
        showPopup($(this), $(this).parents(".floorplan-container"));
        return false;
    });
    
    //Show all existing roommaphilights (turn on imagemap highlighting)
    //alert("activating maphighlight");
    $(".floorplan").maphilight({
        alwaysOn: true
    });
    
    var container = $(parentExpr);
    
    //Activate button for turning on cropping
    container.find(".button.switchmodes").click(function() {
        //console.log(container.html());
        disableMapHighlight();
        startJcrop();
        return false;
    });
    
    //Handle the data once the user has filled out the popup
    $(".popup .button").unbind("click");
    $(".popup .button").click(function() {
        saveRoomDataFromBubble();
        //disableMapHighlight();
        $(".popup").fadeOut("fast");
        //startJcrop();
        return false;
    });
    
    function startJcrop() {
        container.find(".floorplan").Jcrop({
            onSelect: setImagemapCoords
        }, function() {
            jcrop = this;
            //jcrop.animateTo([100,100,400,300]);
        });
    }
    
    function setImagemapCoords(c) {
        
        container.find(mapExpr).append('<area shape="rect" coords="' + c.x + "," + c.y + "," + c.x2 + "," + c.y2 + '" href="#" data-roomdetailsform="roomdata' + roomcounter + '" />');
        jcrop.release();
        jcrop.destroy();
        
        container.find(".jcrop-holder").remove();
        
        container.find(".floorplan").maphilight({
            alwaysOn: true
        });
        
        //Make imagemap clickable
        container.find(mapExpr + " area:last").click(function() { 
            showPopup($(this));
            return false;
        });
        
        showPopup();
    }
    
    function getImagemapRectTop(coordsString) {
        try { var values = coordsString.split(","); }
        catch(e) { alert("Error splitting string in getImagemapRectTop(). <area> hasn't been created?"); console.error("Cannot split string. <area> not created?")}
        return values[1];
    }

    function getImagemapRectLeft(coordsString) {
        try { var values = coordsString.split(","); }
        catch(e) { alert("Error splitting string in getImagemapRectTop(). <area> hasn't been created?"); }
        return values[0];
    }

    function showPopup(areaElement, parentElem) {
        
        //Move to the appropriate floorplan-container
        if (!parentElem) parentElem = container;
        parentElem.append($(".popup"));
        
        clearPopup();

        //Position and show popup
        if (!areaElement) {
            var topVal = getImagemapRectTop(container.find(mapExpr + " area:last").attr("coords"));
            var leftVal = getImagemapRectLeft(container.find(mapExpr + " area:last").attr("coords"));
        }
        else {
            var inputFieldId = areaElement.attr("data-roomdetailsform");
            var topVal = getImagemapRectTop(areaElement.attr("coords"));
            var leftVal = getImagemapRectLeft(areaElement.attr("coords"));
        }

        //Fill the popup with the appropriate data (if set)
        //and save the inputFieldId to a hidden value for use when saving
        if (inputFieldId) {
            var dataString = $("#" + inputFieldId).val();
            loadDataToBubbleFromString(dataString);
            $(".popup input.savedDataId").val(inputFieldId);
        }

        $(".popup").css({
            top: (topVal - 225) + "px",
            left: (leftVal - 20) + "px"
        });

        $(".popup .tmpcoords").val(container.find(mapExpr + " area:last").attr("coords"));

        $(".popup").fadeIn("fast");
    }

    /*
     * Saves room data from a popup bubble to a hidden input
     */
    function saveRoomDataFromBubble() {

        var inputField;

        //If this is a newly created room, save the data to a new input
        if ($(".popup .savedDataId").val() == "") {
            inputField = $('<input type="hidden" id="roomdata' + roomcounter + '" />');
            $(".page#rooms").append(inputField);
            roomcounter++;
        }

        //If this is an old room, save the data to the designated input
        else {
            inputField = $("#" + $(".popup .savedDataId").val());
        }

        var valueString = "rmnum=" + $(".popup #roomnum").val() + ";";
        valueString += "rmcapacity=" + $(".popup #roomcapacity").val() + ";";
        valueString += "rmsize=" + $(".popup #roomsize").val() + ";";
        valueString += "rmgender=" + $(".popup #roomgender").val() + ";";
        valueString += "rmyear=" + $(".popup #roomyear").val() + ";";
        valueString += "rmcoords=" + $(".popup .tmpcoords").val() + ";";
        valueString += "rmid=" + $(".popup #roomid").val();

        inputField.val(valueString);
    }

    //Set everything back to how it started in the HTML
    function disableMapHighlight() {
        var floorplan = container.find("div.floorplan img.floorplan");
        var parent = floorplan.parent();
        floorplan.insertBefore(parent);
        floorplan.removeClass("maphilighted");
        parent.remove();
        floorplan.attr("style", "");
    }

    function clearPopup() {
        $(".popup input").each(function() {
            $(this).val("");
        });

        $(".popup select").each(function() {
            //$(this).prop('selectedIndex', 0);
            $(this).children("option").each(function() {
                $(this).removeAttr("selected");
            });
        });
    }

    function loadDataToBubbleFromString(dataString) {
        
        var sets = dataString.split(";");

        for (var i = 0; i < sets.length; i++) {
            var keyval = sets[i].split("=");
            var key = keyval[0];
            var val = keyval[1];

            if (key == "rmnum") {
                $(".popup input#roomnum").val(val);
            }
            else if (key == "rmcapacity") {
                $(".popup input#roomcapacity").val(val);
            }
            else if (key == "rmsize") {
                $(".popup input#roomsize").val(val);
            }
            else if (key == "rmgender") {
                $(".popup select#roomgender option[value=" + val + "]").get(0).selected = true; //.attr("selected", "selected");
            }
            else if (key == "rmyear") {
                $(".popup select#roomyear option[value=" + val + "]").get(0).selected = true; //.attr("selected", "selected");
            }
            else if (key == "rmid") {
                $(".popup input#roomid").val(val);
            }
        }
    }
}

function serializeRoomData() {
    var floors = new Array();
    
    try {

        var i = 0;
        //for (var i = 0; i < $(".floorplan-container").length; i++) {
        $(".floorplan-container").each(function() {

            floors[i] = new Object();

            //Is it a new floor or a previously saved floor?
            if ($(this).find("input#floor_id").length > 0) {
                floors[i].isNew = "false";
                floors[i].id = $(this).find("input#floor_id").val();
            }
            else {
                floors[i].isNew = "true";
                floors[i].name = $(this).prev("input[type=file]").attr("name");
            }

            //What is this floors floor number?
            floors[i].floornum = $(this).find("input.floornumber").val();

            //Load each room into the floor
            floors[i].rooms = new Array();
            var j = 0;
            $($(this).find("map area")).each(function() {
                var inputDataField = $(this).attr("data-roomdetailsform");
                var dataString = $("#" + inputDataField).val();
                
                //alert("Found map in " + i + "th/st/nd/rd floorplan with data " + dataString);
                
                floors[i].rooms[j] = new Object();
                
                var sets = dataString.split(";");
                
                //console.log(sets);
                
                for (var k = 0; k < sets.length; k++) {
                    var keyval = sets[k].split("=");
                    var key = keyval[0];
                    var val = keyval[1];
                    
                    if (!(key == "rmid" && !val))
                        floors[i].rooms[j][key] = val;
                }
                
                j++;
            });

            i++;
        });

        console.log(floors);
        //console.log(JSON.stringify(floors));

        //save the data to an input for upload
        if ($("input#floorsdata").length > 0) $("input#floorsdata").remove();
        $("#rooms").append('<input type="hidden" id="floorsdata" name="floorsdata" value=\'' + JSON.stringify(floors) + '\' />');
        
    }
    catch(e)  { alert("Error saving data."); }
}