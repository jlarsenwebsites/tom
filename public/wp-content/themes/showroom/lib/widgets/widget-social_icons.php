<?php

/**
 * Widget Registration.
 *
 * Register Simple Social Icons widget.
 *
 */
 
 add_action( 'widgets_init', 'zp_socialicon_load_widget' );
 
function zp_socialicon_load_widget() {

	register_widget( 'ZP_SocialIcons_Widget' );

}
class ZP_SocialIcons_Widget extends WP_Widget {

	protected $defaults;

	protected $sizes;

	protected $profiles;

	function __construct() {

		/**
		 * Default widget option values.
		 */
		$this->defaults = array(
			'title'					 => '',
			'new_window'			 => 0,
			'size'					 => 32,
			'border_radius'			 => 3,
			'background_color'		 => '#999999',
			'background_color_hover' => '#666666',
			'icon_color'			 => '#ffffff',
			'icon_color_hover'		 => '#999999',
			'alignment'				 => 'alignleft',
			'dribbble'				 => '',
			'email'				 => '',
			'facebook'				 => '',
			'gplus'					 => '',
			'linkedin'				 => '',
			'pinterest'				 => '',
			'rss'					 => '',
			'stumbleupon'				 => '',
			'twitter'				 => '',
			'youtube'				 => '',
			'flickr'				 => '',
			'instagram'				 => '',
			'github'				 => '',
		);

		/**
		 * Icon sizes.
		 */
		$this->sizes = array( '32', '48' );

		/**
		 * Social profile choices.
		 */
		$this->profiles = array(
			'dribbble' => array(
				'label'	  => __( 'Dribbble URI', 'showroom' ),
				'pattern' => '<li class="social-dribbble"><a class="hastip" title="dribble" href="%s" %s><i class="fa fa-dribbble"></i></a></li>',
			),
			'email' => array(
				'label'	  => __( 'Email URI', 'showroom' ),
				'pattern' => '<li class="social-email"><a class="hastip" title="email" href="%s" %s><i class="fa fa-envelope-o"></i></a></li>'
			),
			'facebook' => array(
				'label'	  => __( 'Facebook URI', 'showroom' ),
				'pattern' => '<li class="social-facebook"><a class="hastip" title="facebook" href="%s" %s><i class="fa fa-facebook"></i></a></li>'
			),
			'gplus' => array(
				'label'	  => __( 'Google+ URI', 'showroom' ),
				'pattern' => '<li class="social-gplus"><a class="hastip" title="google+" href="%s" %s><i class="fa fa-google-plus"></i></a></li>'
			),
			'linkedin' => array(
				'label'	  => __( 'Linkedin URI', 'showroom' ),
				'pattern' => '<li class="social-linkedin"><a class="hastip" title="linkedin" href="%s" %s><i class="fa fa-linkedin"></i></a></li>'
			),
			'pinterest' => array(
				'label'	  => __( 'Pinterest URI', 'showroom' ),
				'pattern' => '<li class="social-pinterest"><a class="hastip" title="pinterest" href="%s" %s><i class="fa fa-pinterest"></i></a></li>'
			),
			'rss' => array(
				'label'	  => __( 'RSS URI', 'showroom' ),
				'pattern' => '<li class="social-rss"><a class="hastip" title="rss" href="%s" %s><i class="fa fa-rss"></i></a></li>'
			),
			'twitter' => array(
				'label'	  => __( 'Twitter URI', 'showroom' ),
				'pattern' => '<li class="social-twitter"><a class="hastip" title="twitter" href="%s" %s><i class="fa fa-twitter"></i></a></li>'
			),
			'youtube' => array(
				'label'	  => __( 'YouTube URI', 'showroom' ),
				'pattern' => '<li class="social-youtube"><a class="hastip" title="youtube" href="%s" %s><i class="fa fa-youtube"></i></a></li>'
			),
			'flickr' => array(
				'label'	  => __( 'Flickr URI', 'showroom' ),
				'pattern' => '<li class="social-flickr"><a class="hastip" title="flickr" href="%s" %s><i class="fa fa-flickr"></i></a></li>'
			),
			'instagram' => array(
				'label'	  => __( 'Instagram URI', 'showroom' ),
				'pattern' => '<li class="social-instagram"><a class="hastip" title="instagram" href="%s" %s><i class="fa fa-instagram"></i></a></li>'
			),
			'github' => array(
				'label'	  => __( 'Github URI', 'showroom' ),
				'pattern' => '<li class="social-github"><a class="hastip" title="github" href="%s" %s><i class="fa fa-github"></i></a></li>'
			),
		);

		$widget_ops = array(
			'classname'	  => 'zp_social_icons',
			'description' => __( 'Displays select social icons.', 'showroom' ),
		);

		$control_ops = array(
			'id_base' => 'zp_social_icons',
			#'width'   => 505,
			#'height'  => 350,
		);

		parent::__construct( 'zp_social_icons', __( 'ZP Social Icons', 'showroom' ), $widget_ops, $control_ops );

		/** Load CSS in <head> */
		add_action( 'wp_head', array( $this, 'css' ) );
		
		}

