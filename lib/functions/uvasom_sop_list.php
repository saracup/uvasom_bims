<?php 
function uvasom_sop_listing() {
if(uvasom_is_tree( '43' ))
{
$uvasom_sop_cat='set-up-study';
}
if(uvasom_is_tree( '46' ))
{
$uvasom_sop_cat='design-study';
}
if(uvasom_is_tree( '48' ))
{
$uvasom_sop_cat='conduct-study';
}
if(uvasom_is_tree( '50' ))
{
$uvasom_sop_cat='close-out-study';
}
$loop = new WP_Query( array( 'post_type' => 'document', 'posts_per_page' => 50 , 'orderby' => 'title', 'order' => 'ASC', 'sop' => $uvasom_sop_cat ) ); 
	
		while ( $loop->have_posts() ) : $loop->the_post(); 
	
		the_title( '<li><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></li>' ); 
	endwhile; 
}?>
