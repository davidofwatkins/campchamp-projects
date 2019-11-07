$(document).ready(function() {
    
    //Load chosen image into page
    /*$(".imageupload").get(0).addEventListener("change", function() {
        handleFiles(this.files, $(".frame:first").get(0), function() {
            $('<div class="frame"></div>').insertAfter(".page#images p");
            $('<input type="file" class="imageupload" />').insertAfter(".page#images p");
        });
    });*/
    
    setListeners($(".imageupload").get(0));
    
    //onchange="handleFiles(this.files, document.getElementById('frame')
});

var pictureCounter = 2;

function setListeners(button) {
    button.onchange = function() {
        handleFiles(this.files, $(".frame:first").get(0), function() {
            
            //Get the images true size
            var trueWidth;
            var trueHeight;
            var img = new Image();
            img.src = $("img.obj:first").attr('src');
            img.onload = function() {
                //alert(this.width + 'x' + this.height);
                trueWidth = this.width;
                trueHeight = this.height;
              
                //alert(trueWidth);

                //Activate cropper
                var coordsInput = $(".cropcoords:first");
                var jcrop;
                $(".frame:first img").Jcrop({
                    aspectRatio: 544/435,
                    //minSize: [544, 435],
                    trueSize: [trueWidth, trueHeight],
                    onChange: updateCoordinates,
                    onSelect: updateCoordinates
                }, function() {
                    jcrop = this;
                    //jcrop.animateTo([100,100,400,300]);
                    jcrop.animateTo([224,92,373,211.1452205882353,149,119.1452205882353]);
                });

                function updateCoordinates(c) {
                    //console.log(c);
                    coordsInput.val(c.x + "," + c.y + "," + c.x2 + "," + c.y2 + "," + c.w + "," + c.h);
                }

                //Insert a new frame/button for the next upload
                $(".imageupload").hide();
                $('<div class="frame"></div>').insertAfter(".page#images p");
                $('<input type="file" class="imageupload" name="picture' + pictureCounter + '" />').insertAfter(".page#images p");
                $('<input type="hidden" class="cropcoords" name="cropcoords' + pictureCounter + '" />').insertAfter(".page#images p");
                setListeners($(".imageupload").get(0));

                pictureCounter++;
            }
        });
    };
}

/*function updateCoordinates(c) {
    console.log("updating");
    //coordsInput.val("hello!");
}*/

function handleFiles(files, frame, callback) {
            
    var file = files[0];
    var imageType = /image.*/;
    //var frame = document.getElementById("pictureframe");

    if (!file.type.match(imageType)) {
        alert("Not an image file! Please try again.")
    }

    else {

        var img = document.createElement("img");
        img.classList.add("obj");
        img.file = file;
        
        frame.innerHTML = ""; //clear frame before putting new image in
        frame.appendChild(img);

        var reader = new FileReader();  
        reader.onload = (function(aImg) {
            return function(e) { aImg.src = e.target.result; callback(); };
        })(img);
        reader.readAsDataURL(file);

    }

}