	/**
	 * Widget Form.
	 *
	 * Outputs the widget form that allows users to control the output of the widget.
	 *
	 */
	function form( $instance ) {

		/** Merge with defaults */
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		?>

		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:','showroom' ); ?></label> <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" /></p>

		<p><label><input id="<?php echo $this->get_field_id( 'new_window' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'new_window' ); ?>" value="1" <?php checked( 1, $instance['new_window'] ); ?>/> <?php esc_html_e( 'Open links in new window?', 'showroom' ); ?></label></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'Icon Size', 'showroom' ); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'size' ); ?>" name="<?php echo $this->get_field_name( 'size' ); ?>">
				<?php
				foreach ( (array) $this->sizes as $size ) {
					printf( '<option value="%d" %s>%dpx</option>', (int) $size, selected( $size, $instance['size'], 0 ), (int) $size );
				}
				?>
			</select>
		</p>

		<p><label for="<?php echo $this->get_field_id( 'border_radius' ); ?>"><?php _e( 'Icon Border Radius:', 'showroom' ); ?></label> <input id="<?php echo $this->get_field_id( 'border_radius' ); ?>" name="<?php echo $this->get_field_name( 'border_radius' ); ?>" type="text" value="<?php echo esc_attr( $instance['border_radius'] ); ?>" size="3" />px</p>

		<p><label for="<?php echo $this->get_field_id( 'background_color' ); ?>"><?php _e( 'Background Color:', 'showroom' ); ?></label> <input id="<?php echo $this->get_field_id( 'background_color' ); ?>" name="<?php echo $this->get_field_name( 'background_color' ); ?>" type="text" value="<?php echo esc_attr( $instance['background_color'] ); ?>" size="8" /></p>

		<p><label for="<?php echo $this->get_field_id( 'background_color_hover' ); ?>"><?php _e( 'Hover Color:', 'showroom' ); ?></label> <input id="<?php echo $this->get_field_id( 'background_color_hover' ); ?>" name="<?php echo $this->get_field_name( 'background_color_hover' ); ?>" type="text" value="<?php echo esc_attr( $instance['background_color_hover'] ); ?>" size="8" /></p>
              
        <p><label for="<?php echo $this->get_field_id( 'icon_color' ); ?>"><?php _e( 'Icon Color:', 'showroom' ); ?></label> <input id="<?php echo $this->get_field_id( 'icon_color' ); ?>" name="<?php echo $this->get_field_name( 'icon_color' ); ?>" type="text" value="<?php echo esc_attr( $instance['icon_color'] ); ?>" size="8" /></p>

		<p><label for="<?php echo $this->get_field_id( 'icon_color_hover' ); ?>"><?php _e( 'Icon Hover Color:', 'showroom' ); ?></label> <input id="<?php echo $this->get_field_id( 'icon_color_hover' ); ?>" name="<?php echo $this->get_field_name( 'icon_color_hover' ); ?>" type="text" value="<?php echo esc_attr( $instance['icon_color_hover'] ); ?>" size="8" /></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'alignment' ); ?>"><?php _e( 'Alignment', 'showroom' ); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'alignment' ); ?>" name="<?php echo $this->get_field_name( 'alignment' ); ?>">
				<option value="alignleft" <?php selected( 'alignright', $instance['alignment'] ) ?>><?php _e( 'Align Left', 'showroom' ); ?></option>
				<option value="alignright" <?php selected( 'alignright', $instance['alignment'] ) ?>><?php _e( 'Align Right', 'showroom' ); ?></option>
			</select>
		</p>

		<hr style="background: #ccc; border: 0; height: 1px; margin: 20px 0;" />

		<?php
		foreach ( (array) $this->profiles as $profile => $data ) {

			printf( '<p><label for="%s">%s:</label>', esc_attr( $this->get_field_id( $profile ) ), esc_attr( $data['label'] ) );
			printf( '<input type="text" id="%s" class="widefat" name="%s" value="%s" /></p>', esc_attr( $this->get_field_id( $profile ) ), esc_attr( $this->get_field_name( $profile ) ), esc_url( $instance[$profile] ) );

		}

	}

	/**
	 * Form validation and sanitization.
	 *
	 * Runs when you save the widget form. Allows you to validate or sanitize widget options before they are saved.
	 *
	 */
	function update( $newinstance, $oldinstance ) {

		foreach ( $newinstance as $key => $value ) {

			/** Border radius must not be empty, must be a digit */
			if ( 'border_radius' == $key && ( '' == $value || ! ctype_digit( $value ) ) ) {
				$newinstance[$key] = 0;
			}

			/** Validate hex code colors */
			elseif ( strpos( $key, '_color' ) && 0 == preg_match( '/^#(([a-fA-F0-9]{3}$)|([a-fA-F0-9]{6}$))/', $value ) ) {
				$newinstance[$key] = $oldinstance[$key];
			}

			/** Sanitize Profile URIs */
			elseif ( array_key_exists( $key, (array) $this->profiles ) ) {
				$newinstance[$key] = esc_url( $newinstance[$key] );
			}

		}

		return $newinstance;

	}

	/**
	 * Widget Output.
	 *
	 * Outputs the actual widget on the front-end based on the widget options the user selected.
	 *
	 */
	function widget( $args, $instance ) {

		extract( $args );

		/** Merge with defaults */
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		echo $before_widget;

			if ( ! empty( $instance['title'] ) )
				echo $before_title . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $after_title;

			$output = '';

			$new_window = $instance['new_window'] ? 'target="_blank"' : '';

			foreach ( (array) $this->profiles as $profile => $data ) {
				if ( ! empty( $instance[$profile] ) )
					$output .= sprintf( $data['pattern'], esc_url( $instance[$profile] ), $new_window );
			}

			if ( $output )
				printf( '<ul class="%s">%s</ul>', $instance['alignment'], $output );

		echo $after_widget;

	}

	/**
	 * Custom CSS.
	 *
	 * Outputs custom CSS to control the look of the icons.
	 */
	function css() {

		/** Pull widget settings, merge with defaults */
		$all_instances = $this->get_settings();
		if( $all_instances ){
			$instance = wp_parse_args( $all_instances[$this->number], $this->defaults );
		
		//check size & line-height
		$icon_size = ( $instance['size'] == 48 ) ? 'font-size: 20px;' : '';
		$icon_height = ( $instance['size'] == 48 ) ? 'line-height: 54px;' : 'line-height: 32px;';	
			
		/** The CSS to output */
		$css = '.zp_social_icons {
			overflow: hidden;
		}
		.zp_social_icons .alignleft, .zp_social_icons .alignright {
			margin: 0; padding: 0;
		}
		.zp_social_icons ul li {
			list-style: none;
			float: left;
			margin: 2px;
		}
		.zp_social_icons ul li a,
		.zp_social_icons ul li a:hover {
			background: ' . $instance['background_color'].';
			-moz-border-radius: ' . $instance['border_radius'] . 'px
			-webkit-border-radius: ' . $instance['border_radius'] . 'px;
			border-radius: ' . $instance['border_radius'] . 'px;
			color: ' . $instance['icon_color'].';
			display: block;
			height: ' . $instance['size'] . 'px;
			overflow: hidden;
			width: ' . $instance['size'] . 'px;
			'.$icon_height.'
			text-align: center;
		}

		.zp_social_icons ul li a:hover {
			background-color: ' . $instance['background_color_hover'] . ';
		}
		.zp_social_icons ul li a i{
			color: ' . $instance['icon_color'].';
			'.$icon_size.'
		}
		.zp_social_icons ul li a:hover i{
			color: ' . $instance['icon_color_hover'].';
			'.$icon_size.'
		}';

		/** Minify a bit */
		$css = str_replace( "\t", '', $css );
		$css = str_replace( array( "\n", "\r" ), ' ', $css );

		/** Echo the CSS */
		echo '<style type="text/css">' . $css . '</style>';
		}

	}

}

