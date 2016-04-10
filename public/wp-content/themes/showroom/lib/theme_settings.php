<?php
/* Define constants
------------------------------------------------------------ */

define( 'ZP_SETTINGS_FIELD', 'zp-settings' );

/* Setup default options
------------------------------------------------------------ */
/**
 * zpsettings_default_theme_options function.
 *
*/
function zpsettings_default_theme_options() {
	$options = array(
		'zp_enable_carousel' => 1,
		'zp_home_carousel_title' => __( 'Latest Projects', 'showroom' ),
		'zp_home_carousel_desc' => '',
		'zp_home_carousel_items' => 3,
		'zp_home_carousel_category' => '',
		'zp_home_carousel_button' => __( 'View All', 'showroom'),
		'zp_home_carousel_button_link' => '',
		'zp_css_code' => '',
		'zp_portfolio_archive_columns' => '4',
		'zp_related_portfolio_columns' => 3,
		
		'zp_slider_enable' 	=> 1,
		'zp_archive_filter' => 1,
		'zp_slider_caption' => 1,
		'zp_home_slideshow' => '',
		'zp_slider_speed' => 7000,
		'zp_animation_duration' => 7000,
		'zp_num_portfolio_items' => 8,
		'zp_num_archive_items' => '8',
		'zp_logo' => '',
		'zp_logo_height' => 64,
		'zp_logo_width' => 180,
		'zp_related_portfolio' => 1,
		'zp_related_portfolio_title' => __( 'Related Portfolio','showroom' ),
		'zp_num_portfolio_items' => '-1',
		'zp_num_archive_items' => '-1',
		'zp_footer_text' 	=> ''
	);
	return apply_filters( 'zpsettings_default_theme_options', $options );
}

/* Sanitize any inputs
------------------------------------------------------------ */
add_action( 'genesis_settings_sanitizer_init', 'zpsettings_sanitize_inputs' );

/**
 * zpsettings_sanitize_inputs function.
 *
 */ 
function zpsettings_sanitize_inputs() {
    genesis_add_option_filter( 'one_zero', 
				ZP_SETTINGS_FIELD, 
				array( 					
					'zp_slider_enable',
					'zp_home_carousel_filter',
					'zp_home_carousel',
					'zp_welcome_enable',
					'zp_boxed_layout',
					'zp_top_section',
					'zp_archive_filter'
				)
			);
	
    genesis_add_option_filter( 'no_html', 
				ZP_SETTINGS_FIELD, 
				array( 
					'zp_home_carousel_title',
					'zp_latest_blog_title',
					'zp_home_carousel_title',
					'zp_slider_height',
					'zp_slider_speed',
					'zp_animation_duration',
					'zp_num_portfolio_items',
					'zp_logo_height',
					'zp_logo_height',
					'zp_logo',
					'zp_home_carousel_button_link',
					'zp_home_carousel_button'
			 ) 
	);	
	 genesis_add_option_filter( 'requires_unfiltered_html', 
					ZP_SETTINGS_FIELD, 
					array( 
						'zp_welcome_message',
						'zp_footer_text',
						'zp_logo_upload',
						'zp_home_carousel_desc'					
					) 
		);		
}

/* Register our settings and add the options to the database
------------------------------------------------------------ */
add_action( 'admin_init', 'zpsettings_register_settings' );

/**
 * zpsettings_register_settings function.
 *
 */
function zpsettings_register_settings() {
	register_setting( ZP_SETTINGS_FIELD, ZP_SETTINGS_FIELD );
	add_option( ZP_SETTINGS_FIELD, zpsettings_default_theme_options() );
	
	if ( genesis_get_option( 'reset', ZP_SETTINGS_FIELD ) ) {
		update_option( ZP_SETTINGS_FIELD, zpsettings_default_theme_options() );
		genesis_admin_redirect( ZP_SETTINGS_FIELD, array( 'reset' => 'true' ) );
		exit;
	}
}
/* Admin notices for when options are saved/reset
------------------------------------------------------------ */
add_action( 'admin_notices', 'zpsettings_theme_settings_notice' );

/**
 * zpsettings_theme_settings_notice function.
 */
