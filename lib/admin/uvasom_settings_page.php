<?php
/**
 * UVA SOM Settings
 * Requires Genesis 1.8 or later
 *
 * This file registers all of this child theme's specific Theme Settings, accessible from
 * Genesis > Child Theme Settings.
 *
 * @package     BE Genesis Child
 * @author      Bill Erickson <bill@billerickson.net>
 * @copyright   Copyright (c) 2011, Bill Erickson
 * @license     http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link        https://github.com/billerickson/BE-Genesis-Child
 */ 
 
/**
 * Registers a new admin page, providing content and corresponding menu item
 * for the Child Theme Settings page.
 *
 * @package BE Genesis Child
 * @subpackage Admin
 *
 * @since 1.0.0
 */
class UVASOM_Settings extends Genesis_Admin_Boxes {
	/**
	 * Create an admin menu item and settings page.
	 * 
	 * @since 1.0.0
	 */
	function __construct() {
		// Specify a unique page ID. 
		$page_id = 'child';
		// Set it as a child to genesis, and define the menu and page titles
		$menu_ops = array(
			'submenu' => array(
				'parent_slug' => '',
				'page_title'  => 'UVA SOM Theme Settings',
				'menu_title'  => 'UVA SOM Settings',
			)
		);
		// Set up page options. These are optional, so only uncomment if you want to change the defaults
		$page_ops = array(
		//	'screen_icon'       => 'options-general',
		//	'save_button_text'  => 'Save Settings',
		//	'reset_button_text' => 'Reset Settings',
		//	'save_notice_text'  => 'Settings saved.',
		//	'reset_notice_text' => 'Settings reset.',
		);		
		// Give it a unique settings field. 
		// You'll access them from genesis_get_option( 'option_name', 'child-settings' );
		$settings_field = 'uvasom-settings';
		// Set the default values
		$default_settings = array(
				'uvasom_section_type' => 'secondary',
				'uvasom_site_type' => 'education'
		);
		// Create the Admin Page
		$this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );
		// Initialize the Sanitization Filter
		add_action( 'genesis_settings_sanitizer_init', array( $this, 'sanitization_filters' ) );
	}
	/** 
	 * Set up Sanitization Filters
	 *
	 * See /lib/classes/sanitization.php for all available filters.
	 *
	 * @since 1.0.0
	 */	
	function sanitization_filters() {
		genesis_add_option_filter( 'no_html', $this->settings_field,
			array(
				'uvasom_section_type',
				'uvasom_site_type',
			) );
	}
	/**
	 * Set up Help Tab
	 * Genesis automatically looks for a help() function, and if provided uses it for the help tabs
	 * @link http://wpdevel.wordpress.com/2011/12/06/help-and-screen-api-changes-in-3-3/
	 *
	 * @since 1.0.0
	 */
	 function help() {
	 	$screen = get_current_screen();
 
		$screen->add_help_tab( array(
			'id'      => 'uvasom-help', 
			'title'   => 'UVA SOM Help',
			'content' => '<p>Help content goes here.</p>',
		) );
	 }
	/**
	 * Register metaboxes on Child Theme Settings page
	 *
	 * @since 1.0.0
	 *
	 * @see UVASOM_Settings::contact_information() Callback for contact information
	 */
	function metaboxes() {
		add_meta_box('uvasom-settings', 'UVA SOM Site Settings', array( $this, 'uvasom_settings_meta_box' ), $this->pagehook, 'main', 'high');
	}
	/**
	 * Callback for Contact Information metabox
	 *
	 * @since 1.0.0
	 *
	 * @see UVASOM_Settings::metaboxes()
	 */
function uvasom_settings_meta_box() {
	$uvasom_section_types = array(
				'main' => 'Main SOM-wide Topic',
				'secondary' => 'Secondary Level Topic or Department (default)'
				);
	$uvasom_site_types = array(
				'home' => 'UVA SOM Home Page',
				'administration' => 'Administration',
				'clinicaldepartment' => 'Clinical Department',
				'community' => 'Community',
				'education' => 'Education',
				'research' => 'Research'
				);
	$uvasom_footercolumns_types = array(
				'' => 'No Widget Columns in Footer',
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4'
				);
?>
<p><strong>Site Type:</strong><br />What look and feel is appropriate for this site?<br />
		<select name="<?php echo GENESIS_SETTINGS_FIELD; ?>[uvasom_site_type]">
			<?php foreach ( $uvasom_site_types as $type => $label ) : ?>
			<option value="<?php echo $type; ?>" <?php selected($type, $this->get_field_value('uvasom_site_type')); ?>><?php _e($label, 'genesis'); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
 <?php
 }
}
add_action( 'genesis_admin_menu', 'uva_som_theme_settings' );
/**
 * Add the Theme Settings Page
 *
 * @since 1.0.0
 */
function uva_som_theme_settings() {
	global $_child_theme_settings;
	$_child_theme_settings = new UVASOM_Settings;	 	
}