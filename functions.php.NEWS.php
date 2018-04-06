<?php
/** Start the engine */
require_once( get_template_directory() . '/lib/init.php' );

/** Child theme (do not remove) */
define( 'CHILD_THEME_NAME', 'UVA SOM Newsletter Child Theme' );
define( 'CHILD_THEME_URL', 'http://medicine.virginia.edu' );

/*include ancillary files*/
require_once( trailingslashit( get_template_directory() ) . 'lib/admin/theme-settings.php');
include_once(CHILD_DIR . '/lib/functions/uvasomnews-load_styles.php' );
require_once(CHILD_DIR . '/lib/admin/WpSingleImageUploads.php');
global $ttSiuUploader;
$ttSiuUploader = WpSingleImageUploads::getInstance(WpSingleImageUploads::TYPE_THEME , "uvasom_news");
//include_once(CHILD_DIR . '/lib/admin/uvasomnews_menu_settings.php' );
//include_once(CHILD_DIR . '/lib/admin/uvasomnews-settings.php' );
include_once(CHILD_DIR . '/lib/admin/uvasomnews_email.php' );
//include mailchimp includes for dean's site
global $blog_id;
if ($blog_id == 44) {
include_once(CHILD_DIR . '/lib/functions/uvasom_mailinglist_write.php' );
include_once(CHILD_DIR . '/lib/functions/uvasom_gforms_validation.php' );
}
//include_once(CHILD_DIR . '/lib/admin/uvasomnews_headerupload.php' );
/************** add a hidden style to the genesis settings page for conditional form field display*********/
function uvasomnewsAdmin() {
    $url = get_option('siteurl');
    $url = get_stylesheet_directory_uri().'/wp-admin.css';
    echo '<!-- custom admin css -->
          <link rel="stylesheet" type="text/css" href="' . $url . '" />
         <!-- /end custom admin css -->';
	echo '<script type="text/javascript" src="'. get_stylesheet_directory_uri().'/lib/js/uvasom_news_feature.js"></script>';
}
add_action('admin_head', 'uvasomnewsAdmin');
/************* add javascript to genesis settings page *********/
function uvasomnews_admin_js() {
    $url = get_option('siteurl');
    $url = get_stylesheet_directory_uri().'/lib/js/uvasomnews_genesis_settings.js';
    echo '<script type="text/javascript" src="'. $url . '"></script>';
}
add_action('admin_footer', 'uvasomnews_admin_js',15);
/****************enqueue script for IE dropshadow div***********/
function uvasom_news_dropshadow() {
	    wp_enqueue_script( 'uvasom_news_dropshadow',get_stylesheet_directory_uri().'/lib/js/uvasomnews_dropshadow.js',array(),'',true );
}
add_action( 'wp_enqueue_scripts', 'uvasom_news_dropshadow' );

/** Add Viewport meta tag for mobile browsers */
add_action( 'genesis_meta', 'news_add_viewport_meta_tag' );
function news_add_viewport_meta_tag() {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}

$content_width = apply_filters( 'content_width', 580, 430, 910 );
//Accessibility script added Cathy Derecki 12/13/2017
/************* Add Accessibility Script ******/
function uvasom_accessibility() {
echo '<script type="text/javascript">var access_analytics={base_url:"https://analytics.ssbbartgroup.com/api/",instance_id:"AA-58bdcc11cee35"};(function(a,b,c){var d=a.createElement(b);a=a.getElementsByTagName(b)[0];d.src=c.base_url+"access.js?o="+c.instance_id+"&v=2";a.parentNode.insertBefore(d,a)})(document,"script",access_analytics);</script>';
}

add_action('wp_head', 'uvasom_accessibility',1);
/******************** hide admin bar for everyone but Admins and Editors ***************/
// This is being added since the plugin to hide the admin bar was deleted.
//Function added Cathy Derecki 12/22/2017
if (!current_user_can('edit_posts')) {
	add_filter('show_admin_bar', '__return_false');
}
/****************Add typekit fonts***********/
/*function uvasomnews_fonts() {
?>
<script type="text/javascript" src="//use.typekit.net/mai1efb.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script><?php
}

add_action('wp_head', 'uvasomnews_fonts');*/
/************* Add navbar adjustments and IE Hacks ******/
add_action('wp_head', 'uvasomnews_styles',15);
/** Add support for structural wraps */
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'inner',
	'footer-widgets',
	'footer'
) );
/********add classes to the body for styling ***/
function uvasomnews_add_classes( $classes ) {
	$classes[] = 'uvasomnews';
	return $classes;
}
add_filter( 'body_class', 'uvasomnews_add_classes' );
/********Add new image sizes ***/
add_image_size( 'home-bottom', 110, 110, TRUE );
add_image_size( 'home-middle-left', 280, 165, TRUE );
add_image_size( 'home-middle-right', 50, 50, TRUE );
add_image_size( 'home-tabs', 150, 220, TRUE );
add_image_size('Mini Square', 70, 70, TRUE);
add_image_size('Mini Portrait', 70, 105, TRUE);
add_image_size('Square', 100, 100, TRUE);
add_image_size('Featured Tabs', 150, 225, TRUE);
add_image_size('Email Sidebox', 180, 125, TRUE);


