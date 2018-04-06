<?php
function uvasombims_post_admin_menu_labels() {
    global $menu;
    $menu["58.996"][0] = 'UVA SOM Settings';
    $menu["58.996"][6] = get_stylesheet_directory_uri(). '/images/rotunda2x.png';
}
add_action( 'admin_menu', 'uvasombims_post_admin_menu_labels' );
?>