<?php 
get_header(); 
do_action( 'genesis_home' );

if( is_active_sidebar('hometop') ) : ?> 
<div class="home-top">
	<div class="widget-area">
    	<div class="widget">
			<?php dynamic_sidebar('hometop'); ?>
        </div>
    </div>
</div>
<?php endif; ?>

<div id="home-middle-wrap">
    <?php if( is_active_sidebar('homemiddle-1') || is_active_sidebar('homemiddle-2')) : ?>
    	<div class="home-middle-1 widget-area">
			<?php dynamic_sidebar('homemiddle-1'); ?>
        </div>
        
        <div class="home-middle-2 widget-area">
			<?php dynamic_sidebar('homemiddle-2'); ?>
        </div>
     <?php endif; ?>
</div>

<?php 
zp_latest_portfolio();
get_footer();
?>