<?php
/*-------------------------------------------------*/
// Start the engine
/*-------------------------------------------------*/
require_once( get_template_directory() . '/lib/init.php' );

/** Localization */
load_child_theme_textdomain(  'showroom', apply_filters(  'child_theme_textdomain', get_stylesheet_directory(  ) . '/languages', 'showroom'  )  );

/*-------------------------------------------------*/
// Child Theme
/*-------------------------------------------------*/
define( 'CHILD_THEME_NAME', 'Showroom' );
define( 'CHILD_THEME_URL', 'http://demo.zigzagpress.com/showroom' );

/*-------------------------------------------------*/
// Add HTML5 support
/*-------------------------------------------------*/
add_theme_support( 'html5' );

/*-------------------------------------------------*/
// Add HTML5 support
/*-------------------------------------------------*/
add_theme_support( 'genesis-responsive-viewport' );

/*-------------------------------------------------*/
// Structural Wraps
/*-------------------------------------------------*/
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'inner', 'footer-widgets', 'footer' ) );

/** Custom Post Types */
require_once(  get_stylesheet_directory(  ) . '/lib/cpt/super-cpt.php'   );
require_once(  get_stylesheet_directory(  ) . '/lib/cpt/zp_cpt.php'   );

/** Theme Shortcode */
require_once(  get_stylesheet_directory(  ) . '/lib/shortcode/shortcode.php'   );

/** Theme Option/Functions */
require_once (  get_stylesheet_directory(  ) . '/lib/theme_settings.php'   );
require_once (  get_stylesheet_directory(  ) . '/lib/theme_functions.php'   );

//Add widgets
require_once( get_stylesheet_directory()  .'/lib/widgets/widget-flickr.php');
require_once( get_stylesheet_directory()  .'/lib/widgets/widget-social_icons.php');

/*-------------------------------------------------*/
// Reposition Primary Navigation
/*-------------------------------------------------*/
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 11 );

/*-------------------------------------------------*/
// Unregister layout and sidebar
/*-------------------------------------------------*/
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
unregister_sidebar( 'header-right' );
unregister_sidebar( 'sidebar-alt' );

/*-------------------------------------------------*/
// Shortcode Stylesheet
/*-------------------------------------------------*/
add_action('admin_enqueue_scripts', 'zp_codes_admin_init'); 
function zp_codes_admin_init(){
	global $current_screen;

	if($current_screen->base=='post'){
		//enqueue the script and CSS files for the TinyMCE editor formatting buttons

		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-dialog');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-sortable');

		//set the style files
		add_editor_style('/lib/shortcode/formatting-buttons/custom-editor-style.css');
		wp_enqueue_style('page-style',get_stylesheet_directory_uri().'/css/page_style.css');
		wp_enqueue_style('jquery_ui_css',get_stylesheet_directory_uri().'/css/jquery-ui.css');
	}
}

/*-------------------------------------------------*/
// Theme Additional Styles
/*-------------------------------------------------*/
add_action( 'wp_enqueue_scripts', 'zp_print_styles' );
function zp_print_styles() {

	wp_register_style( 'flexslider-css', get_stylesheet_directory_uri().'/css/flexslider.css' );
	wp_enqueue_style( 'flexslider-css' );	

	wp_register_style( 'custom-editor-style-css', get_stylesheet_directory_uri().'/lib/shortcode/formatting-buttons/custom-editor-style.css' );
	wp_enqueue_style( 'custom-editor-style-css' );	

	wp_register_style( 'prettyphoto-css', get_stylesheet_directory_uri().'/css/prettyPhoto.css' );
	wp_enqueue_style( 'prettyphoto-css' );	
	
	wp_register_style( 'font-awesome', get_stylesheet_directory_uri( ).'/css/font-awesome.css' );
	wp_enqueue_style( 'font-awesome'  );
	
	wp_register_style( 'mobile', get_stylesheet_directory_uri( ).'/css/mobile.css' );
	wp_enqueue_style( 'mobile'  );
	
	wp_register_style( 'custom_css', get_stylesheet_directory_uri( ).'/custom.css' );
	wp_enqueue_style( 'custom_css'  );

}