/** Add support for custom header */
add_theme_support( 'genesis-custom-header', array(
	'width'	=> 960,
	'height'	=> 110
) );

/** Add support for custom background */
add_theme_support( 'custom-background' );
/**** Allow epub uploads for archives *******/
function addUploadMimes($mimes) {
    $mimes = array_merge($mimes, array(
        'epub|mobi' => 'application/octet-stream'
    ));
    return $mimes;
}
add_filter('upload_mimes', 'addUploadMimes');
/**put category name at top of archive pages *****/
/*function uvasomnews_archive_title()
{
	if (is_archive())
	{
		echo '<h1 class="archive-title">Archive for: &#8220;';
		if (is_category())
		{
		single_cat_title();
		}
		if (is_tag())
		{
		single_tag_title();
		}
		echo '&#8221;</h1>';


	}
}
add_action( 'genesis_before_loop', 'uvasomnews_archive_title' );*/
/*********change the "speak your mind" wording to something more appropriate ****************/
add_filter( 'comment_form_defaults', 'sp_comment_form_defaults' );
function sp_comment_form_defaults( $defaults ) {

	$defaults['title_reply'] = __( 'Leave a Comment' );
	return $defaults;

}
/***Dont trim html from the excerpt *****/
/*****************Unregister header sidebar *****************/
unregister_sidebar( 'header-right' );
/** Reposition the secondary navigation */
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_before', 'genesis_do_subnav' );

/** Add after post ad section */
add_action( 'genesis_after_post_content', 'news_after_post_ad', 9 );
function news_after_post_ad() {
    if ( is_single() && is_active_sidebar( 'after-post-ad' ) ) {
    echo '<div class="after-post-ad">';
	dynamic_sidebar( 'after-post-ad' );
	echo '</div><!-- end .after-post-ad -->';
	}
}

/** Add after content ad section */
add_action( 'genesis_before_footer', 'news_after_content_ad' );
function news_after_content_ad() {
    if ( is_active_sidebar( 'after-content-ad' ) ) {
    echo '<div class="after-content-ad">';
	dynamic_sidebar( 'after-content-ad' );
	echo '</div><!-- end .after-content-ad -->';
	}
}

/** Add support for 3-column footer widgets */
add_theme_support( 'genesis-footer-widgets', 3 );

