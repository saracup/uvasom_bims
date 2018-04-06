<?php
 
//add_action( 'get_header', 'uvasombims_superfish_arguments' );
/**
 * Just before we start outputting, we deregister the default settings, and
 * add reference to our own instead.
 * 
 * @author Gary Jones
 * @link   http://code.garyjones.co.uk/change-superfish-arguments/
 */
function custom_superfish_arguments() {
 
	if ( genesis_get_option( 'nav_superfish' ) || 
		genesis_get_option( 'subnav_superfish' ) || 
		is_active_widget( 0, 0, 'menu-categories' ) || 
		is_active_widget( 0, 0, 'menu-pages' ) 
	) {
		wp_deregister_script( 'uvasom-superfish-args' );
		wp_enqueue_script( 'uvasom-superfish-args', get_stylesheet_directory_uri(). '/lib/js/uvasom-superfish.js', array( 'superfish' ), '1.0', true );
	}
}