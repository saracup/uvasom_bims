<?php

/*

 WARNING: This file is part of the core Genesis framework. DO NOT edit

 this file under any circumstances. Please do all modifications

 in the form of a child theme.

 */



/**

 * This file handles posts, but only exists for the sake of

 * child theme forward compatibility.

 *

 * This file is a core Genesis file and should not be edited.

 *

 * @category Genesis

 * @package  Templates

 * @author   StudioPress

 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)

 * @link     http://www.studiopress.com/themes/genesis

 */

add_action ('genesis_post_content','uvasom_featured_post_image', 1 );
function uvasom_featured_post_image() {
  if ( ! is_singular( 'post' ) )  return;
	the_post_thumbnail('thumbnail');
}
genesis();

