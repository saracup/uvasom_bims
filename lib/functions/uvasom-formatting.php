<?php

/**
 * Add page slug to wp_list_pages items
 */
function uvasom_menu_css_class( $css_class, $page ){
    $css_class[] = 'page-slug-' . $page->post_name;
    return $css_class;
}
add_filter( 'page_css_class', 'uvasom_menu_css_class', 10, 2 );

/**
 * Add "first" and "last" CSS classes to dynamic sidebar widgets. Also adds numeric index class for each widget (widget-1, widget-2, etc.)
 */
function uvasom_widget_first_last_classes($params) {
	global $my_widget_num;
	$this_id = $params[0]['id'];
	$arr_registered_widgets = wp_get_sidebars_widgets();	
	if( !$my_widget_num ) {
		$my_widget_num = array();
	}
	if( !isset( $arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id] ) ) {
		return $params;
	}
	if( isset( $my_widget_num[$this_id] ) ) {
		$my_widget_num[$this_id] ++;
	} else {
		$my_widget_num[$this_id] = 1;
	}
	$class = 'class="widget-' . $my_widget_num[$this_id] . ' ';

	if( $my_widget_num[$this_id] == 1 ) { // If this is the first widget
		$class .= 'widget-first ';
	} elseif( $my_widget_num[$this_id] == count( $arr_registered_widgets[$this_id] ) ) { // If this is the last widget
		$class .= 'widget-last ';
	}
	$params[0]['before_widget'] = preg_replace( '/class=\"/', "$class", $params[0]['before_widget'], 1 );
	return $params;
}
add_filter( 'dynamic_sidebar_params','uvasom_widget_first_last_classes' );
?>