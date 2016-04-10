<?php 

/*-------------------------------------------------------------*/
//					Theme Images
/*------------------------------------------------------------*/
add_theme_support('post-thumbnails');
add_image_size('Frontpage', 360, 160, TRUE);
add_image_size('Square', 100, 100, TRUE);
add_image_size( 'Blog', 700, 260, TRUE );
add_image_size( 'portfolio-thumb', 360, 236, true );
add_image_size( 'portfolio-single', 702, 9999 );
add_image_size( 'post_thumb', 180, 150, true );
add_image_size( 'post_featured', 655, 280, true );
add_image_size( 'carousel_feature', 360, 227, true );

/**
 * Get portfolio items values ( width, height, columns and number of items )
 * @param integer $columns - Number of Columns Set
 * @returns an array of values (width, height, column class) to be used in the template
*/

function zp_portfolio_items_values( $columns ){
	$values = array();

	if(  $columns == 2  )
	{
		$values['size'] = 'portfolio_2col';
		$values['class'] = '-2col';
	}
	
	if(  $columns == 3  )
	{
		$values['size'] = 'portfolio_3col';
		$values['class'] = '-3col';
	}
	
	if(  $columns == 4  )
	{
		$values['size'] = 'portfolio_4col';
		$values['class'] = '-4col';
	}
	
	return $values;
		
}

/**
 * Portfolio Category Filter function
 * @param boolean $filter - true/false
 * @returns html tag for portfolio category
*/

function zp_portfolio_category_filter(  ){
	
	$default = 'class="selected"';
	$pre_select = '';
	
	$output = '';
		$output .= '<div id="options" class="clearfix '.$pre_select.'">';		
		$output .=  '<ul id="portfolio-categories" class="option-set" data-option-key="filter"><li><a href="#" data-option-value="*" '.$default.'>'.__( 'show all','showroom' ).'</a></li>';						
		
		$categories = get_categories( array( 'taxonomy' => 'portfolio_category' ) );
			foreach( $categories as $category ) :
			$tms=str_replace( " ","-",$category->name );
						
			$output .=  '<li><a href="#" data-option-value=".'.$category->slug.'">'.$category->name.'</a></li>';
			endforeach;
		
		$output .=  '</ul></div>';	

	return $output;
}


/**
 * Get the terms where the portfolio items belong and use as a class
 * Terms was used as a selector on the isotope fitler 
 * @param integer $id - ID of the post
 * @returns string - list of terms separated by space
*/

function zp_portfolio_items_term( $id ){
	
	$output = '';
	
	$terms = wp_get_post_terms( $id, 'portfolio_category' );
	$term_string = '';
		foreach( $terms as $term ){
			$term_string.=( $term->slug ).',';
		}
	$term_string = substr( $term_string, 0, strlen( $term_string )-1 );
	
	/** separate terms with space*/
	$string = str_replace( ","," ",$term_string );
	$output = $string." ";	
	
	return $output;	
	
}

/**
 * Displays Portfolio Items in different column layout
 *
 * It accepts values from a portfolio templates
 *
 * @param integer $columns - Number of Columns
 * @param integer $num_items - Number of items to display
 * @param boolean $type - gallery/portfolio
 * @param string $pagination - display pagination true/false 
 * @param boolean $filter - display filter true/false 
 *
*/

