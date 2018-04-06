<?php
//CONDITIONAL DISPLAY FOR TERTIARY/LAB TYPES
function uvasom_base_site() {
echo get_site_url();
}
if ($sec_type == 'tertiary') {

add_action('genesis_header','uvasom_base_site',1);
}
?>