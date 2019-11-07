/* 
 * This script is responsible for modifying the layout of the residence browser
 * for smaller screen sizes.
 */

//Global variables:
//var origDormlistDisplay;
var origDormlistExpandDisplay;
var origDormlistZIndex;
var origDormlistPosition;
var origDormlistWidth;
var origDetailsPosition;
var origDetailsPosLeft;

var sidebarOpen = false;

$(document).ready(function() {
    
    //origDormlistDisplay = $("#dormlist-container").css("display");
    origDormlistZIndex = $("#dormlist-container").css("z-index");
    origDormlistPosition = $("#dormlist-container").css("position");
    origDormlistExpandDisplay = $("#expand-dormlist-button").css("display");
    origDormlistWidth = "15%"; //$("#dormlist-container").css("width"); //returns px's :(
    origDetailsPosition = $("#details").css("position");
    origDetailsPosLeft = $("#details").css("left");
    
    resizeWindow();
    
    $(window).resize(function() {
       resizeWindow();
    });
    
    $("#expand-dormlist-button").click(function() {
        if (!sidebarOpen) openSidebar();
        else closeSidebar();
    });
    
    
});

function resizeWindow() {
    
    var width = $(window).outerWidth(true);
    var height = $(window).outerHeight(true);

    //console.log("Resized to: " + width + "x" + height);

    if (width < 944) {
        resizeToMobile();
    }
    else {
        resizeToDefault();
    }
       
}

function openSidebar() {
    $("#details").animate({
        left: "300px",
    }, "fast", function() {
        $("#dormlist-container").css("z-index", origDormlistZIndex);
    });
    sidebarOpen = true;
}

function closeSidebar() {
    $("#dormlist-container").css("z-index", -5);
    $("#details").animate({
        left: origDetailsPosLeft
    }, "fast");
    sidebarOpen = false;
}


function resizeToMobile() {
    console.log("Mobile!");
    
    //Hide sidebar
    $("#dormlist-container").css({
        position: "absolute",
        "z-index": "-5",
        width: "300px"
        /* Left positioning should be set to 0 in CSS */
    });
    
    //Set details side positioning to absoulute
    $("#details").css("position", "absolute");
    
    //Show sidebar button
    $("#expand-dormlist-button").css("display", "block");
}

function resizeToDefault() {
    console.log("Normal!");
    
    //Restore sidebar
    $("#dormlist-container").css({
        position: origDormlistPosition,
        "z-index": origDormlistZIndex,
        width: origDormlistWidth
    });
    
    //Restore details side positioning
    $("#details").css({
        position: origDetailsPosition,
        left: origDetailsPosLeft
    });
    
    //Remove sidebar show button
    $("#expand-dormlist-button").css("display", origDormlistExpandDisplay);
}