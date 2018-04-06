<?php
/**
 * UVA School of Medicine Settings
 * Requires Genesis 1.8 or later
 *
 * This file registers all of the UVA SOM child theme specific Theme Settings, accessible from
 * Genesis > Child Theme Settings.
 *
 * @package     UVA School of Medicine Genesis Child
 * @author      Cathy Derecki <cad3r@virginia.edu>
 * @copyright   Copyright (c) 2012, Cathy Derecki
 * @license     http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)

 */ 
 /********LOAD JAVASCRIPT FOR CONDITIONAL DISPLAY OF TERTIARY HOME SITE URL*********/
function uvasombimsadmin_load_scripts() {
	wp_enqueue_script('jquery','',false);
wp_enqueue_script('uvasombims_tertiaryhome', get_stylesheet_directory_uri(). '/lib/admin/js/tertiaryhome.js', array('jquery'),' ',true);}
add_action('admin_enqueue_scripts', 'uvasombimsadmin_load_scripts');

add_filter('genesis_theme_settings_defaults', 'uvasom_settings_defaults');
/**
 * Register Defaults
 *
 * @param array $defaults
 * @return array modified defaults
 *
 */
function uvasom_settings_defaults( $defaults ) {
	$defaults[] = array(
				'uvasom_section_type' => 'secondary',
				'uvasom_site_type' => 'education',
				'uvasom_tertiary_default' => '1',
				);
	return $defaults;
}
add_action( 'genesis_settings_sanitizer_init', 'uvasom_sanitization_filters' );
/**
 * Sanitization
 *
 */
function uvasom_sanitization_filters() {
	genesis_add_option_filter( 'no_html', GENESIS_SETTINGS_FIELD, array('uvasom_section_type') );
	genesis_add_option_filter( 'no_html', GENESIS_SETTINGS_FIELD, array('uvasom_site_type') );
	genesis_add_option_filter( 'no_html', GENESIS_SETTINGS_FIELD, array('uvasom_tertiaryhome_name') );
	genesis_add_option_filter( 'no_html', GENESIS_SETTINGS_FIELD, array('uvasom_tertiaryhome_url') );
	genesis_add_option_filter( 'no_html', GENESIS_SETTINGS_FIELD, array('uvasom_tertiary_default') );
}
add_action('genesis_theme_settings_metaboxes', 'uvasom_register_settings_meta_box');
/**
 * Register Metabox
 *
 */
function uvasom_register_settings_meta_box() {
	global $_genesis_theme_settings_pagehook;
	add_meta_box('uvasom-settings', 'UVA SOM Site Settings', 'uvasom_settings_meta_box', $_genesis_theme_settings_pagehook, 'main', 'high');
}
/**
 * Create Metabox
 *
 */
