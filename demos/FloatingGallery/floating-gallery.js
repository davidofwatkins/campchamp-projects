//Define defaults - user settings will override these:
var repeatFrequency = 5000;
var defaultAnimationLength = 10000;
var container;
var pictures;
var pictures_runnerUp = 0;
var captionWidth = 700;

//Constructor for the FloatingGallery object
function FloatingGallery(containerID, picturesJSON, options) {
	
	//Save options passed in by user
	repeatFrequency = options["repeatFrequency"];
	defaultAnimationLength = options["defaultAnimationLength"];
	container = $("#" + containerID);
	pictures = picturesJSON;
	
	//Set up the "environment" (#floating-gallery-container)
	resizeContainer();
	$(window).resize(function() {
		resizeContainer();
	});
	
	function resizeContainer() {
		container.height($(window).height());
		container.width($(window).width());
	}
	
	startSlideshow();
}

function startSlideshow() {
		
	var image = getNextImage();
	animateNextGalleryItem(image.src, image.caption, defaultAnimationLength);
	setInterval(function() {
		image = getNextImage();
		animateNextGalleryItem(image.src, image.caption, defaultAnimationLength);
	}, repeatFrequency);
}

function animateNextGalleryItem(picsrc, caption, length) {
	
	//Create gallery item within container
	var location = getRandomStartingPos();
	var galleryItem = $('<div class="fg-galleryitem"></div>');
	
	galleryItem.css({
		top: location["top"],
		left: location["left"],
		display: "none",
		//background: get_random_color()
	});
	galleryItem.appendTo(container);
	
	//If there is a picture, fill it with that
	if (picsrc != "") {
		galleryItem.append('<div class="fg-picture-container"><img src="' + picsrc + '" /></div>');
		
		//Set picture sizes
		var image = $(".fg-picture-container img").last();
		var imageWidth;
		var imageHeight;
		image.load(function() { //need to "load" the image before finding its width/height
			
			imageWidth = image.width();
			imageHeight = image.height();
			
			if (imageWidth <= imageHeight) { //If image is tall
				image.css("height", "100%"); //Set image height to height of galleryItem;
				
				//Need to define both width and height for FF :(
				galleryItem.children(".fg-picture-container").css("height", "100%");
				galleryItem.width(image.width() + captionWidth); //Extend the galleryItem for room for caption
				var imgWidthPercent = 100 * image.width() / galleryItem.width();
				galleryItem.children(".fg-picture-container").css("width", imgWidthPercent + "%"); //set the parent's width
				image.css("width", "100%"); //set image width to 100% of parent (.fg-picture-container)
				
				if (caption) {
					galleryItem.append('<div class="fg-caption">' + caption + '</div>');
					var captionWidthAsPercent = 100 * captionWidth / galleryItem.width();
					galleryItem.children(".fg-caption").width((captionWidthAsPercent - 2) + "%");
					galleryItem.children(".fg-caption").css("padding-top", "15%");
				}
			}
			else { //If image is wide
				image.css("width", "100%");
				//var imgHeightPercent = 100 * image.height() / galleryItem.height();
				galleryItem.height(image.height() + 200);
				
				if (caption) {
					galleryItem.append('<div class="fg-caption">' + caption + '</div>');
					//var captionWidthAsPercent = 100 * captionWidth / galleryItem.width();
					//galleryItem.children(".fg-caption").width((captionWidthAsPercent - 2) + "%");
					galleryItem.children(".fg-caption").width("98%");
					//alert(galleryItem.children(".fg-caption").height());
				}
			}
			
			var endLocation = getCenterPos();
			galleryItem.transition({
				top: endLocation["top"],
				left: endLocation["left"],
				width: "24px",
				height: "20px"
			}, length, function() {
				$(this).fadeOut("slow", function() {
					galleryItem.remove();
				});
			});
			
			//Animate text size
			galleryItem.children(".fg-caption").transition({
				"font-size": "2px"
			}, length);			
		});
	}
	
	//Voila! Show the image
	galleryItem.fadeIn("slow");
}

//Returns array of (top, left) coordinates
function getRandomStartingPos() {
	var totalWidth = $(window).width();
	var totalHeight = $(window).height();
	
	var left = Math.floor((Math.random() * totalWidth) - 600) + 1;
	var top = Math.floor((Math.random() * totalHeight) - 500) + 1;
	left = Math.abs(left);
	top = Math.abs(top);
	
	var answer = new Array();
	answer["top"] = top;
	answer["left"] = left;
	
	return answer;
}

function getCenterPos() {
	var totalWidth = $(window).width();
	var totalHeight = $(window).height();
	
	var answer = new Array();
	answer["top"] = totalHeight * 0.5;
	answer["left"] = totalWidth * 0.5;
	
	return answer;
}

function getNextImage() {
	var nextPic = pictures[pictures_runnerUp];
	pictures_runnerUp++;
	return nextPic;
}

//Temporary, just using as demo
function get_random_color() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.round(Math.random() * 15)];
    }
    return color;
}

function elementInDocument(element) {
	while (element = element.parentNode) {
		if (element == document) {
			return true;
		}
	}
	return false;
}