<?php
/**
 * This file contains all the shortcodes and TinyMCE formatting buttons functionality.
 */
 
	/**
	*	Tab Shortcode
	*/
	function zp_show_tabs( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'ids' => '',
			'titles' => '',
		 ), $atts ) );
		$output = '';
		$ids = str_replace( " ", "", $ids ); 
	
		$titlearr = explode( ',',$titles );
		$ids = explode( ',',$ids );
		$output='<div class="tabs-container"><ul class="tabs ">';
		
		for( $i=0; $i < count( $titlearr ); $i++ ){
			$output.='<li class="w3"><a href="#'.$ids[$i].'">'.$titlearr[$i].'</a></li>';
		}
	
		
		$output.='</ul><div class="panes">'.do_shortcode( $content ).'</div></div>';
		
		//removing extra <br>
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$output = str_replace( $Old, $New, $output );
		
		return $output;
		
	}
	
	add_shortcode( 'tabs', 'zp_show_tabs' );
	
	function zp_show_pane( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'id' => '',
		 ), $atts ) );
		 
		return '<div id="'.$id.'">'.do_shortcode( $content ).'</div>';
	}
	
	add_shortcode( 'pane', 'zp_show_pane' );


	/* Toggle Shortcode*/
	
	function zp_toggle_function( $atts, $content = null ){
		extract( shortcode_atts( array(
			"title"=> ''
		), $atts));
		
		$str = '';
		$str .= '<div class="toggle-unit clearfix">';
		
		if( $title ) {
		$str .= '<h4>' . $title . '</h4>';
		}
		
		$str .= do_shortcode( $content ) ;
		$str .= '</div>';
		
		return $str;
	}
	add_shortcode( 'toggle', 'zp_toggle_function' );

// Toggle Item Shortcode
	function zp_toggleitem_function( $atts, $content = null ){
		extract( shortcode_atts( array(
			"title"=> ''
		), $atts));
		
		$str = '<div class="toggle-wrap">';
		$str .= '<span class="trigger"><a href="#">' . $title . '</a></span>';
		$str .= '<div class="toggle-container">';
		$str .= do_shortcode ( $content ) ;
		$str .= '</div></div>';
		
		return $str;
	}
	
	add_shortcode( 'toggleitem', 'zp_toggleitem_function' );
	
	
	// Accordion Shortcode
	
	function zp_accordion_function( $atts, $content = null ){
		
		extract( shortcode_atts( array(
			"title"=> ''
		), $atts));
		
		$str = '<div class="accordion-unit clearfix">';
		
		if ( $title ) {
			$str .= '<h4>' . $title . '</h4>';	
		}
		
		$str .= do_shortcode ( $content );
		$str .= '</div>';
		
		return $str;
		
	}
	
	add_shortcode( 'accordion', 'zp_accordion_function' );
	
	// Accordion Item Shortcode
	function zp_accordionitem_function( $atts, $content = null ){
		extract( shortcode_atts( array(
			"title"=> ''
		), $atts));
		
		$str = '<span class="trigger-button"><span>' . $title . '</span></span>';
		$str .= '<div class="accordion">';
		$str .= do_shortcode ( $content ) ;
		$str .= '</div>';
		
		return $str;
	}
	
	add_shortcode( 'accordionitem', 'zp_accordionitem_function' );
	
	// Special Services Box Shortcode
	
	function zp_servicebox_function( $atts, $content = null ){
		
		
	extract( shortcode_atts( array(
		"size" => '',
		"last"=> '',
		"title"=> '',
		"icon" => '',
		"link" => '',
		"linkname" => '',
		"target" => ''
	), $atts));
	
		if( $last == 'true') {
		$last_str = " last-column";
		}
		else {
			$last_str="";
		}
		
		//check if the icon is an image of not
		if( $icon == '' ){
			$image = '';
		}else if( strpos($icon, "http") !== false ){
			$image = '<div class="service_icon_image"><img src="'.$icon.'" width="40" height="40" alt="" /></div>';
		}else{
			$image = '<div class="service_icon_font"><i class="fa '.$icon.'"></i></div>';
		}
		
		if( $link ){
			$button_link = '<div><a class="button" href="'.$link.'" target="'.$target.'" >'.$linkname.'</a></div>';	
		}else{
			$button_link = '';	
		}
		
		$str ='';
		$str .= '<div class="'.$size.' special-services-box'. $last_str .'">';
		$str .= '<div class="box-wrapper">';
		$str .= $image;
		$str .= '<h4>'. $title . '</h4><p>'. $content . '</p>'.$button_link.'</div></div>';
		
		return $str;
	}
	
	add_shortcode( 'servicebox', 'zp_servicebox_function' );
	
// Buttons Shortcode
	function zp_buttons_shortcode( $atts, $content = null ) {

	extract( shortcode_atts( array(
		"size" => '',
		"color" => '',
		"link" => '',
		"rounded" => ''
	), $atts));
	
	$output = '';
	if ( $size == 'small' ) {
		$size = 'small-btn ';
	}
	elseif ( $size == 'normal' ) {
		$size = '';
	}
	elseif( $size == 'large' ) {
		$size = 'large-btn ';
	}
	else {
		$size = '';
	}
	if ( $rounded == 'true' ){
		$rounded = 'rounded ';
	}
	
	$output .= '<a href="'. $link . '" class=" button ' .$rounded .' '. $size . $color . '-btn" >' . do_shortcode ( $content ) . '</a>';
	return $output;
	
	}

	add_shortcode( 'button', 'zp_buttons_shortcode' );

 /*price table shortcode*/	
	function pricetable_function( $atts, $content = null ){
	extract( shortcode_atts( array(
		"size" => '',
		"last"=> '',
		"terms" => '',
		"price"=> '',
		"title" => '',
		"linkname"=> '',
		"linkurl"=> '',
		"bestprice"=>''
	), $atts));
	
		if( $last == 'true') {
		$last_str = " last-column";
		}
		else {
			$last_str="";
		}
		if( $bestprice == 'true') {
			$bp = " bestprice";
		}
		else {
			$bp="price";
		}
		
		$str ='';
		$str .= '<div class="'.$size.' pricing'. $last_str .' '.$bp.'">';
		$str .= '<div class="box-wrapper">';
		$str .= '<h3>'. $title . '</h3>';
		$str .= '<h2>'.$price.'</h2>';
		$str .= '<span class="price_terms">'.$terms.'</span>';
		$str .= $content.'<div><a class="button" href="'.$linkurl.'" target="_blank">'.$linkname.'</a></div>';
		$str .= '</div></div>';
		
		return $str;
	}
	
	add_shortcode( 'pricetable', 'pricetable_function' );
	
	
