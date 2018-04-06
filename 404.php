<?php

/**
 * Handles display of 404 page.
/** Remove default loop **/
remove_action('genesis_before_loop', 'genesis_do_breadcrumbs');
//Relocate the post or page title
function uvasom_404_do_post_title()
{
	echo '<div class="clearfix"></div>';
	echo '<div id="uvasom_page_title">';
	genesis_do_breadcrumbs();
	echo '<h1 class="entry-title">Not Found, Error 404</h1>';
	echo '</div>';
}
add_action('genesis_after_header', 'uvasom_404_do_post_title');

remove_action( 'genesis_loop', 'genesis_do_loop' );

add_action( 'genesis_loop', 'genesis_404' );
/**
 * This function outputs a 404 "Not Found" error message
 *
 * @since 1.6
 */
function genesis_404() { ?>


	<div class="post hentry">
		<div class="entry-content">
			<p><?php printf( __( 'The page you are looking for no longer exists. Perhaps you can return back to the site\'s <a href="%s">homepage</a> and see if you can find what you are looking for. Or, you may try another search.', 'genesis' ), home_url() ); ?></p>

			

		</div><!-- end .entry-content -->

	</div><!-- end .postclass -->

<?php
}

genesis();