function uvasom_settings_meta_box() {
	$uvasom_section_types = array(
				'main' => 'Main SOM-wide Topic',
				'secondary' => 'Secondary Level Topic or Department (default)',
				'tertiary' => 'Tertiary Level Topic or Lab'
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
			<option value="<?php echo $type; ?>" <?php selected($type, genesis_get_option('uvasom_site_type')); ?>><?php _e($label, 'genesis'); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
    <p><strong>Number of Footer Columns:</strong><br />
    By default, there are no widget areas or columns in the footer. <br />
    If you want to display widgets in the footer area, indicate below<br />how many columns of widgets you would like.<br />They will display in equal widths across the page.<br />
		<select name="<?php echo GENESIS_SETTINGS_FIELD; ?>[uvasom_footercolumns_type]">
			<?php foreach ( $uvasom_footercolumns_types as $type => $label ) : ?>
			<option value="<?php echo $type; ?>" <?php selected($type, genesis_get_option('uvasom_footercolumns_type')); ?>><?php _e($label, 'genesis'); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<p><strong>Site Section Type:</strong><br />Keep to default unless instructed:<br />
		<select name="<?php echo GENESIS_SETTINGS_FIELD; ?>[uvasom_section_type]" id="uvasom_section_type">
			<?php foreach ( $uvasom_section_types as $type => $label ) : ?>
			<option value="<?php echo $type; ?>" <?php selected($type, genesis_get_option('uvasom_section_type')); ?>><?php _e($label, 'genesis'); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
    <p class="uvasom_tertiaryoption">
    <label><?php printf( __('Main Site Name: ', 'genesis'), esc_html( $tax->labels->singular_name ) ); ?><input type="text" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[uvasom_tertiaryhome_name]"  id="uvasom_tertiaryhome_name" size="50" value="<?php if((genesis_get_option('uvasom_tertiaryhome_name') === "")){ echo get_site_option('site_name');} else {echo genesis_get_option('uvasom_tertiaryhome_name'); }?>"/></label><br />
    <label><?php printf( __('Main Site Address: ', 'genesis'), esc_html( $tax->labels->singular_name ) ); ?><input type="text" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[uvasom_tertiaryhome_url]" id="uvasom_tertiaryhome_url" size="50" value="<?php if((genesis_get_option('uvasom_tertiaryhome_url') === "")){ echo network_site_url();} else {echo genesis_get_option('uvasom_tertiaryhome_url'); }?>"/></label></p>
<?php
}
/**
 * Adds new display options to taxonomy archives
 * @author Curtiss Grymala
 */
function uvasom_add_taxonomy_archive_options() {
	foreach ( get_taxonomies( array( 'show_ui' => true ) ) as $tax_name) {
		add_action( $tax_name . '_edit_form', 'uvasom_taxonomy_archive_options', 10, 2 );
	}
}
add_action( 'admin_init', 'uvasom_add_taxonomy_archive_options' );
/**
 * Offer new display options for taxonomy archives
 * @author Curtiss Grymala
 */
function uvasom_taxonomy_archive_options( $tag, $taxonomy ) {
	$tax = get_taxonomy( $taxonomy );
?>
	<h3><?php _e('UVA SOM Archive Settings', 'genesis'); ?></h3>
	<table class="form-table"><tbody>

	<tr>
		<th scope="row" valign="top"><label><?php _e('Display Date Information', 'genesis'); ?></label></th>
		<td>
			<label><input name="meta[hide_date]" type="checkbox" value="1" <?php checked(1, $tag->meta['hide_date']); ?> /> <?php printf( __('Hide publish date for each article on archive pages?', 'genesis'), esc_html( $tax->labels->singular_name ) ); ?></label><br />
			<label><input name="meta[hide_date_single]" type="checkbox" value="1" <?php checked(1, $tag->meta['hide_date_single']); ?> /> <?php printf( __('Hide publish date on individual articles?', 'genesis'), esc_html( $tax->labels->singular_name ) ); ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row" valign="top"><label><?php _e( 'Display Author Information', 'genesis' ); ?></label></th>
		<td>
			<label><input name="meta[hide_author]" type="checkbox" value="1" <?php checked(1, $tag->meta['hide_author']); ?> /> <?php printf( __('Hide author name for each article on archive pages?', 'genesis'), esc_html( $tax->labels->singular_name ) ); ?></label><br/>
			<label><input name="meta[hide_author_single]" type="checkbox" value="1" <?php checked(1, $tag->meta['hide_author_single']); ?> /> <?php printf( __('Hide author name on individual articles?', 'genesis'), esc_html( $tax->labels->singular_name ) ); ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row" valign="top"><label><?php _e( 'Display Author Information', 'genesis' ); ?></label></th>
		<td>
			<label><input name="meta[hide_taxonomies]" type="checkbox" value="1" <?php checked(1, $tag->meta['hide_taxonomies']); ?> /> <?php printf( __('Hide taxonomy information for each article on archive pages?', 'genesis'), esc_html( $tax->labels->singular_name ) ); ?></label><br/>
			<label><input name="meta[hide_taxonomies_single]" type="checkbox" value="1" <?php checked(1, $tag->meta['hide_taxonomies_single']); ?> /> <?php printf( __('Hide taxonomy information on individual articles?', 'genesis'), esc_html( $tax->labels->singular_name ) ); ?></label>
		</td>
	</tr>

	</tbody></table>
<?php
}
/**
 * Saves new taxonomy display options
 * @author Curtiss Grymala
 */
function uvasom_term_meta_save( $term_id, $tt_id ) {
	$term_meta = (array) get_option('uvasom-term-meta');
	$term_meta[$term_id] = isset( $_POST['uvasom_meta'] ) ? (array) $_POST['uvasom_meta'] : array();
	update_option('uvasom-term-meta', $term_meta);
}
/*add_action( 'edit_term', 'uvasom_term_meta_save', 10, 2 );*/
/**
 * Delete new taxonomy display options if taxonomy is deleted
 * @author Curtiss Grymala
 */
function uvasom_term_meta_delete( $term_id, $tt_id ) {
	$term_meta = (array) get_option('uvasom-term-meta');
	unset( $term_meta[$term_id] );
	update_option('uvasom-term-meta', (array) $term_meta);
}
/*add_action( 'delete_term', 'uvasom_term_meta_delete', 10, 2 );*/
/**
 * Filters out the unnecessary information from post meta that appears before the post content
 * @author Curtiss Grymala
 */
function uvasom_custom_post_info( $post_info ) {
	global $post;
	if ( ! is_object( $post ) )
		return $post_info;
	$term_meta = (array) get_option( 'genesis-term-meta', array() );
	if ( is_tax() || is_category() || is_tag() ) {
		$cat = $GLOBALS['wp_query']->get_queried_object();
		if ( false === $cat || is_wp_error( $cat ) ) {
			/*print( "\n<!-- The queried object was either false or a wp_error -->\n" );*/
			return $post_info;
		}
		$meta = $term_meta[$cat->term_id];
		if ( is_array( $meta ) && array_key_exists( 'hide_date', $meta ) && 1 == $meta['hide_date'] ) {
			/*print( "\n<!-- This is a tax archive. We should be removing the post date from the display -->\n" );*/
			$post_info = trim( str_replace( '[post_date]', '', $post_info ) );
		}
		if ( is_array( $meta ) && array_key_exists( 'hide_author', $meta ) && 1 == $meta['hide_author'] ) {
			/*print( "\n<!-- This is a tax archive. We should be removing the post author from the display -->\n" );*/
			$post_info = trim( str_replace( __('By', 'genesis') . ' [post_author_posts_link]', '', $post_info ) );
		}
		return $post_info;
	}
	if ( is_archive() || is_home() || is_front_page() ) {
		foreach ( get_taxonomies( array( 'show_ui' => true ) ) as $taxonomy ) {
			$cats = get_the_terms( $post->ID, $taxonomy );
			if ( false === $cats || is_wp_error( $cats ) ) {
				continue;
				/*return $post_info;*/
			}
			foreach ( $cats as $cat ) {
				$meta = $term_meta[$cat->term_id];
				if ( ! is_array( $meta ) )
					continue;
				if ( array_key_exists( 'hide_date', $meta ) && 1 == $meta['hide_date'] ) {
					/*print( "\n<!-- This is an archive page. We should be removing the date from the meta info -->\n" );*/
					$post_info = trim( str_replace( '[post_date]', '', $post_info ) );
				}
				if ( array_key_exists( 'hide_author', $meta ) && 1 == $meta['hide_author'] ) {
					/*print( "\n<!-- This is an archive page. We should be removing the author from the meta info -->\n" );*/
					$post_info = trim( str_replace( __('By', 'genesis') . ' [post_author_posts_link]', '', $post_info ) );
				}
			}
		}
		return $post_info;
	}
	if ( is_single() ) {
		foreach ( get_taxonomies( array( 'show_ui' => true ) ) as $taxonomy ) {
			$cats = get_the_terms( $post->ID, $taxonomy );
			if ( false === $cats || is_wp_error( $cats ) ) {
				continue;
				/*wp_die( 'The list of terms for ' . $taxonomy . ' was either false or a wp_error' );
				return $post_info;*/
			}
			foreach ( $cats as $cat ) {
				$meta = $term_meta[$cat->term_id];
				if ( ! is_array( $meta ) )
					continue;
				if ( array_key_exists( 'hide_date_single', $meta ) && 1 == $meta['hide_date_single'] ) {
					/*print( "\n<!-- This is a single post/page. We should be removing the date from the meta info. -->\n" );*/
					$post_info = trim( str_replace( '[post_date]', '', $post_info ) );
				}
				if ( array_key_exists( 'hide_author_single', $meta ) && 1 == $meta['hide_author_single'] ) {
					/*print( "\n<!-- This is a single post/page. We should be removing the date from the meta info. -->\n" );*/
					$post_info = trim( str_replace( __('By', 'genesis') . ' [post_author_posts_link]', '', $post_info ) );
				}
			}
		}
		return $post_info;
	}
	/*print( "\n<!-- We got this far and did not find any conditionals that were met, so we're returning the default data -->\n" );*/
	return $post_info;
}
add_filter( 'genesis_post_info', 'uvasom_custom_post_info', 1 );
/**
 * Filters out unnecessary meta info from below the post
 * @author Curtiss Grymala
 */
function uvasom_post_meta_display_filter( $post_info ) {
	global $post;
	if ( ! is_object( $post ) )
		return $post_info;
	$term_meta = (array) get_option('genesis-term-meta');
	if ( is_tax() || is_category() || is_tag() ) {
		$cat = $GLOBALS['wp_query']->get_queried_object();
		if ( false === $cat || is_wp_error( $cat ) )
			return $post_info;
		$meta = $term_meta[$cat->term_id];
		if ( is_array( $meta ) && array_key_exists( 'hide_taxonomies', $meta ) && 1 == $meta['hide_taxonomies'] )
			return '';
		return $post_info;
	}
	if ( is_archive() ) {
		foreach ( get_taxonomies( array( 'show_ui' => true ) ) as $taxonomy ) {
			$cats = get_the_terms( $post->ID, $taxonomy );
			if ( false === $cats || is_wp_error( $cats ) )
				return $post_info;
			foreach ( $cats as $cat ) {
				$meta = $term_meta[$cat->term_id];
				if ( ! is_array( $meta ) )
					continue;
				if ( array_key_exists( 'hide_taxonomies', $meta ) && 1 == $meta['hide_taxonomies'] )
					return '';
			}
		}
		return $post_info;
	}
	if ( is_single() ) {
		foreach ( get_taxonomies( array( 'show_ui' => true ) ) as $taxonomy ) {
			$cats = get_the_terms( $post->ID, $taxonomy );
			if ( false === $cats || is_wp_error( $cats ) )
				return $post_info;
			foreach ( $cats as $cat ) {
				$meta = $term_meta[$cat->term_id];
				if ( ! is_array( $meta ) )
					continue;
				if ( array_key_exists( 'hide_taxonomies', $meta ) && 1 == $meta['hide_taxonomies'] )
					return '';
			}
		}
		return $post_info;
	}
}
add_filter( 'genesis_post_meta', 'uvasom_post_meta_display_filter', 1 );

?>