function zp_portfolio_template( $columns, $num_items, $type, $pagination, $filter ){
	global $post, $paged, $wp_query;	
										
	/** get appropriate columns, image height and image width*/
	$_values = zp_portfolio_items_values( $columns );
	
	/** determines if it will be a portfolio layout or gallery layout*/
	$class = ( $type == 'portfolio' ) ? 'element' : 'gallery';
	
	/** display portfolio category filter*/
	if($filter)
		echo zp_portfolio_category_filter( );
	
	$html='';
	

		if( is_tax('portfolio_category')){
			$term =	$wp_query->queried_object;
			$args= array( 
				'posts_per_page' =>$num_items,
				'post_type' => 'portfolio',
				'paged' => $paged,
				'portfolio_category' => $term->slug
			);
			
			query_posts( $args );
		}else{
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			$args= array(
				'posts_per_page' =>$num_items,
				'post_type' => 'portfolio',
				'paged' => $paged,
			);
			query_posts( $args );
		}
	?>	

	<div id="container" class="filter_container" style="height: auto; width: 100%;">

	<?php
	if(  have_posts( ) ) {											
 		while (  have_posts(  )  ) {
			the_post(  );
			
			$t=get_the_title(  );
			$permalink=get_permalink(  );	
					
			$content = get_post_meta( $post->ID, 'portfolio_desc', true );
			$content = strip_tags( strip_shortcodes( $content ), '<script>,<style>' );
			$content = trim( preg_replace( '#<(s(cript|tyle)).*?</\1>#si', '', $content ) );
			$content = wp_trim_words( $content, 20 );
															
			$thumbnail = wp_get_attachment_image( get_post_thumbnail_id(  $post->ID  ) ,'portfolio-thumb' );			
			
			$video_url = get_post_meta( $post->ID, 'zp_video_url_value', true);
							
			$openLink='<div class="portfolio_image">';
			$closeLink='</div>';
					
			if(  $type == 'portfolio'  ){
				$span_desc='<div class="item_label"><h4>'.$t.'</h4><p>'.$content.'</p></div>';
				$item_desc = '<a class="item_link" href="'.$permalink.'">'.$thumbnail.'</a><a href="'.$permalink.'"><i class="fa fa-link"></i></a>';
			}else{
				
				if( $video_url != '' ){
					$span_desc = '';
					$item_desc='<a class="item_gallery" href="'.zp_video_preg_match( $video_url ).'" rel="prettyPhoto[pp_gal]">'.$thumbnail.'</a>';
				}else{
					$span_desc = '';
					$item_desc=''.$thumbnail.'<a href="'.wp_get_attachment_url(  get_post_thumbnail_id(  $post->ID  )  ).'" rel="prettyPhoto[pp_gal]"><i class="fa fa-search"></i></a>';
				}
			}
					
			/** generate the final item HTML */
			$html.= '<div class="element '.$class.''.$_values['class'].' '.zp_portfolio_items_term( $post->ID ).'" data-filter="'.zp_portfolio_items_term( $post->ID ).'">'.$openLink.$item_desc.$closeLink.''.$span_desc.'</div>';
		}
	}
			echo $html;
		?>
       </div>
      
	
<?php
if(  $pagination  )
	genesis_posts_nav();

wp_reset_query(  );

}


/**
 * Displays the related portfolio in the single portfolio page. 
 *
 */

function zp_related_portfolio(){
global $post;

	$terms = get_the_terms( $post->ID , 'portfolio_category' );	
	$term_ids = array_values( wp_list_pluck( $terms,'term_id' ) );
	
	/** get appropriate columns, image height and image width*/
	$_values = zp_portfolio_items_values( 3 );

	
	$args=array(
     'post_type' => 'portfolio',
     'tax_query' => array(
                    array(
                        'taxonomy' => 'portfolio_category',
                        'field' => 'id',
                        'terms' => $term_ids,
                        'operator'=> 'IN' 
                     )),
      'posts_per_page' => 3,
      'orderby' => 'rand',
      'post__not_in'=>array( $post->ID )
	);

	query_posts( $args ); 
?>
    <div class = "related_portfolio">		
        <div class="section-title"><h4><?php echo genesis_get_option( 'zp_related_portfolio_title' , ZP_SETTINGS_FIELD ); ?></h4></div>
       <div id="container" style="width: 100%">
      
      <?php
	  	  if(  have_posts( ) ) {											
 		while (  have_posts(  )  ) {
			the_post(  ); 
			
			$t=get_the_title(  );
			$permalink=get_permalink(  );	
																
			$thumbnail = wp_get_attachment_image( get_post_thumbnail_id(  $post->ID  ) , $_values['size'], '', array( 'title' => $t ) ); 
			$video_url = get_post_meta( $post->ID, 'zp_video_url_value', true);
							
			$openLink='<div class="portfolio_image">';
			$closeLink='</div>';
					
			$span_desc='<div class="item_label"><h4>'.$t.'</h4></div>';
			$item_desc = '<a class="item_link" href="'.$permalink.'">'.$thumbnail.'</a><a href="'.$permalink.'"><i class="fa fa-link"></i></a>';
								
			/** generate the final item HTML */
			echo '<div class="element element'.$_values['class'].' '.zp_portfolio_items_term( $post->ID ).'" data-filter="'.zp_portfolio_items_term( $post->ID ).'">'.$openLink.$item_desc.$closeLink.''.$span_desc.'</div>';
			}
		}else{
				_e( 'No related projects', 'showroom' );
		  }
	
		  
		 wp_reset_query(  ); 
	  ?>

        </div>
    </div>
<?php }

