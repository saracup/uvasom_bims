jQuery(document).ready(function($) {
var previousMegaMenu = "";
var liId = "";
$("#uvasom-menu-top-bar li a").click(function() {
   liId = $(this).parent().attr("id");
 
    $("#uvasom_megamenu").hide("fast", function(){       

 //ajax
					var request;
					if (window.XMLHttpRequest) {
						request = new XMLHttpRequest();
					} else {
						request = new ActiveXObject("Microsoft.XMLHTTP");
					}
					request.open('GET', '/wp-content/plugins/uvasomnavbar/submenus/'+liId+'.php');
					request.onreadystatechange = function() {
						if ((request.readyState===4) && (request.status===200)) {
							var modify =
							document.getElementById('uvasom_megamenu');
							modify.innerHTML = request.responseText;
							$('#uvasom_megamenu').prepend('<a class="closebox" href="#">close <img class="closebox" src="/wp-content/plugins/uvasomnavbar/images/closebox_blue.png" /></a>');
							$("a.closebox").click(function() {
            					$('#uvasom_megamenu').hide();
     		   });

						}
					}
				
					request.send();	
//end ajax	
        //$("#uvasom_megamenu").html(newHtml);
    });
 
    if (previousMegaMenu != liId) {
        $("#uvasom_megamenu").show("fast");
        previousMegaMenu = liId;
    }
    else {
        previousMegaMenu = "";
    }  
});

			$("#wrap").click(function() {
			$('#uvasom_megamenu').hide();
			   });
 });
