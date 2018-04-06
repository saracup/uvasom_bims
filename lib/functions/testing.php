<?php 
global $pid;
$uvasom_pid_sop = array('43'=>'set-up-study','46'=>'design-study','48'=>'conduct-study','50'=>'close-out-study');
if(uvasom_is_tree( '43' ))
{
?>
<div id="sop_tab">
<h2>SOPs</h2>
<ul>
<?php $loop = new WP_Query( array( 'post_type' => 'document', 'posts_per_page' => 50 , 'orderby' => 'title', 'order' => 'ASC', 'sop' => 'set-up-study' ) ); ?>

<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

    <?php the_title( '<li><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></li>' ); ?>
<?php endwhile; ?>
</ul>
</div>
<?php
}
?>