/*-------------------------------------------------*/
// Theme Scripts
/*-------------------------------------------------*/
add_action( 'wp_enqueue_scripts', 'zp_theme_js');
function zp_theme_js() {	
	wp_enqueue_script( 'jquery'  );	
	wp_enqueue_script( 'jquery-ui-tabs' );
	wp_enqueue_script('jquery_easing_js', get_stylesheet_directory_uri() . '/js/jquery-easing.js', '', '', true );
    wp_enqueue_script('jquery_pretty_photo_js', get_stylesheet_directory_uri() . '/js/jquery.prettyPhoto.js',  '', '3.1.6', true );	
	wp_enqueue_script('jquery_isotope_min_js', get_stylesheet_directory_uri().'/js/jquery.isotope.min.js',  '', '', true );
	wp_enqueue_script('jquery.flexslider_js', get_stylesheet_directory_uri().'/js/jquery.flexslider.js',  '', '', true );	
	wp_enqueue_script( 'jQuery_ScrollTo_min_js', get_stylesheet_directory_uri(  ) . '/js/jquery.ScrollTo.min.js', '' , '', true );
	wp_enqueue_script('custom_js', get_stylesheet_directory_uri().'/js/jquery.custom.js');	
}

/*-------------------------------------------------*/
// Custom CSS
/*-------------------------------------------------*/
add_action( 'wp_head', 'zp_custom_styles' );
function zp_custom_styles( ) {
	$css_custom = genesis_get_option( 'zp_css_code', ZP_SETTINGS_FIELD );
	if($css_custom){
		echo '<style type="text/css">'.$css_custom.'</style>';
	}
}

/*-------------------------------------------------*/
// Favicon Support
/*-------------------------------------------------*/
add_filter('genesis_favicon_url', 'zp_favicon_url');
function zp_favicon_url() {
	$favicon_link = genesis_get_option( 'zp_favicon', ZP_SETTINGS_FIELD );
	if ( $favicon_link ) {
		$favicon = $favicon_link;
		return $favicon;
	}
	else 
		return false;
}

/*-------------------------------------------------*/
// Custom Breadrumbs Arguments
/*-------------------------------------------------*/
add_filter( 'genesis_breadcrumb_args', 'zp_breadcrumb_args' );
function zp_breadcrumb_args(  $args  ) {
    $args['sep']                     = ' &raquo; ';
    $args['list_sep']                = ', '; // Genesis 1.5 and later
    $args['display']                 = true;
    $args['labels']['prefix']        = '';
    $args['labels']['author']        = __( 'Archives for ','showroom' );
    $args['labels']['category']      = __( 'Archives for ','showroom' ); // Genesis 1.6 and later
    $args['labels']['tag']           = __( 'Archives for ','showroom' );
    $args['labels']['date']          = __( 'Archives for ','showroom' );
    $args['labels']['search']        = __( 'Search for ','showroom' );
    $args['labels']['tax']           = __( 'Archives for ','showroom' );
    $args['labels']['post_type']     = __( 'Archives for ','showroom' );
    $args['labels']['404']           = __( '404','showroom' ); // Genesis 1.5 and later
    return $args;
}

/*-------------------------------------------------*/
// Home Slider
/*-------------------------------------------------*/
add_action('genesis_after_header', 'header_slider');
function header_slider(){
	if( is_home() ){
		echo '<div class="slider-container">';
		if( genesis_get_option( 'zp_slider_enable' , ZP_SETTINGS_FIELD ) ){
			require( get_stylesheet_directory( ).'/lib/slider/home_slider.php');
		}
		echo '</div>';
	}
}

/*-------------------------------------------------*/
// Custom excerpt link
/*-------------------------------------------------*/
add_filter( 'excerpt_more', 'zp_read_more_link' );
add_filter( 'get_the_content_more_link', 'zp_read_more_link' );
function zp_read_more_link() {
    return '&hellip; <a class="more-link" href="' . get_permalink() . '">'.__( 'Read More','showroom' ).' &raquo;</a>';
}

/*-------------------------------------------------*/
// Add footer widget support
/*-------------------------------------------------*/
add_theme_support( 'genesis-footer-widgets', 3 );

/*-------------------------------------------------*/
// Logo Support
/*-------------------------------------------------*/
add_action( 'wp_head', 'zp_custom_logo' );
function zp_custom_logo() {
	if ( genesis_get_option( 'zp_logo', ZP_SETTINGS_FIELD ) ) { ?>
		<style type="text/css">
			.header-image .site-header .title-area {
				background: url("<?php echo genesis_get_option( 'zp_logo', ZP_SETTINGS_FIELD ); ?>") no-repeat scroll left top transparent;
			}
			.header-image .title-area, .header-image .site-title, .header-image .site-title a{
				height: <?php echo genesis_get_option( 'zp_logo_height', ZP_SETTINGS_FIELD ); ?>px;
				width: <?php echo genesis_get_option( 'zp_logo_width', ZP_SETTINGS_FIELD ); ?>px;	
			}
        </style>
   <?php }
}