function zpsettings_theme_settings_notice() {
	if ( ! isset( $_REQUEST['page'] ) || $_REQUEST['page'] != ZP_SETTINGS_FIELD )
		return;
	if ( isset( $_REQUEST['reset'] ) && 'true' == $_REQUEST['reset'] )
		echo '<div id="message" class="updated"><p><strong>' . __( 'Settings reset.', 'showroom' ) . '</strong></p></div>';
	elseif ( isset( $_REQUEST['settings-updated'] ) && 'true' == $_REQUEST['settings-updated'] )
		echo '<div id="message" class="updated"><p><strong>' . __( 'Settings saved.', 'showroom' ) . '</strong></p></div>';
}

/* Register our theme options page
------------------------------------------------------------ */

add_action( 'admin_menu', 'zpsettings_theme_options' );
/**
 * zpsettings_theme_options function.
 *
 */
function zpsettings_theme_options() {
	global $_zpsettings_settings_pagehook;
	$_zpsettings_settings_pagehook = add_submenu_page( 'genesis', 'Showroom Settings', 'Showroom Settings', 'edit_theme_options', ZP_SETTINGS_FIELD, 'zpsettings_theme_options_page' );
	//add_action( 'load-'.$_zpsettings_settings_pagehook, 'zpsettings_settings_styles' );
	add_action( 'load-'.$_zpsettings_settings_pagehook, 'zpsettings_settings_scripts' );
	add_action( 'load-'.$_zpsettings_settings_pagehook, 'zpsettings_settings_boxes' );
}

/* Setup our scripts
------------------------------------------------------------ */

/**
 * zpsettings_settings_scripts function.
 * This function enqueues the scripts needed for the CT Settings settings page.
 */
function zpsettings_settings_scripts() {	
	global $_zpsettings_settings_pagehook;
	
	if( is_admin() ){

	wp_register_script( 'zp_image_upload', get_stylesheet_directory_uri() .'/lib/upload/image-upload.js', array('jquery','media-upload','thickbox') );
	wp_enqueue_script('jquery');
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');
	wp_enqueue_script( 'common' );
	wp_enqueue_script( 'wp-lists' );
	wp_enqueue_script( 'postbox' );
	
	wp_enqueue_media();
	wp_enqueue_script('zp_image_upload');
}
}

/* Setup our metaboxes
------------------------------------------------------------ */
/**
 * zpsettings_settings_boxes function.
 *
 * This function sets up the metaboxes to be populated by their respective callback functions.
 *
 */
function zpsettings_settings_boxes() {
	global $_zpsettings_settings_pagehook;
	add_meta_box( 'zpsettings_home_carousel', __( 'Home Carousel Settings', 'showroom' ), 'zpsettings_home_carousel', $_zpsettings_settings_pagehook, 'main', 'high' );
	add_meta_box( 'zpsettings_slideshow_settings', __( 'Slideshow Settings', 'showroom' ), 'zpsettings_slideshow_settings', $_zpsettings_settings_pagehook, 'main','high' );
	add_meta_box( 'zpsettings_appearance_settings', __( 'Appearance Settings', 'showroom' ), 'zpsettings_appearance_settings', $_zpsettings_settings_pagehook, 'main' ,'high');
	add_meta_box( 'zpsettings_portfolio', __( 'Portfolio Settings ', 'showroom' ), 'zpsettings_portfolio', $_zpsettings_settings_pagehook, 'main','high' );
	add_meta_box( 'zpsettings_footer_settings', __( 'Footer Settings', 'showroom' ), 'zpsettings_footer_settings', $_zpsettings_settings_pagehook, 'main','high' );
}

/* Add our custom post metabox for social sharing
------------------------------------------------------------ */
/**
 * zpsettings_home_settings function.
 *
 * Callback function for the ZP Settings Social Sharing metabox.
 *
 */
 
