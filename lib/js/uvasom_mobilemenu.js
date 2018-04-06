jQuery(document).ready(function($){
    /* prepend menu icon */
	$('#title-area').after('<div id="mobile-menu"></div>');
	/* toggle nav */
	$("#mobile-menu").on("click", function(){
		$("#nav").slideToggle();
		$(this).toggleClass("active");
	});
});