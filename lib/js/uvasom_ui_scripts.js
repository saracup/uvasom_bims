(function($) {
    var $window = $(window);
    
    

    function checkWidth() {
        var windowsize = $window.width();
        if (windowsize > 768) {
            //if the window is greater than 768 px
           $('#header div.wrap div.widget-area').show("fast");             
        }
        else {
            //if the window is less than 768px       
            $("#uvasom_searchbutton a.searchbutton").toggle(function() {
        	$("#header div.wrap div.widget-area").hide();
        	$("#header div.wrap div.widget-area").show();
    		}, function() {
        	$("#header div.wrap div.widget-area").show();
        	$("#header div.wrap div.widget-area").hide();
    		});      
        }
    }
    // Execute on load
    checkWidth();
    // Bind event listener
    $(window).resize(checkWidth);
    
})(jQuery);
