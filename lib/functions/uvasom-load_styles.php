<?php
function uvasom_styles()
{
$sec_type = genesis_get_option( 'uvasom_section_type' );
$site_type = genesis_get_option( 'uvasom_site_type' );
if (strpos($_SERVER["REQUEST_URI"], 'q=')) {
?>
<link rel="stylesheet" id="uvasomsearch" href="<?php echo get_stylesheet_directory_uri(); ?>/lib/styles/uvasomsearch.css" type="text/css" media="screen" />
<?php
}
if (function_exists('uvasomnavbar'))
{
?>
<link rel="stylesheet" id="uvasomnavbar" href="<?php echo get_stylesheet_directory_uri(); ?>/lib/styles/uvasomnavbar.css" type="text/css" media="screen" />
<?php
}
?>
<?php
if (class_exists('GFCommon')) {
?>
<link rel="stylesheet" id="gravity-css" href="<?php echo get_stylesheet_directory_uri(); ?>/lib/styles/gforms.css" type="text/css" media="screen" />
<?php
}
if (class_exists('gallery_ss')) {
?>
<link rel="stylesheet" id="gravity-css" href="<?php echo get_stylesheet_directory_uri(); ?>/lib/styles/gss.css" type="text/css" media="screen" />
<?php
}

if (function_exists('Zotpress_theme_includes'))
{
?>
<link rel="stylesheet" id="uvasomzotpress" href="<?php echo get_stylesheet_directory_uri(); ?>/lib/styles/zotpress.css" type="text/css" media="screen" />
<?php
}

if (function_exists('jqlb_init'))
{
?>
<link rel="stylesheet" id="uvasomwplightbox" href="<?php echo get_stylesheet_directory_uri(); ?>/lib/styles/wplightbox.css" type="text/css" media="screen" />
<?php
}
?>
<link rel="stylesheet" id="uvasombimsprint" href="<?php echo get_stylesheet_directory_uri(); ?>/lib/styles/print.css" type="text/css" media="print" />
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/lib/styles/ie.css"  />
<![endif]-->
<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/lib/styles/ie7.css"  />
<![endif]-->
<!--[if IE 8]>
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/lib/styles/ie8.css"  />
<![endif]-->

<!--[if IE]>
<![endif]-->
<!--[if lte IE 7]>
<![endif]-->
<style type="text/css">
h1.entry-title, #uvasom_page_title h2.entry-title, body.search h1.archive-title {
	background-image:url(<?php echo get_stylesheet_directory_uri().'/images/titlebg/'.genesis_get_option( 'uvasom_site_type' ) ?>.jpg);
}
.squelch-taas-toggle .squelch-taas-toggle-shortcode-content, .squelch-taas-accordion .ui-accordion-content {
padding: 0em 2.2em 1em 2.2em;
}
.squelch-taas-toggle .ui-accordion-header, .squelch-taas-accordion .ui-accordion-header {
margin: 5px 0 0 0;
padding: 5px 0 5px 2.2em;
font-weight: bold;
letter-spacing: 0;
text-transform: none;
font-size: 1.1rem;
}
</style>
<?php
}
?>
