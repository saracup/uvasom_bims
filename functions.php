<?php
/*
Child Theme Name: UVA-SOM Genesis Child Based on BIMS
Author: Cathy Finn-Derecki
Version: 1.00
URL: http://technology.med.virginia.edu/digitalcommunications
*/
/************* REGISTER CHILD THEME (You can Change This) ******/
define( 'CHILD_THEME_NAME', 'UVA-SOM BIMS Genesis Child Framework' );
define( 'CHILD_THEME_URL', 'http://technology.med.virginia.edu/digitalcommunications' );
require_once(TEMPLATEPATH.'/lib/init.php');
require_once(CHILD_DIR . '/lib/functions/uvasom-conditionals.php' );
include_once(CHILD_DIR . '/lib/functions/uvasom-formatting.php' );
include_once(CHILD_DIR . '/lib/functions/uvasom_sop_list.php' );
include_once( CHILD_DIR . '/lib/functions/uvasom-superfish.php');
include_once(CHILD_DIR . '/lib/functions/uvasom-load_styles.php' );
include_once( CHILD_DIR . '/lib/functions/uvasom-backgrounds.php');
include_once( CHILD_DIR . '/lib/admin/uvasom_settings.php');
//filter blog registration email for technology site. Could extend to all sites in future.
//Experimenting on this site with Gravity Forms Registration.
/** Add Viewport meta tag for mobile browsers */
add_action( 'genesis_meta', 'add_viewport_meta_tag' );
function add_viewport_meta_tag() {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0"/>';
}
/****************javascript to format calendar feed***********/
function uvasombims_scripts() {
    wp_enqueue_script( 'uvasombims_calendar_format',get_stylesheet_directory_uri().'/lib/js/uvasom_calendar_format.js',array('jquery'),'',true );
    wp_enqueue_script( 'uvasombims_mobilemenu',get_stylesheet_directory_uri().'/lib/js/uvasom_mobilemenu.js',array('jquery'),'',true );
}
add_action('wp_enqueue_scripts', 'uvasombims_scripts',1);
//Accessibility script added Cathy Derecki 12/13/2017
/************* Add Accessibility Script ******/
function uvasom_accessibility() {
echo '<script type="text/javascript">var access_analytics={base_url:"https://analytics.ssbbartgroup.com/api/",instance_id:"AA-58bdcc11cee35"};(function(a,b,c){var d=a.createElement(b);a=a.getElementsByTagName(b)[0];d.src=c.base_url+"access.js?o="+c.instance_id+"&v=2";a.parentNode.insertBefore(d,a)})(document,"script",access_analytics);</script>';
}