/**
 * Display Portfolio in the homepage
*/

function zp_latest_portfolio(){
if( genesis_get_option( 'zp_enable_carousel' , ZP_SETTINGS_FIELD ) ){
	global $post;	
?>
<div id="carousel">
<div class="carousel_section"><div class="carousel_description">
	<h4><?php echo genesis_get_option( 'zp_home_carousel_title' , ZP_SETTINGS_FIELD );?></h4>
    <div ><?php echo do_shortcode( genesis_get_option( 'zp_home_carousel_desc' , ZP_SETTINGS_FIELD ) );?></div>
    <?php if( ( genesis_get_option( 'zp_home_carousel_button_link' , ZP_SETTINGS_FIELD )) && (genesis_get_option( 'zp_home_carousel_button' , ZP_SETTINGS_FIELD ))  ) {?>
    	<a class="more-link" href="<?php echo genesis_get_option( 'zp_home_carousel_button_link' , ZP_SETTINGS_FIELD ); ?>"><?php echo genesis_get_option( 'zp_home_carousel_button' , ZP_SETTINGS_FIELD ); ?></a>
    <?php } ?>
</div>
<div id="slider-code">
	<div class="flexslider carousel">
    <ul class="slides">
	<?php
	$items = ( genesis_get_option( 'zp_home_carousel_items' , ZP_SETTINGS_FIELD ) )? genesis_get_option( 'zp_home_carousel_items' , ZP_SETTINGS_FIELD ) : 10;
    	$args = array( 
			'posts_per_page' =>$items,
			'post_type' => 'portfolio',
			'portfolio_category' => genesis_get_option( 'zp_home_carousel_category' , ZP_SETTINGS_FIELD )
		);
		query_posts($args);
		if(have_posts()){
			while (have_posts()){
				the_post();
				
				$content = get_post_meta( $post->ID, 'portfolio_desc', true );
				$content = strip_tags( strip_shortcodes( $content ), '<script>,<style>' );
				$content = trim( preg_replace( '#<(s(cript|tyle)).*?</\1>#si', '', $content ) );
				$content = wp_trim_words( $content, 20 );
				$thumbnail= wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
	?>
   	<li><?php the_post_thumbnail('carousel_feature');?>
    	<h3><a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a></h3>
    	<p><?php echo $content; ?></p>
    </li>
	
	<?php
    	}
	}
	?>
    </ul>
    </div>
	
	<script type="text/javascript">
	var J = jQuery.noConflict();
	
	J(window).load(function(){
		J('.flexslider').flexslider({
		animation: "slide",
		controlNav: true,
		directionNav: false,
		animationLoop: true,
		slideshow: true,
		itemWidth: 360, 
		itemMargin: 30,
		minItems: 1,
		maxItems: 2,
		move: 2
      });
    });
  </script>
  </div>
  </div>
 </div>

<?php 
	}
}