/** Register widget areas */
genesis_register_sidebar( array(
	'id'				=> 'home-top',
	'name'			=> __( 'Home Top', 'news' ),
	'description'	=> __( 'This is the home top section.', 'news' ),
) );
genesis_register_sidebar( array(
	'id'				=> 'home-middle-left',
	'name'			=> __( 'Home Middle Left', 'news' ),
	'description'	=> __( 'This is the home middle left section.', 'news' ),
) );
genesis_register_sidebar( array(
	'id'				=> 'home-middle-right',
	'name'			=> __( 'Home Middle Right', 'news' ),
	'description'	=> __( 'This is the home middle right section.', 'news' ),
) );
genesis_register_sidebar( array(
	'id'				=> 'home-bottom',
	'name'			=> __( 'Home Bottom', 'news' ),
	'description'	=> __( 'This is the home bottom section.', 'news' ),
) );
genesis_register_sidebar( array(
	'id'				=> 'after-post-ad',
	'name'			=> __( 'After Post Ad', 'news' ),
	'description'	=> __( 'This is the after post ad section.', 'news' ),
) );
genesis_register_sidebar( array(
	'id'				=> 'after-content-ad',
	'name'			=> __( 'After Content Ad', 'news' ),
	'description'	=> __( 'This is the after content ad section.', 'news' ),
) );
genesis_register_sidebar( array(
	'id'				=> 'email-feature-full',
	'name'			=> __( 'Email Feature Full Width', 'news' ),
	'description'	=> __( 'Top Feature on Full Width Widgetized HTML Emails.', 'news' ),
	'before_widget' => '<table id="%1$s" width="650" class="email"><tr><td class="widget %2$s">',
	'after_widget'  => "</td></tr></table>\n",
	'before_title'  => '<h3 style="font-family:Georgia, Times, serif;font-weight:normal;font-size:18px;margin-top:0px;margin-bottom:-8px;">',
	'after_title'   => "</h3></tr></td>\n<tr><td>\n"

) );
genesis_register_sidebar( array(
	'id'				=> 'email-feature-1',
	'name'			=> __( 'Email Feature 1', 'news' ),
	'description'	=> __( 'Top Feature on Widgetized HTML Emails.', 'news' ),
	'before_widget' => '<table id="%1$s" width="466" class="email"><tr><td class="widget %2$s">',
	'after_widget'  => "</td></tr></table>\n",
	'before_title'  => '<h3 style="font-family:Georgia, Times, serif;font-weight:normal;font-size:18px;margin-top:0px;margin-bottom:-8px;">',
	'after_title'   => "</h3></tr></td>\n<tr><td>\n"

) );
genesis_register_sidebar( array(
	'id'				=> 'email-feature-1a',
	'name'			=> __( 'Email Feature 1a', 'news' ),
	'description'	=> __( 'Optional Feature in Mid-Section Left on Widgetized HTML Emails.', 'news' ),
	'before_widget' => '<table id="%1$s" width="226" class="email middle"><tr><td class="widget %2$s">',
	'after_widget'  => "</td></tr></table>\n",
	'before_title'  => '<h3 style="font-family:Georgia, Times, serif;font-weight:normal;font-size:18px;margin-top:0px;margin-bottom:-8px;">',
	'after_title'   => "</h3></tr></td>\n<tr><td>\n"

) );
genesis_register_sidebar( array(
	'id'				=> 'email-feature-1b',
	'name'			=> __( 'Email Feature 1b', 'news' ),
	'description'	=> __( 'Optional Feature in Mid-Section Right on Widgetized HTML Emails.', 'news' ),
	'before_widget' => '<table id="%1$s" width="226" class="email middle"><tr><td class="widget %2$s">',
	'after_widget'  => "</td></tr></table>\n",
	'before_title'  => '<h3 style="font-family:Georgia, Times, serif;font-weight:normal;font-size:18px;margin-top:0px;margin-bottom:-8px;">',
	'after_title'   => "</h3></tr></td>\n<tr><td>\n"

) );
genesis_register_sidebar( array(
	'id'				=> 'email-feature-1c',
	'name'			=> __( 'Email Feature 1c', 'news' ),
	'description'	=> __( 'Optional Feature in Bottom Main Section on Widgetized HTML Emails.', 'news' ),
	'before_widget' => '<table id="%1$s" width="466" class="email bottom"><tr><td class="widget %2$s">',
	'after_widget'  => "</td></tr></table>\n",
	'before_title'  => '<h3 style="font-family:Georgia, Times, serif;font-weight:normal;font-size:18px;margin-top:0px;margin-bottom:-8px;">',
	'after_title'   => "</h3></tr></td>\n<tr><td>\n"

) );
genesis_register_sidebar( array(
	'id'				=> 'email-feature-2',
	'name'			=> __( 'Email Feature 2', 'news' ),
	'description'	=> __( 'Secondary Feature on Widgetized HTML Emails.', 'news' ),
	'before_widget' => '<table id="%1$s" width="215" class="emailside"><tr><td class="widget %2$s">',
	'after_widget'  => "</td></tr></table>\n",
	'before_title'  => '<h3 style="font-family:Georgia, Times, serif;font-weight:normal;font-size:18px;margin-top:0px;margin-bottom:-8px;">',
	'after_title'   => "</h3></tr></td>\n<tr><td>\n"

) );

/****************add fonts for Slidedeck**************************/
function uvasomnews_custom_fonts_to_slidedeck( $fonts, $slidedeck ){
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

add_filter( 'slidedeck_get_font', 'uvasomnews_custom_fonts_to_slidedeck', 10, 2 );
function add_my_custom_typekit_font_script( $slidedeck, $preview ){
    // Replace the JavaScript tags here with the code for your Typekit Kit
    $script_output = '<script type="text/javascript" src="//use.typekit.net/atu1xns.js"></script>';
    $script_output .= '<script type="text/javascript">try{Typekit.load();}catch(e){}</script>';
    echo $script_output;
}

add_action( 'slidedeck_iframe_header', 'add_my_custom_typekit_font_script', 10, 2);
/*Add scripts to footer*/
function uvasomnews_footer_scripts() {
   wp_enqueue_script('uvasomnews_subtitle', get_stylesheet_directory_uri(). '/lib/js/uvasom_news_subtitle.js', array('jquery'),' ',true);
   wp_enqueue_script('uvasomnews_embed_iframe', get_stylesheet_directory_uri(). '/lib/js/uvasom_embed_iframe.js', array('jquery'),' ',true);
}

add_action('wp_footer', 'uvasomnews_footer_scripts');
//Allow shortcodes in text widgets.
add_filter('widget_text', 'do_shortcode');