add_action('wp_head', 'uvasom_accessibility',1);
/************* Add IE Hacks ******/
add_action('wp_head', 'uvasom_styles',15);
/************ADD GOOGLE FONTS, SUBSTITUTING FOR TYPEKIT Cathy Derecki 12/13/2017*************/
function uvasombims_gfonts() { ?>
  <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700" rel="stylesheet">
<?php }
add_action('wp_head', 'uvasombims_gfonts',1);
/************add typekit, allowing for IE not to load it*************/
/*function uvasombims_typekit() {
	if (!wp_is_mobile()) {
	?>
<![if !lte IE 8]>
    <script type='text/javascript' src="//use.typekit.net/atu1xns.js?ver=3.8.1"></script>
	<script type='text/javascript' src="<?php echo get_stylesheet_directory_uri();?>/lib/js/uvasom_typekit.js?ver=3.8.1"></script>
<![endif]>
<?php
	}
}*/
//Disable Typekit Cathy Derecki 12/13/2017
//add_action('wp_head', 'uvasombims_typekit',1);
/***********add admin stylesheet*********/
function uvasombims_custom_wp_admin_style() {
        wp_register_style( 'uvasombims_wp_admin_css', get_stylesheet_directory_uri() . '/lib/styles/admin.css', false, '1.0.0' );
        wp_enqueue_style( 'uvasombims_wp_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'uvasombims_custom_wp_admin_style',200);

/****************** Unregister layouts ****************/
genesis_unregister_layout( 'content-sidebar' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
/** Add custom header support */
add_theme_support( 'genesis-custom-header', array( 'width' => 1140, 'height' => 120, 'header_image' => '' ) );
/******add custom backgrounds***********/
//add_theme_support( 'custom-background' );
/******add image size for four column home page layout*******/
add_image_size('Footer Four Column', 240, 72, TRUE);
add_image_size( 'home-bottom', 110, 110, TRUE );
add_image_size( 'home-middle-left', 280, 165, TRUE );
add_image_size( 'home-middle-right', 50, 50, TRUE );
add_image_size( 'home-tabs', 150, 220, TRUE );
add_image_size('Small Portrait', 105, 158, TRUE);
add_image_size('Mini Square', 70, 70, TRUE);
add_image_size('Mini Portrait', 70, 105, TRUE);
add_image_size('Square', 100, 100, TRUE);
add_image_size('Featured Tabs', 150, 225, TRUE);
add_image_size('Email Sidebox', 180, 125, TRUE);
/*******add custom images sizes to image uploader**********/
function uvasombims_add_custom_sizes( $imageSizes ) {
  $uvasombims_sizes = array(
		'Footer Four Column' => 'Banner',
		'Small Portrait' => 'Small Portrait',
		'Mini Portrait' => 'Mini Portrait',
		'Mini Square' => 'Mini Square',
		'Square' => 'Square',
		'Featured Tabs' => 'Featured Tabs',
		'Email Sidebox' => 'Email Sidebox'
	);
	return array_merge( $imageSizes, $uvasombims_sizes );
}
add_filter( 'image_size_names_choose', 'uvasombims_add_custom_sizes' );
/*****************Unregister header sidebar *****************/
unregister_sidebar( 'header-right' );
/******************Register home page sidebar***************/
// Register a new sidebar
genesis_register_sidebar( array(
    'id'          => 'home-top-sidebar',
    'name'        => 'Home Top Sidebar',
    'description' => 'This is the optional full-width home page sidebar widget area.'
) );
/*********change sidebar order so you don't lose the primary navigation ********/
add_action( 'genesis_after_header', 'uvasom_change_sidebar_order' );
/**
 * Swap Primary and Secondary Sidebars on Sidebar-Sidebar-Content
 *
 * @author Bill Erickson
 * @link http://www.billerickson.net/switch-genesis-sidebars/
 */
function uvasom_change_sidebar_order() {
    $site_layout = genesis_site_layout();
    if ( 'sidebar-content-sidebar' == $site_layout ) {
        // Remove the Primary Sidebar from the Primary Sidebar area.
        remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );

        // Remove the Secondary Sidebar from the Secondary Sidebar area.
        remove_action( 'genesis_sidebar_alt', 'genesis_do_sidebar_alt' );

        // Place the Secondary Sidebar into the Primary Sidebar area.
        add_action( 'genesis_sidebar', 'genesis_do_sidebar_alt' );

        // Place the Primary Sidebar into the Secondary Sidebar area.
        add_action( 'genesis_sidebar_alt', 'genesis_do_sidebar' );
    }
}
/******* display root network link in tertiary or lab site ************/
function uvasom_root_site()
{
	$sec_type = genesis_get_option('uvasom_section_type');
	if ($sec_type == 'tertiary') {
	if(genesis_get_option('uvasom_tertiaryhome_url') === ""){ $uvasom_site_url = network_site_url();
	} else { $uvasom_site_url = genesis_get_option('uvasom_tertiaryhome_url'); }
	if(genesis_get_option('uvasom_tertiaryhome_name') === ""){ $uvasom_site_name = get_site_option('site_name');
	} else { $uvasom_site_name = genesis_get_option('uvasom_tertiaryhome_name'); }
	$uvasom_rootsite = "\n".'<div id="uvasom_rootsite">';
	$uvasom_rootsite .= '<a href="'.$uvasom_site_url.'">'.$uvasom_site_name.'</a></div>'."\n";
	echo $uvasom_rootsite;
	}
}
add_action ('genesis_header','uvasom_root_site',9);
/******* display site search in header ************/
function uvasom_wpsearch()
{
	echo '<div id="uvasom_wpsearch">';
	if ((genesis_get_option('uvasomsearch_option','UVASOMSEARCH_SETTINGS_FIELD') == 'google')|| (genesis_get_option('uvasomsearch_option','UVASOMSEARCH_SETTINGS_FIELD') == '')){
	uvasom_sitesearch_form('local');
	}
	if (genesis_get_option('uvasomsearch_option','UVASOMSEARCH_SETTINGS_FIELD') == 'wordpress'){
	get_search_form();
	}
	echo '</div>';
}
add_action ('genesis_header','uvasom_wpsearch',10);
/******Display sidebar on home page**********/
function uvasom_homepage_sidebar()
{
	if (is_front_page())
	{
?>
<div id="home-top-sidebar" class="widget-area">
    <?php
    dynamic_sidebar( 'Home Top Sidebar' );
    ?>
</div>
<div class="clearfix"></div>
<?php
	}
}
if (!strpos($_SERVER["REQUEST_URI"], 'q=')) {
add_action('genesis_after_header','uvasom_homepage_sidebar',15);
}
/*********change the "speak your mind" wording to something more appropriate ****************/
add_filter( 'comment_form_defaults', 'sp_comment_form_defaults' );
function sp_comment_form_defaults( $defaults ) {

	$defaults['title_reply'] = __( 'Leave a Comment' );
	return $defaults;

}
/******* remove inline styling for images and captions*******/
add_shortcode('wp_caption', 'fixed_img_caption_shortcode');
add_shortcode('caption', 'fixed_img_caption_shortcode');
function fixed_img_caption_shortcode($attr, $content = null) {
	// New-style shortcode with the caption inside the shortcode with the link and image tags.
	if ( ! isset( $attr['caption'] ) ) {
		if ( preg_match( '#((?:<a [^>]+>\s*)?<img [^>]+>(?:\s*</a>)?)(.*)#is', $content, $matches ) ) {
			$content = $matches[1];
			$attr['caption'] = trim( $matches[2] );
		}
	}
	// Allow plugins/themes to override the default caption template.
	$output = apply_filters('img_caption_shortcode', '', $attr, $content);
	if ( $output != '' )
		return $output;
	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> 'alignnone',
		'width'	=> '99%',
		'caption' => ''
	), $attr));
	if ( 1 > (int) $width || empty($caption) )
		return $content;
	if ( $id ) $id = 'id="' . esc_attr($id) . '" ';
	return '<div ' . $id . 'class="wp-caption ' . esc_attr($align) . '" style="width: ' . $width . 'px">'
	. do_shortcode( $content ) . '<p class="wp-caption-text">' . $caption . '</p></div>';
}
/* @@ Additional classes, eg adding new class to particular posts etc
------------------------------------------------------------ */
/** adds body classes for site types and slideshow size */
function uvasom_add_classes( $classes ) {
	global $blog_id;
	$type = genesis_get_option( 'uvasom_site_type' );
	$sec_type = genesis_get_option( 'uvasom_section_type' );
	$sitename = get_current_blog_id();
	$classes[] = 'site-type_'.$type;
	$classes[] .= 'site-section_'.$sec_type;
	$classes[] .= 'site_'.$sitename;
	$classes[] .= 'uvasombims';
/**
 * Add the subdomain and the subdirectory to the body classes
 * Adds a class of network-[subdomain] and site-[subdirectory] to the body classes.
 * Uses site-root if this is the root site in the network
	 */
	$blog_details = get_blog_details( $blog_id, array( 'domain' ) );
	$domain = str_replace( array( '.med.virginia.edu' ), '', $blog_details->domain );
	$classes[] = 'network-' . $domain;

/**
 * Adds a class of "empty" to the body if there is no content in the post.
*/
	if( empty( $post->post_content) ) {
	$classes[] = 'empty';
}
	return $classes;
}
add_filter( 'body_class', 'uvasom_add_classes' );
/********add classes to the admin body for styling in admin ***/
function uvasombims_add_admin_classes( $classes ) {
	return '$classes uvasombims';
}
add_filter ('admin_body_class','uvasombims_add_admin_classes');
/********** Remove page display of site description ********/
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
// Move Breadcrumbs Below Main Nav
remove_action('genesis_before_loop', 'genesis_do_breadcrumbs');
//Relocate the post or page title
function uvasom_do_post_title()
{
	if (((is_single()) || (is_page())) && (!is_front_page()))
	{
	remove_action( 'genesis_post_title','genesis_do_post_title' );
	echo '<div class="clearfix"></div>';
	echo '<div id="uvasom_page_title">';
	genesis_do_breadcrumbs();
	genesis_do_post_title();
	echo '</div>';
	}
	if (is_category())
	{
	echo '<div class="clearfix"></div>';
	echo '<div id="uvasom_page_title">';
	genesis_do_breadcrumbs();
	$category = get_the_category();
	echo '<h1 class="entry-title">'.$category[0]->cat_name.'</h1>';
	echo '</div>';
	}
}
add_action('genesis_after_header', 'uvasom_do_post_title');
/********** Change breadcrumb separator to caret ********/
add_filter( 'genesis_breadcrumb_args', 'uvasom_breadcrumb_args' );
/**
 * Amend breadcrumb arguments.
 *
 * @param array $args Default breadcrumb arguments
 * @return array Amended breadcrumb arguments
 */
