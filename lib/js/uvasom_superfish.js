/**
 * Apply superfish enhancement to usual menus with different settings.
 *
 * @author Gary Jones
 * @link http://code.garyjones.co.uk/change-superfish-arguments/
 */
jQuery(document).ready(function($) {
	$('#nav ul.superfish, #subnav ul.superfish, #header ul.nav, #header ul.menu').superfish({
 
		// 0.2 second delay on mouseout
		delay:       0,
 
		// fade-in and slide-down animation
		animation:   {opacity:'show',height:'show'},
 
		// enable drop shadows
		dropShadows: false,
 
		// Dropdown our menu slowly
		speed:       'fast'
	});
});