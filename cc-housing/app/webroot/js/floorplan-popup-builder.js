/* 
 * Responsible for implementing popup functionality on floorplan imagemaps
 */

$(document).ready(function() {
    
    var originalReserveButtonText = $(".popup input").attr("value");
    var originalAvailabilityColor = $(".popup .availability-filler").css("background");
    
    var originalFormAction = $("#form").attr("action");
    
    $(".floorplan").maphilight({
        alwaysOn: true
    });

    $(".rooms-map area").click(function(e) {
        $(".popup").hide();
        
        var topVal = getImagemapRectTop($(this).attr("coords"));
        var leftVal = getImagemapRectLeft($(this).attr("coords"));
        
        $(".popup").css({
            top: (topVal - 100) + "px",
            left: leftVal + "px"
        })
        
        //Fill the popup with the appropriate information
        var roomID = $(this).attr("id");
        var roomNum = $(this).attr("data-roomnum");
        var gender = $(this).attr("data-gender");
        var availability = $(this).attr("data-availability");
        var availPercent = eval(availability) * 100;
        var sqft = $(this).attr("data-sqft");
        
        $(".popup h1 span#roomnum").html(roomNum);
        $(".popup p span#gender").html(gender);
        $(".popup p span#availability").html(availability);
        $(".popup p span#sqft").html(sqft);
        $(".popup .availability-filler").width(availPercent + "%");
        
        if (availPercent == 100) {
            $(".popup input").attr("disabled", "disabled");
            $(".popup input").attr("value", "Unavailable");
            $(".popup .availability-filler").css("background", "#B40000");
        }
        else {
            $(".popup input").removeAttr("disabled");
            $(".popup input").attr("value", originalReserveButtonText);
            $(".popup .availability-filler").css("background", originalAvailabilityColor);
        }
        
        //Set the submit button to point to the right URL
        $("#form").attr("action", originalFormAction + "/" + roomID.replace("rm", ""));
        
        $(".popup").fadeIn("fast");
    });
    
    //Can't use document.ready because that runs before images are loaded
    window.addEventListener("load", function() {
        $(".bjqs-markers li a").click(function() {
            $(".popup").fadeOut("fast");
        });
    });
});

function getImagemapRectTop(coordsString) {
    var values = coordsString.split(",");
    return values[1];
}

function getImagemapRectLeft(coordsString) {
    var values = coordsString.split(",");
    return values[0];
}