/*
divider
*/
add_shortcode( 'hr', 'shortcode_hr' );
function shortcode_hr($atts, $content = null) {
   return '<div class="shortcode-hr"></div>';
}

/* Code */
function show_code($atts, $content = null) {
	return '<div class="zp_code">'.$content.'</div>';
}
add_shortcode('code', 'show_code');

/* Drop Caps */
function zp_dropcaps($atts, $content = null) {
	return '<span class="drop-caps">'.$content.'</span>';
}
add_shortcode('dropcap', 'zp_dropcaps');

/* List Styles */
function zp_list($atts, $content = null) {
	extract( shortcode_atts( array(
		"style" => ''
	), $atts));
	
	return '<ul class="'.$style.'">'.do_shortcode( $content ).'</ul>';	
}
add_shortcode('list', 'zp_list');

function zp_list_li( $atts, $content = null ) {
	return '<li>'. $content.'</li>';
}
add_shortcode( 'li', 'zp_list_li');


/* image frame */
function zp_image_frame( $atts, $content = null ) {
	extract( shortcode_atts( array(
		"url" => '',
		"align" => ''
	), $atts));
	
	if( $align == 'left' ){
		$align = 'alignleft';	
	}elseif( $align == 'right' ){
		$align = 'alignright';	
	}else{
		$align = 'alignnone';	
	}
	
	return '<img class="img-frame '.$align.'"  src="'.$url.'" />';
}
add_shortcode( 'image_frame', 'zp_image_frame');

/* image lightbox */
function zp_image_lightbox( $atts, $content = null ) {
	extract( shortcode_atts( array(
		"thumbnail_url" => '',
		"full_url" => '',
		"title" => '',
		"align" => ''
	), $atts));
	
	if( $align == 'left' ){
		$align = 'alignleft';	
	}elseif( $align == 'right' ){
		$align = 'alignright';	
	}else{
		$align = 'alignnone';	
	}
	
	if( $thumbnail_url ){
		$thumbnail = $thumbnail_url;	
	}else{
		$thumbnail = $full_url;	
	}
	
	return '<a rel="prettyPhoto[pp_gal]" href="'.$full_url.'" title="'.$title.'"><img class="img-frame '.$align.'" src="'.$thumbnail.'" /></a>';
}
add_shortcode( 'image_lightbox', 'zp_image_lightbox');

/* infoboxes */
function zp_infoboxes( $atts, $content = null ) {
	extract( shortcode_atts( array(
		"style" => ''
	), $atts));
	
	return '<div class="'.$style.'"><p>'.$content.'</p></div>';
	
}
add_shortcode( 'infobox', 'zp_infoboxes');

/* Column Wrapper */
function zp_column_wrapper( $atts, $content = null ) {
	return '<div class="columns-wrapper">'.do_shortcode( $content ).'</div>';
}
add_shortcode( 'column_wrapper', 'zp_column_wrapper' );

/* Columns  */
function zp_column( $atts, $content = null ) {
	extract( shortcode_atts( array(
		"column" => '',
		"last" => ''
	), $atts));

	$lastclass = ( $last == 'true' )? 'nomargin' : '';
	
	if( $column == 2 ){
		$col = 'two';	
	}elseif( $column == 3 ){
		$col = 'three';	
	}else{
		$col = 'four';	
	}

	return '<div class="'.$col.'-columns '.$lastclass.'">'.do_shortcode( $content ).'</div>';
}
add_shortcode( 'col', 'zp_column');




/* ------------------------------------------------------------------------*
 * ADD CUSTOM FORMATTING BUTTONS
 * ------------------------------------------------------------------------*/

global $shortcode_button;
$shortcode_button=array("dropcaps","list", "|","listcheck","liststar","listarrow","listarrow2","listarrow4","listdot","listpencil", "|", 
"frame", "lightbox", "|", "button", "infoboxes", "|", "twocolumns", "threecolumns", "fourcolumns", "|", "pricingtable","toggle","tabs", "accordion", "servicebox");

function add_buttons() {
	if ( get_user_option('rich_editing') == 'true') {
		add_filter('mce_external_plugins', 'add_btn_tinymce_plugin');
		add_filter('mce_buttons_3', 'register_buttons');
	}
}

add_action('init', 'add_buttons');


/**
 * Register the buttons
 * @param $buttons
 */
function register_buttons($buttons) {
	global $shortcode_button;

	array_push($buttons, implode(',',$shortcode_button));
	return $buttons;
}

/**
 * Add the buttons
 * @param $plugin_array
 */
function add_btn_tinymce_plugin($plugin_array) {
	global $shortcode_button;
	foreach($shortcode_button as $btn){
		$plugin_array[$btn] = get_stylesheet_directory_uri().'/lib/shortcode/formatting-buttons/editor-plugin.js';
	}
	return $plugin_array;
}
