<?php 
/* 
Template Name: Portfolio Gallery
*/ 

remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );
remove_action(	'genesis_loop', 'genesis_do_loop' );
add_action(	'genesis_loop', 'zp_portfolio_gallery_template' );
function zp_portfolio_gallery_template() {
	global $post;
	
	if ( have_posts() ) : while ( have_posts() ) : the_post();

			do_action( 'genesis_before_entry' );

			printf( '<article %s>', genesis_attr( 'entry' ) );

				do_action( 'genesis_entry_header' );

				do_action( 'genesis_before_entry_content' );
				printf( '<div %s>', genesis_attr( 'entry-content' ) );
				
				//get items
				$items = genesis_get_option( 'zp_num_portfolio_items' , ZP_SETTINGS_FIELD );
					
				zp_portfolio_template( 3, $items, 'gallery', true , true );
					
				echo '</div>'; //* end .entry-content
				do_action( 'genesis_after_entry_content' );

				do_action( 'genesis_entry_footer' );

			echo '</article>';

			do_action( 'genesis_after_entry' );

		endwhile; //* end of one post
		do_action( 'genesis_after_endwhile' );
	endif; //* end loop
}

genesis();