/*-------------------------------------------------*/
// Custom Background
/*-------------------------------------------------*/
add_theme_support( 'custom-background', array( 'default-color' => 'FFFFFF' ) );

/*-------------------------------------------------*/
// Custom Footer
/*-------------------------------------------------*/
add_filter('genesis_footer_output', 'zp_footer_output_filter', 10, 3);
function zp_footer_output_filter($output, $creds_text) {
	$copyright = genesis_get_option( 'zp_footer_text', ZP_SETTINGS_FIELD );
	$creds_text_end =  __( 'Copyright', 'showroom' ) . ' [footer_copyright] <a href="'.site_url().'" target="_blank">'.get_bloginfo().'</a> '. __('on', 'showroom') .' [footer_genesis_link] &middot; [footer_wordpress_link] &middot; [footer_loginout]';
	
	if($copyright != ""){
		$output = '<div class="creds">' .$copyright. '</div>';
	}else{
		$output = '<div class="creds">' . $creds_text_end . '</div>';
	}
	return $output;
}

/*-------------------------------------------------*/
// Support shortcode in the widget
/*-------------------------------------------------*/
add_filter('widget_text', 'do_shortcode');

/*-------------------------------------------------*/
// widget Areas
/*-------------------------------------------------*/
genesis_register_sidebar(array(
	'name'=>'Home Top',
	'id' => 'hometop',
	'description' => __( 'This is the Home sidebar of the homepage.','showroom' ),
	'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>',
	'before_title'=>'<h4 class="widgettitle">','after_title'=>'</h4>'
));

genesis_register_sidebar(array(
	'name'=>'Home Middle 1',
	'id' => 'homemiddle-1',
	'description' => __( 'This is the left column of the middle section of the homepage.','showroom' ),
	'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>',
	'before_title'=>'<h4 class="widgettitle">','after_title'=>'</h4>'
));

genesis_register_sidebar(array(
	'name'=>'Home Middle 2',
	'id' => 'homemiddle-2',
	'description' => __( 'This is the right column of the middle section of the homepage.','showroom' ),
	'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>',
	'before_title'=>'<h4 class="widgettitle">','after_title'=>'</h4>'
));

genesis_register_sidebar(array(
	'name'=>'Single Portfolio Sidebar',
	'id' => 'single_portfolio_sidebar',
	'description' => __( 'This is the sidebar for single page portfolio.','showroom' ),
	'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div></div>',
	'before_title'=>'<div class="widget-wrap"><h4 class="widgettitle">','after_title'=>'</h4>'
));

/*-------------------------------------------------*/
// To Top Link
/*-------------------------------------------------*/
add_action( 'genesis_before_footer','zp_add_top_link' );
function zp_add_top_link(  ){
	echo '<a href="#top" id="top-link"> <i class="fa fa-chevron-up"></i></a>';
}

/*-------------------------------------------------------------*/
//					Add Mobile Menu
/*------------------------------------------------------------*/
add_action( 'genesis_header', 'zp_mobile_nav', 10 );
function zp_mobile_nav(){
	$output = '';
	
	$output .=  '<div class="mobile_menu" role="navigation">';
	$output .= '<span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>';
	$output .= '</div>';
	
	echo $output;
}
/*-------------------------------------------------------------*/
//					Add IE Support
/*------------------------------------------------------------*/
add_action( 'wp_head', 'zp_add_IE8_fixes' );

function zp_add_IE8_fixes(){
	echo '<!--[if lt IE 9]>
	<style type="text/css">
	img{
		max-width: none;	
	}
	
	#slider .slides > li{
		background-size: 100%;	
	}
	
	.ie_last_child{
		margin-right: 0 !important;
	}
	
	.hometop_last_child{
		
	}
	.hometop_last_child{
		margin-right: 0;
	}
	
	.home_middle_last_child{
		margin-right: 4%;
	}
	</style>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery(".home-top .featuredpage:last-child").addClass("ie_last_child");
			jQuery(".home-top .featuredpage:last-child").addClass("hometop_last_child");
			jQuery(".home-middle-1 .featured-content .entry:nth-of-type(2n+1)").addClass("home_middle_last_child");
		});
	</script>
	<![endif]-->'."\n";	
}

// Add My Custom Functions File
include_once( get_stylesheet_directory() . '/lib/custom_functions.php' );