function uvasom_breadcrumb_args( $args ) {
    $args['sep']                     = '  >  ';
 	$args['labels']['prefix']        = '';
    return $args;
}
/*********Display the number of footers selected in the site options, if any *********/
add_theme_support( 'genesis-footer-widgets', genesis_get_option('uvasom_footercolumns_type'));
/***Allow for dynamic widths of selected footer sidebars*****/
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
add_action( 'genesis_before_footer', 'uvasom_footer_widget_areas' );
function uvasom_footer_widget_areas()
/**
 * Echos the markup necessary to facilitate the footer widget areas.
 *
 * Checks for a numerical parameter given when adding theme support - if none is
 * found, then the function returns early.
 *
 * The child theme must style the widget areas.
 *
 * @since 1.6.0
 *
 * @return null Returns early if number of widget areas could not be determined,
 * or nothing is added to the first widget area
 */
{
	$footer_widgets = get_theme_support( 'genesis-footer-widgets' );
	if ( ! $footer_widgets || ! isset( $footer_widgets[0] ) || ! is_numeric( $footer_widgets[0] ) )
		return;
	$footer_widgets = (int) $footer_widgets[0];
	/**
	 * Check to see if first widget area has widgets. If not,
	 * do nothing. No need to check all footer widget areas.
	 */
	if ( ! is_active_sidebar( 'footer-1' ) )
		return;
	$output  = '';
	$counter = 1;
	if (genesis_get_option('uvasom_footercolumns_type') == 1) {$uvasom_footer_class = '';}
	if (genesis_get_option('uvasom_footercolumns_type') == 2) {$uvasom_footer_class = 'one-half';}
	if (genesis_get_option('uvasom_footercolumns_type') == 3) {$uvasom_footer_class = 'one-third';}
	if (genesis_get_option('uvasom_footercolumns_type') == 4) {$uvasom_footer_class = 'one-fourth';}
	while ( $counter <= $footer_widgets ) {
		/** Darn you, WordPress! Gotta output buffer. */
		ob_start();
		dynamic_sidebar( 'footer-' . $counter );
		$widgets = ob_get_clean();
		$output .= sprintf( '<div class="footer-widgets-%d widget-area '.$uvasom_footer_class.'">%s</div>', $counter, $widgets );
		$counter++;
	}
	echo apply_filters( 'genesis_footer_widget_areas', sprintf( '<div id="footer-widgets" class="footer-widgets">%2$s%1$s%3$s</div>', $output, genesis_structural_wrap( 'footer-widgets', 'open', 0 ), genesis_structural_wrap( 'footer-widgets', 'close', 0 ) ) );
}