function zpsettings_home_carousel() { ?>
<p>	<input type="checkbox" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_enable_carousel]" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_enable_carousel]" value="1" <?php checked( 1, genesis_get_option( 'zp_enable_carousel', ZP_SETTINGS_FIELD ) ); ?> /> <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_carousel]"><?php _e( 'Check to enable carousel on the home page.', 'showroom' ); ?></label>
</p>
 <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_carousel_title]"><?php _e( 'Home Carousel Title', 'showroom' ) ?></label>
	<input type="text" size="30" value="<?php echo genesis_get_option( 'zp_home_carousel_title', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_carousel_title]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_carousel_title]"></p>
 <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_carousel_desc]"><?php _e( 'Home Carousel Description.', 'showroom' ); ?><br>
	<textarea class="widefat" rows="5" cols="78" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_carousel_desc]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_carousel_desc]"><?php echo genesis_get_option( 'zp_home_carousel_desc', ZP_SETTINGS_FIELD ); ?></textarea>
	</label>
	</p>    
 <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_carousel_items]"><?php _e( 'Number of Items', 'showroom' ) ?></label>
	<input type="text" size="30" value="<?php echo genesis_get_option( 'zp_home_carousel_items', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_carousel_items]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_carousel_items]"></p>
	<p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_carousel_category]"><?php _e( 'Select Home Carousel Category', 'showroom' ); ?></label>
        <select name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_carousel_category]" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_carousel_category]">
        	<option value="" ><?php _e( 'All','showroom' )?></option>
            <?php
				$portfolio_category = get_terms('portfolio_category');
				foreach ($portfolio_category as $of_cat) {
                    ?><option value="<?php echo $of_cat->slug; ?>" <?php selected( genesis_get_option( 'zp_home_carousel_category', ZP_SETTINGS_FIELD ), $of_cat->slug ); ?> > <?php echo $of_cat->name; ?></option><?php
                }
            ?>
        </select>
    </p>

	<p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_carousel_button]"><?php _e( 'Carousel Button Label', 'showroom' ) ?></label>
	<input type="text" size="30" value="<?php echo genesis_get_option( 'zp_home_carousel_button', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_carousel_button]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_carousel_button]"></p>
    <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_carousel_button_link]"><?php _e( 'Carousel Button Link', 'showroom' ) ?></label>
	<input type="text" size="30" value="<?php echo genesis_get_option( 'zp_home_carousel_button_link', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_carousel_button_link]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_carousel_button_link]"></p>      
    <p><span class="description"><?php _e( 'This settings applies to the home carousel section.','showroom' ) ?></span></p> 
<?php }

 
function zpsettings_slideshow_settings() { ?>
	<p><input type="checkbox" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_slider_enable]" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_slider_enable]" value="1" <?php checked( 1, genesis_get_option( 'zp_slider_enable', ZP_SETTINGS_FIELD ) ); ?> /> <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_slider_enable]"><?php _e( 'Check to enable slider.', 'showroom' ); ?></label></p>
    <p><input type="checkbox" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_slider_caption]" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_slider_caption]" value="1" <?php checked( 1, genesis_get_option( 'zp_slider_caption', ZP_SETTINGS_FIELD ) ); ?> /> <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_slider_caption]"><?php _e( 'Include Slider Caption?', 'showroom' ); ?></label></p>
    <p>
        <label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_slideshow]"><?php _e( 'Select HomePage Slideshow', 'showroom' ); ?></label>
        <select name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_slideshow]" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_home_slideshow]">
            <?php
				$of_categories_obj = get_terms('slideshow');
				foreach ($of_categories_obj as $of_cat) {
                    ?><option value="<?php echo $of_cat->slug; ?>" <?php selected( genesis_get_option( 'zp_home_slideshow', ZP_SETTINGS_FIELD ), $of_cat->slug ); ?> > <?php echo $of_cat->name; ?></option><?php
                }
            ?>
        </select>
    </p>  
    <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_slider_speed]"><?php _e( 'Set the speed of slideshow cycling in milliseconds.', 'showroom' ); ?></label>
	<input type="text" size="20" value="<?php echo genesis_get_option( 'zp_slider_speed', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_slider_speed]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_slider_speed]">
	</p> 
    <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_animation_duration]"><?php _e( 'Set the speed of animation in milliseconds.', 'showroom' ); ?></label>
	<input type="text" size="20" value="<?php echo genesis_get_option( 'zp_animation_duration', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_animation_duration]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_animation_duration]">
	</p>    
	</p>     
  
     <p><span class="description"><?php _e( 'This settings applies to the theme slider.','showroom' ) ?></span></p> 
