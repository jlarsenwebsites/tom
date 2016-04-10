<?php
 
/**
 * My Custom Functions
*/

function posts_columns_id($defaults){
    $defaults['wps_post_id'] = __('ID');
    return $defaults;
}
function posts_custom_id_columns($column_name, $id){
        if($column_name === 'wps_post_id'){
                echo $id;
    }
}
 
function wh_column( $cols ) {
        $cols["dimensions"] = "Dimensions (w, h)";
        return $cols;
}
function wh_value( $column_name, $id ) {
    $meta = wp_get_attachment_metadata($id);
           if(isset($meta['width']))
           echo $meta['width'].' x '.$meta['height'];
}
add_filter( 'manage_media_columns', 'wh_column' );
add_action( 'manage_media_custom_column', 'wh_value', 10, 2 );

function muc_column( $cols ) {
        $cols["media_url"] = "URL";
        return $cols;
}
function muc_value( $column_name, $id ) {
        if ( $column_name == "media_url" ) echo '<input type="text" width="100%" onclick="jQuery(this).select();" value="'. wp_get_attachment_url( $id ). '" />';
}
add_filter( 'manage_media_columns', 'muc_column' );
add_action( 'manage_media_custom_column', 'muc_value', 10, 2 );

//* Display featured image above content on Posts
add_action ( 'genesis_entry_content', 'sk_show_featured_image_single', 9 );
function sk_show_featured_image_single() {

	if ( is_singular('post') && has_post_thumbnail() ) {
		echo '<div class="single-thumbnail">';
			genesis_image( array( 'size' => 'single-thumbnail' ) );
		echo '</div>';
	}

}

function _remove_script_version( $src ){
    $parts = explode( '?ver', $src );
        return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );