<div id="home_gallery" >
      <?php 
	  global $post;
	 	 $slide_caption = genesis_get_option( 'zp_slider_caption' , ZP_SETTINGS_FIELD );
		 $slideshow = genesis_get_option( 'zp_home_slideshow', ZP_SETTINGS_FIELD );
		 
	  	$recent = new WP_Query(array('post_type'=> 'slide', 'showposts' => '-1','orderby' => 'meta_value', 'meta_key'=>'slide-number','order'=>'ASC', 'slideshow' => $slideshow  )); 
      	 	$images = array();
	 		$captions = array();
	 		$counter = 0;
			$image_url = array();
			$link = array();
			$description = array();
			
      	 while($recent->have_posts()) : $recent->the_post();
		 	$image_url[$counter] = wp_get_attachment_url(  get_post_thumbnail_id(  $post->ID  )  );
	 		$images[$counter] = genesis_get_image();
			$captions[$counter] = get_the_title('',FALSE);
			$link[$counter] = get_post_meta($post->ID, 'slider_link_value', true);
			$description[$counter]= get_the_content();
			$button[$counter]= get_post_meta($post->ID, 'slider_button_label', true);
			$counter += 1;
			endwhile;
  			$counter=0;
			
	  ?>
        <div id="slider" class="flexslider">
        	<ul class="slides">
			<?php foreach($images as $image){
					 ?>
              			<li style=" background-image: url(<?php echo $image_url[$counter];?>)" >
                        <?php if ( $slide_caption ):?>
                                <div class="flex-caption">
                                <h1 href="<?php echo $link[$counter];?>"><?php echo $captions[$counter]; ?></h1>
                                <span><?php echo $description[$counter]; ?></span>
                                <?php if($button[$counter]): ?>
                               			 <a class="more-link" href="<?php echo $link[$counter];?>"><?php echo $button[$counter];?></a>
                                <?php endif; ?>
                                </div>
                        <?php endif; ?>
                        </li>
                        
	 		<?php
            	$counter++;
			}
			?>
	    </ul>
	  </div>
      
      <!-- thumbnail -->
      <div id="carousel_slider" class="flexslider">
	    <ul class="slides" >
			<?php foreach($images as $image){ ?>
              			<li><?php echo $image;?></li>
            <?php
			}
			?>
	    </ul>
	  </div>
      
      <!-- end thumbnail -->
       	<script type="text/javascript">
		jQuery.noConflict();
		
		jQuery( window ).load(function() {      		
			jQuery('#carousel_slider').flexslider({
					animation: "slide",
					controlNav: false,
					directionNav: false,
					animationLoop: true,
					slideshow: false,
					itemWidth: 262,
					itemMargin: 15,
					minItems: 1,
					maxItems: 4,
					move: 1,
					asNavFor: '#slider'
				  });
				  
				  jQuery('#slider').flexslider({
					useCSS: false,
					controlNav: false,
				    animationLoop: true,
				    smoothHeight: true,
					slideshowSpeed: <?php echo genesis_get_option( 'zp_slider_speed' , ZP_SETTINGS_FIELD );?>,
					animationDuration: <?php echo genesis_get_option( 'zp_animation_duration' , ZP_SETTINGS_FIELD );?>,		
					video: true,
					sync: "#carousel_slider"
				  });		
		});

	</script>
</div>