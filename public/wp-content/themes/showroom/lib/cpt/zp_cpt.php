<?php 

// ZP Custom Post Types Initialization

function zp_custom_post_type() {
	if ( ! class_exists( 'Super_CPT' ) )
	
	return;
	
/*----------------------------------------------------*/
// Add Slide Custom Post Type
/*---------------------------------------------------*/

	$slide_custom_default = array(
		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt'),
		'menu_icon' => get_stylesheet_directory_uri().'/lib/cpt/images/slide.png',
	);
	
	// register slide post type
	
	$slide = new Super_Custom_Post_Type( 'slide', 'Slide', 'Slides',  $slide_custom_default );
	$slideshow = new Super_Custom_Taxonomy( 'slideshow' ,'Slideshow', 'Slideshows', 'cat' );
	connect_types_and_taxes( $slide, array( $slideshow ) );
	
	// Slide meta boxes
	$slide->add_meta_box( array(
		'id' => 'slider-settings',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			'slider_button_label' => array( 'label' => __( 'Slide Button','showroom' ), 'type' => 'text' , 'data-zp_desc' => __( 'Button label','showroom') ),
			'slider_link_value' => array( 'label' => __( 'Button Link','showroom' ), 'type' => 'text' , 'data-zp_desc' => __( 'Put button link','showroom') ),
		)
	) );
	
	
	$slide->add_meta_box( array(
		'id' => 'slide-order',
		'context' => 'side',
		'fields' => array(
			'slide-number' => array( 'type' => 'text', 'data-zp_desc' => __( 'Define slide order. Ex. 1,2,3,4,...','showroom') ),
		)
	) );
	
	// manage slide columns
	
	function zp_add_slide_columns($columns) {
		return array(
			'cb' => '<input type="checkbox" />',
			'title' => __('Title', 'showroom'),
			'slideshow' => __('Slideshow', 'showroom'),
			'slide_order' =>__( 'Slide Order', 'showroom'),
			'date' => __('Date', 'showroom'),
		);
	}
	
	add_filter('manage_slide_posts_columns' , 'zp_add_slide_columns');
	
	function zp_custom_slide_columns( $column, $post_id ) {
		switch ( $column ) {
			case 'slideshow' :
				$terms = get_the_term_list( $post_id , 'slideshow' , '' , ',' , '' );
				if ( is_string( $terms ) )
					echo $terms;
				else
					_e( 'Unable to get slideshows(s)', 'showroom' );
					break;
			case 'slide_order' :
				echo get_post_meta( $post_id , 'slide-number' , true );
				break;
		}
	}
	
	add_action( 'manage_posts_custom_column' , 'zp_custom_slide_columns', 10, 2 );
	
/*----------------------------------------------------*/
// Add Portfolio Custom Post Type
/*---------------------------------------------------*/
	$portfolio_custom_default = array(
		'supports' => array( 'title', 'editor', 'thumbnail', 'revisions', 'excerpt' ),
		'menu_icon' => get_stylesheet_directory_uri().'/lib/cpt/images/portfolio.png',
	);
	
	// register slide post type
	
	$portfolio = new Super_Custom_Post_Type( 'portfolio', 'Portfolio', 'Portfolio',  $portfolio_custom_default );
	$portfolio_category = new Super_Custom_Taxonomy( 'portfolio_category' ,'Portfolio Category', 'Portfolio Categories', 'cat' );
	connect_types_and_taxes( $portfolio, array( $portfolio_category ) );
	
	// Portfolio meta boxes
	$portfolio->add_meta_box( array(
		'id' => 'portfolio-description',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			'portfolio_desc' => array( 'label' => __( 'Short Portfolio Description','showroom'), 'type' => 'textarea','data-zp_desc' => __( 'Add short portfolio description. This will appear on homepage latest project and portfolio filter page.','showroom') ),
		)
	) );
	
	$portfolio->add_meta_box( array(
		'id' => 'portfolio-images',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			'portfolio_images' => array( 'label' => __( 'Upload/Attach an image to this portfolio item. Images attached in here will be shown in the single portfolio page as a slider','showroom'), 'type' => 'multiple_media' , 'data-zp_desc' => __( 'Attach images to this portfolio item','showroom' )),
		)
	) );
	
	// manage portfolio columns
	function zp_add_portfolio_columns($columns) {
		return array(
			'cb' => '<input type="checkbox" />',
			'title' => __('Title', 'showroom'),
			'portfolio_category' => __('Portfolio Category(s)', 'showroom'),
			'date' => __('Date', 'showroom'),
		);
	}
	
	add_filter('manage_portfolio_posts_columns' , 'zp_add_portfolio_columns');
	
	function zp_custom_portfolio_columns( $column, $post_id ) {
		switch ( $column ) {
			case 'portfolio_category' :
				$terms = get_the_term_list( $post_id , 'portfolio_category' , '' , ',' , '' );
				if ( is_string( $terms ) )
					echo $terms;
				else
					_e( 'Unable to get portfolio category(s)', 'showroom' );
					break;
		}
	}
	
	add_action( 'manage_posts_custom_column' , 'zp_custom_portfolio_columns', 10, 2 );
		
}

add_action( 'after_setup_theme', 'zp_custom_post_type' );