<?php }

function zpsettings_portfolio() { ?>
	<p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_related_portfolio_title]"><?php _e( 'Number of items in the portfolio archive', 'showroom' ) ?></label>
        <input type="text" size="30" value="<?php echo genesis_get_option( 'zp_related_portfolio_title', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_related_portfolio_title]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_related_portfolio_title]"></p>
     <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_num_portfolio_items]"><?php _e( 'Number of items in the portfolio page', 'showroom' ) ?></label>
        <input type="text" size="30" value="<?php echo genesis_get_option( 'zp_num_portfolio_items', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_num_portfolio_items]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_num_portfolio_items]"></p> 
     <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_num_archive_items]"><?php _e( 'Number of items in the portfolio archive', 'showroom' ) ?></label>
        <input type="text" size="30" value="<?php echo genesis_get_option( 'zp_num_archive_items', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_num_archive_items]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_num_archive_items]"></p>
        
     <p><span class="description"><?php _e( 'This settings applies to portfolio template and archive.','showroom' ) ?></span></p>  
    
<?php }


function zpsettings_appearance_settings() { ?>
    <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_css_code]"><?php _e( 'Custom CSS Code.', 'showroom' ); ?><br>
	<textarea class="widefat" rows="5" cols="78" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_css_code]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_css_code]"><?php echo genesis_get_option( 'zp_css_code', ZP_SETTINGS_FIELD ); ?></textarea>
	</label>
	</p>  
     
   <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo]"><?php _e( 'Upload Custom Logo.', 'vanish' ); ?></label>
    <input type="text" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo]" value="<?php echo  genesis_get_option( 'zp_logo', ZP_SETTINGS_FIELD ); ?>" />    
    <input id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo_upload_button]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo_upload_button]" type="button" class="button upload_button" value="<?php _e( 'Upload Logo', 'vanish' ); ?>" /> 
	<input name="zp_remove_button" type="button"  class="button remove_button" value="<?php _e( 'Remove Logo', 'vanish' ); ?>" /> 
    <span class="upload_preview" style="display: block;">
		<img style="max-width:100%;" src="<?php echo genesis_get_option( 'zp_logo', ZP_SETTINGS_FIELD ); ?>" />
	</span>
    </p>
    <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo_width]"><?php _e( 'Custom Logo Width in pixel. e.g. 200', 'vanish' ); ?></label>
	<input type="text" size="30" value="<?php echo genesis_get_option( 'zp_logo_width', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo_width]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo_width]">
	</p> 
    
    <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo_height]"><?php _e( 'Custom Logo Height in pixel. e.g. 200', 'vanish' ); ?></label>
	<input type="text" size="30" value="<?php echo genesis_get_option( 'zp_logo_height', ZP_SETTINGS_FIELD ); ?>" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo_height]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_logo_height]">
	</p>       
    <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_favicon]"><?php _e( 'Upload Custom Favicon.', 'vanish' ); ?></label>  
    <input type="text" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_favicon]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_favicon]" value="<?php echo  genesis_get_option( 'zp_favicon', ZP_SETTINGS_FIELD ); ?>" />
    <input id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_favicon_upload_button]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_favicon_upload_button]" type="button" class="button upload_button" value="<?php _e( 'Upload Favicon', 'vanish' ); ?>" />
    <input name="zp_remove_button" type="button"  class="button remove_button" value="<?php _e( 'Remove Favicon', 'vanish' ); ?>" /> 
    <span class="upload_preview" style="display: block;">
		<img style="max-width:100%;" src="<?php echo genesis_get_option( 'zp_favicon', ZP_SETTINGS_FIELD ); ?>" />
	</span>
    </p>
             
    
	<p><span class="description"><?php _e( 'This is the appearance settings.','showroom' ); ?></span></p>    
	
