/* 
 * Searches the sidebar list of dorms and displays them in realtime
 */

$(document).ready(function() {
    
    var dormlist = $("ul#dormlist");
    var searchbar = $("#dormsearch");
    
    searchbar.keyup(function() {
        console.log("typing: " + searchbar.val());
        
        if (searchbar.val().length == 0) {
            //dormlist.find("li").css("display", "block");
            dormlist.find("li").slideDown("fast");
        }
        
        else {
            
            dormlist.find("li").each(function() {

                var dorm = $(this).html();
                //if (dorm.toLowerCase() != searchbar.val().toLowerCase()) {
                if (dorm.toLowerCase().indexOf(searchbar.val().toLowerCase()) === -1) {
                    $(this).slideUp("fast");
                }
                else {
                    $(this).slideDown("fast");
                }
            });
        }
        
    });
    
});
