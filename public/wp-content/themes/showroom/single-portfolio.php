<?php 
/*
* Single Portfolio Page
*/

/** Force the full width layout layout on the Portfolio page */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

remove_action(	'genesis_loop', 'genesis_do_loop' );
add_action(	'genesis_loop', 'zp_single_portfolio_page' );
function zp_single_portfolio_page() {

	global $post; 
	
	if ( have_posts() ) : while ( have_posts() ) : the_post();
	printf( '<article %s>', genesis_attr( 'entry' ) );
	
	$thumbnail = wp_get_attachment_image( get_post_thumbnail_id(  $post->ID  ) , 'portfolio_single' );
	$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id(  $post->ID  ) , 'full' );
	$portfolio_images = get_post_meta( $post->ID, 'portfolio_images', true );

	?>
    
    <div class="single_portfolio_container">
    	<?php if( empty( $portfolio_images )){ ?>
    	<div class="single_portfolio_featured_image">
                <a href="<?php echo $thumbnail_src[0]; ?>" title="<?php the_title(  ); ?>" rel="prettyPhoto[pp_gal]">
                <?php echo $thumbnail;  ?>
                </a>
        </div>
        <?php }else{ ?>
        <script type="text/javascript">
		jQuery.noConflict();
		jQuery(document).ready(function(e){
				jQuery('.portfolio_single_slider').flexslider({
					animation: "slide",
					slideDirection: "horizontal",
					directionNav: true,
					controlNav: false,
					pauseOnAction:true,
					pauseOnHover: true,
					useCSS: false,
					slideshow: true,
				    animationLoop: true,
				    smoothHeight: true,
					video: true
				});
				jQuery('.flexslider').hover(function(){	
					jQuery(this).children('ul.flex-direction-nav').css({display: 'block'});
					
				}, function(){
						jQuery(this).children('ul.flex-direction-nav').css({display: 'none'});
	
				});
		});
		</script>
        <div class="portfolio_single_slider flexslider">
        	<ul class="slides">
            <?php
			$ids = explode(",", $portfolio_images );	
			$i=0;
			while( $i < count( $ids ) ){
				if( $ids[$i] ){
					// get image url
					$url = wp_get_attachment_image( $ids[$i] , 'portfolio_single' );
					$full_url = wp_get_attachment_image_src( $ids[$i] , 'full' );		
					echo '<li><a href="'.$full_url[0].'" rel="prettyPhoto[pp_gal]" title="'.get_the_title(  ).'" >'.$url.'</a></li>';
				}
				$i++;
			}
			?>

            </ul>
        </div>
        <?php } ?>
        <div class="single_portfolio_sidebar">
        	<header class="entry-header">
            	<h1 class="entry-title" itemprop="headline"><?php echo get_the_title(); ?></h1>
            </header>
            <div class="single_portfolio_description">
            	<?php echo do_shortcode( get_post_meta( $post->ID, 'portfolio_desc', true ) ); ?>
            </div>
        </div>
    </div>

    <div class="single_portfolio_content">
		<?php the_content(); ?>
    </div>


<?php 
	zp_related_portfolio(); 
	echo '</article>';
	
	endwhile;endif;

}

genesis();