<?php } 
function zpsettings_footer_settings() { ?>
    <p><label for="<?php echo ZP_SETTINGS_FIELD; ?>[zp_footer_text]"><?php _e( 'Footer Text', 'showroom' ); ?><br>
	<textarea class="widefat" rows="5" cols="78" id="<?php echo ZP_SETTINGS_FIELD; ?>[zp_footer_text]" name="<?php echo ZP_SETTINGS_FIELD; ?>[zp_footer_text]"><?php echo genesis_get_option( 'zp_footer_text', ZP_SETTINGS_FIELD ); ?></textarea>
	<br><small><strong><?php _e( 'Enter your site copyright here.', 'showroom' ); ?></strong></small>
	</label>
	</p>    
	
<?php }

/* Replace the 'Insert into Post Button inside Thickbox'
------------------------------------------------------------ */
function zp_replace_thickbox_text($translated_text, $text ) {	
	if ( 'Insert into Post' == $text ) {
		$referer = strpos( wp_get_referer(), ZP_SETTINGS_FIELD );
		if ( $referer != '' ) {
			return __('Insert Image!', 'showroom' );
		}
	}
	return $translated_text;
}
/* Hook to filter Insert into Post Button in thickbox
------------------------------------------------------------ */
function zp_change_insert_button_text() {
		add_filter( 'gettext', 'zp_replace_thickbox_text' , 1, 2 );
}
add_action( 'admin_init', 'zp_change_insert_button_text' );

/* Set the screen layout to one column
------------------------------------------------------------ */
add_filter( 'screen_layout_columns', 'zpsettings_settings_layout_columns', 10, 2 );
/**
 * zpsettings_settings_layout_columns function.
 *
 * This function sets the column layout to one for the CT Settings settings page.
 *
 */
function zpsettings_settings_layout_columns( $columns, $screen ) {
	global $_zpsettings_settings_pagehook;
	if ( $screen == $_zpsettings_settings_pagehook ) {
		$columns[$_zpsettings_settings_pagehook] = 2;
	}
	return $columns;
}

/* Build our theme options page
------------------------------------------------------------ */
/**
 * zpsettings_theme_options_page function.
 *
 * This function displays the content for the CT Settings settings page, builds the forms and outputs the metaboxes.
 *
 */
function zpsettings_theme_options_page() { 
	global $_zpsettings_settings_pagehook, $screen_layout_columns;
	$screen = get_current_screen();
	$width = "width: 100%;";
	$hide2 = $hide3 = " display: none;";
	?>	
	
	<div id="zpsettings" class="wrap genesis-metaboxes">
		<form method="post" action="options.php">
		
			<?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
			<?php wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>
			<?php settings_fields( ZP_SETTINGS_FIELD ); ?>
					
			<h2 style="width: 100%; margin-bottom: 10px;"><?php _e( 'Showroom Settings', 'showroom' ); ?>
            	<span style="float: right; text-align: center;"><input type="submit" class="button-primary genesis-h2-button" value="<?php _e( 'Save Settings', 'showroom' ) ?>" style="vertical-align: top;" />
                <input type="submit" class="button genesis-h2-button" name="<?php echo ZP_SETTINGS_FIELD; ?>[reset]" value="<?php _e( 'Reset Settings', 'showroom' ); ?>" onclick="return genesis_confirm('<?php echo esc_js( __( 'Are you sure you want to reset?', 'showroom' ) ); ?>');" /></span>
			</h2>
			<div class="metabox-holder">
				<div class="postbox-container" style="<?php echo $width; ?>">
					<?php do_meta_boxes( $_zpsettings_settings_pagehook, 'main', null ); ?>
				</div>
			</div>
            <div class="bottom-buttons">
                <input type="submit" class="button-primary genesis-h2-button" value="<?php _e( 'Save Settings', 'showroom' ) ?>" />
                 <input type="submit" class="button genesis-h2-button" name="<?php echo ZP_SETTINGS_FIELD; ?>[reset]" value="<?php _e( 'Reset Settings', 'showroom' ); ?>" onclick="return genesis_confirm('<?php echo esc_js( __( 'Are you sure you want to reset?', 'showroom' ) ); ?>');" />
             </div>
		
		</form>
	</div>
	<script type="text/javascript">
		//<![CDATA[
		jQuery(document).ready( function($) {
			// close postboxes that should be closed
			$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
			// postboxes setup
			postboxes.add_postbox_toggles('<?php echo $_zpsettings_settings_pagehook; ?>');
		});
		//]]>
	</script>
<?php }