/****************add fonts for Slidedeck**************************/
function uvasom_custom_fonts_to_slidedeck( $fonts, $slidedeck ){
    $fonts['adobe-caslon-pro'] = array(
        // The name of the font displayed to the user in the drop-down
        'label' => "Adobe Caslon Pro",
        // The CSS font stack used
        'stack' => "'adobe-caslon-pro', sans-serif",
        // The CSS font weight used when this font is chosen
        'weight' => '300'
    );
    $fonts['proxima-nova-condensed'] = array(
        // The name of the font displayed to the user in the drop-down
        'label' => "Proxima Nova Condensed",
        // The CSS font stack used
        'stack' => "'proxima-nova-condensed', sans-serif",
        // The CSS font weight used when this font is chosen
        'weight' => '400'
    );
    return $fonts;
}
add_filter( 'slidedeck_get_font', 'uvasom_custom_fonts_to_slidedeck', 10, 2 );
function add_my_custom_typekit_font_script( $slidedeck, $preview ){
    // Replace the JavaScript tags here with the code for your Typekit Kit
    $script_output = '<script type="text/javascript" src="//use.typekit.net/atu1xns.js"></script>';
    $script_output .= '<script type="text/javascript">try{Typekit.load();}catch(e){}</script>';
    echo $script_output;
}
add_action( 'slidedeck_iframe_header', 'add_my_custom_typekit_font_script', 10, 2);
/*Add scripts to footer*/
/*function uvasom_footer_scripts() {
   wp_enqueue_script('uvasomnews_embed_iframe', get_stylesheet_directory_uri(). '/lib/js/uvasom_embed_iframe.js', array('jquery'),' ',true);
}
//add_action('wp_enqueue_scripts', 'uvasom_footer_scripts');?>*/
function uvasomnbims_footer_scripts() {
   //wp_enqueue_script('uvasomnews_embed_iframe', get_stylesheet_directory_uri(). '/lib/js/uvasom_embed_iframe.js', array('jquery'),' ',true);
   wp_enqueue_script('uvasombims_subtitle', get_stylesheet_directory_uri(). '/lib/js/uvasombims_subtitle.js', array('jquery'),' ',true);
}
add_action('wp_footer', 'uvasomnbims_footer_scripts');
//Allow shortcodes in text widgets.
add_filter('widget_text', 'do_shortcode');
