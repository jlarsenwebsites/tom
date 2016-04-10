<?php 
/*
* Portfolio Archive Template
*/

/** Force the full width layout layout on the Portfolio page */

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// add archive title
add_filter( 'genesis_post_title_text', 'zp_portfolio_archive_title' );
function zp_portfolio_archive_title( $title ){
	$title = post_type_archive_title( '',false );
	return $title;
}

remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action(  'genesis_before_loop', 'genesis_do_breadcrumbs'  );
remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );

remove_action(	'genesis_loop', 'genesis_do_loop' );
add_action(	'genesis_loop', 'zp_portfolio_archive_template' );
function zp_portfolio_archive_template() { 	
	global $post;

			printf( '<article %s>', genesis_attr( 'entry' ) );

				do_action( 'genesis_entry_header' );

				do_action( 'genesis_before_entry_content' );
				printf( '<div %s>', genesis_attr( 'entry-content' ) );
				
				//get items
				zp_portfolio_template( 3, -1, 'portfolio', false , true );
					
				echo '</div>'; //* end .entry-content
				do_action( 'genesis_after_entry_content' );

				do_action( 'genesis_entry_footer' );

			echo '</article>';

			do_action( 'genesis_after_entry' );

		do_action( 'genesis_after_endwhile' );
}

genesis();