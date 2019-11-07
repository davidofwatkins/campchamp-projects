$(document).ready(function() {
	resizeHeights();
	$(window).resize(function() { resizeHeights(); });
	
	$(".sbjlisting").click(function() {
		
		//$(".sbjlisting").css({ "font-weight" : "normal", "background-color" : "white" });
		$(".sbjlisting").attr("state", "notactive");
		
		//$(this).css({ "background-color" : "#C9DCFC", "font-weight" : "bold" });
		$(this).attr("state", "active");
		
		$("#classlist h1#sbjname").html($(this).html());
		
		//collapse all class listings
		$(".classlisting").css("background", "#FFF");
		$(".classdescription").hide();
		$(".expandcollapse").attr("src", "plus.png");
		
		$("#classlist").fadeIn("fast");
		$("#chooseclassdialog").fadeIn("fast");
	});
	
	$(".classlistingtitle").click(function() { toggleClassListing(this); });
	
	$("#showoptions").click(function() { toggleOptions(); });
	$("#closeoptions").click(function() { toggleOptions(); });
	
	//demo popups
	$(".descriptionlinks a").click(function() { alert('Because this is a non-functional demo, these links do not work. Please visit classlist.champlain.edu for the live version.'); });
	
	var searchMsgEscape = 0;
	$("#search").focus(function() {
		if (searchMsgEscape == 0) { alert("Search is not functional in the demo. Otherwise, results would begin to appear in the right-hand column as the visitor types in real-time."); }
		searchMsgEscape = 1;
	});
	
	$("#viewquicklist").click(function() { alert("This button will display a list of classes that the user has compiled for consideration. Because this is a demo, this feature has not been implemented."); });
	
});
function resizeHeights() {
	var heightOfContent = $(window).height() - $("#header").outerHeight();
	var heightOfSubContent = heightOfContent * 0.84;
	$("#rightback").css("height", heightOfSubContent + "px");
	if ($("#options").css("display") != "none") {
		$("#subjectlist").css("height", heightOfSubContent - $("#options").outerHeight() + "px");
	}
	else { $("#subjectlist").css("height", heightOfSubContent + "px"); }
	
	//Center the text within the div#subrightback
	$("h1#selectsbjdialog").css("margin-top", $("#rightback").height() * 0.40 + "px");
	$("h1#selectsbjdialog").css("margin-bottom", 0);
	
	var classWindow = $("#classlist");
	
	classWindow.css("top", $("#rightback").offset().top);
	classWindow.css("left", $("#rightback").offset().left);
	classWindow.css("width", $("#rightback").outerWidth());
	classWindow.css("height", $("#rightback").outerHeight());
}

function toggleOptions() {
	
	var sbjListHeight = $("#subjectlist").outerHeight();
	//var optionsHeight = $("#options").outerHeight();
	optionsHeight = 164; //manually coded for now...
	var newSbjListHeight = sbjListHeight - optionsHeight;
	var originalListHeight = sbjListHeight + optionsHeight;
	
	if ($("#options").css("display") == "none") {
		$("#options").slideDown("fast");
		$("#subjectlist").animate({ "height" : newSbjListHeight}, "fast");
	}
	else {
		$("#options").slideUp("fast");
		$("#subjectlist").animate({ "height" : originalListHeight }, "fast");
	}
}

function toggleClassListing(classClicked) {
	var classListing = $(classClicked).parent();
	var classDescription = $(classClicked).parent().children(".classdescription");
	var plusMinus = $(classClicked).children(".expandcollapse");
	
	if (classDescription.css("display") != "block") {
		classListing.css("background", "#EAEAF7");
		classDescription.slideDown("fast");
		plusMinus.attr("src", "minus.png");
	}
	else {
		classListing.css("background", "#FFF");
		classDescription.slideUp("fast");
		plusMinus.attr("src", "plus.png");
	}
}