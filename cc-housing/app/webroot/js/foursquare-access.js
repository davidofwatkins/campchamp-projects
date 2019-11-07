/* 
 * Retrieves foursquare tip data for a specified venue id
 */

//Tips API URL: https://api.foursquare.com/v2/venues/4b1a9bc9f964a52053ed23e3/tips?client_id=3FI1KEKQHVOWQHSTOIH4MQPTKUPN5XO433RH5UYNHPIVBTL3&client_secret=VPSEQRPQGTMN54YDIVNRP2RLO2RKTTA4TYIGK0E5JTMJJ5XP&v=20130311

var fqClientID = "3FI1KEKQHVOWQHSTOIH4MQPTKUPN5XO433RH5UYNHPIVBTL3";
var fqClientSecret = "VPSEQRPQGTMN54YDIVNRP2RLO2RKTTA4TYIGK0E5JTMJJ5XP";

function getTips(venueID, callback) {
    
    $.ajax({
        type: "GET",
        url: "https://api.foursquare.com/v2/venues/" + venueID + "/tips",
        data: "client_id=" + fqClientID + "&client_secret=" + fqClientSecret + "&v=20130311",
        success: function(data) {
            
            if (data.response.tips.count == 0) {
                //throw new Exception("No Tips
                showNoTips();
                return;
            }

            //throw exception for bad api
            //throw exception for 0 tips

            callback(data.response.tips.items);
        },
        error: function() {
            alert("Error authenticating with Foursquare.");
        }
    });
}

function formatTipData(tips, container) {
    
    var tipOutput = '<ul id="fq-tips">';
    for (var i = 0; i < tips.length; i++) { //foreach tip...
        
        var tip = tips[i];
        tipOutput += '<li>';
        tipOutput += '<div class="fq-user-pic-wrapper">'
        tipOutput += '<img class="fq-profilepic" clas="fq-profilepic" src="' + tip.user.photo.prefix + "40x40" + tip.user.photo.suffix + '" />';
        tipOutput += '</div>';
        tipOutput += '<div class="fq-data">';
        tipOutput += '<p class="tip-author"><a target="_blank" href="https://foursquare.com/user/' + tip.user.id + '">' + tip.user.firstName + " " + tip.user.lastName + '</a></p><p><a target="_blank" href="' + tip.canonicalUrl + '">' + tip.text + '</a></p>';
        tipOutput += '</div>';
        tipOutput += '<div style="clear: both;"></div>'
        tipOutput += '</li>';
    }
    tipOutput += '</ul>';
    container.append(tipOutput);
    
    
}

function showNoTips() {
    $("#foursquare .inner-wrapper").css({
        "border": "none",
        "overflow": "hidden"
    });
    $("#foursquare .inner-wrapper .no-foursquare").show();
    //$("#foursquare .inner-wrapper").html("<h2>No Tips found!</h2>");
}