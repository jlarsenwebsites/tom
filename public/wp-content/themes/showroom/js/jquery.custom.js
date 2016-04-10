// custom javasccript
jQuery.noConflict();						

// portfolio dimension on window resize

function zp_portfolio_item_dimension(){
	var window_width = jQuery(window).width();
	var container_width = jQuery('#container').width();
	
	if( window_width < 480 ){
		jQuery('.element').each( function(){
			//3 columns
			if( jQuery(this).hasClass( 'element-3col' ) || jQuery(this).hasClass( 'gallery-3col' ) ){
				item_height = jQuery(this).children('.portfolio_image').children('img').height();
				item_width  = Math.floor(( container_width - 30 ) / 1);
				jQuery(this).css({"width": item_width+"px", "max-width":item_width+"px"});
				jQuery(this).children('.portfolio_image').css({"height": item_height+"px"});
			}
		});	
	}else if( window_width <= 600 ){
		jQuery('.element').each( function(){
			//3 columns
			if( jQuery(this).hasClass( 'element-3col' )|| jQuery(this).hasClass( 'gallery-3col' ) ){
				item_height = jQuery(this).children('.portfolio_image').children('img').height();
				item_width  = Math.floor(( container_width - 60 ) / 2);
				jQuery(this).css({"width": item_width+"px"});
				jQuery(this).children('.portfolio_image').css({"height": item_height+"px"});
			}	
		});
	}else{
		// check if fullwidth or not		
		if( jQuery('body').hasClass( 'sidebar-content' ) || jQuery( 'body' ).hasClass( 'content-sidebar' )  ){
			jQuery('.element').each( function(){
				//3 columns
				if( jQuery(this).hasClass( 'element-3col' ) || jQuery(this).hasClass( 'gallery-3col' ) ){
					item_height = jQuery(this).children('.portfolio_image').children('a').children('img').height();
					item_width  = Math.floor(( container_width - 60 ) / 2 );
					jQuery(this).css({"width": item_width+"px"});
					jQuery(this).children('.portfolio_image').css({"height": item_height+"px"});
				}
			});
		}else{			
			jQuery('.element').each( function(){
				//3 columns
				if( jQuery(this).hasClass( 'element-3col' ) || jQuery(this).hasClass( 'gallery-3col' ) ){
					item_height = jQuery(this).children('.portfolio_image').children('a').children('img').height();
					item_width  = Math.floor(( container_width - 90 ) / 3);
					jQuery(this).css({"width": item_width+"px"});
					jQuery(this).children('.portfolio_image').css({"height": item_height+"px"});
				}
			});
		}
	}
	
}

jQuery(document).ready(function(jQuery) { 
	//Lightbox
	jQuery("a[rel^='prettyPhoto']").prettyPhoto({theme: 'light_rounded',counter_separator_label: ' of '});

	jQuery( function( ) { jQuery( ".tabs-container" ).tabs(); } );
	
	jQuery(".toggle-container").hide();
						 
		jQuery(".trigger").toggle(function(){
			jQuery(this).addClass("active");
			}, function () {
			jQuery(this).removeClass("active");
		});
		jQuery(".trigger").click(function(){
			jQuery(this).next(".toggle-container").slideToggle();
		});
		
		jQuery('.trigger a').hover(function() {
		jQuery(this).stop(true,false).animate({color: '#666'},50);
			}, function () {
			jQuery(this).stop(true,false).animate({color: '#888'},150);
	});

	jQuery('.accordion').hide();

	jQuery('.trigger-button').click(function() {
		jQuery(".trigger-button").removeClass("active")
		jQuery('.accordion').slideUp('normal');
		if(jQuery(this).next().is(':hidden') == true) {
			jQuery(this).next().slideDown('normal');
			jQuery(this).addClass("active");
		 } 
	 });
	 
	 jQuery('.trigger-button').hover(function() {
		jQuery(this).stop(true,false).animate({color: '#666'},50);
			}, function () {
			jQuery(this).stop(true,false).animate({color: '#888'},150);
	});

	/*-------------------------------------------------------------*/
	//					to top link script
	/*------------------------------------------------------------*/
		jQuery.fn.topLink = function(settings) {
			settings = jQuery.extend({
				min: 1,
				fadeSpeed: 200
				},
				settings );
				return this.each(function() {
					// listen for scroll
					var el = jQuery(this);
					el.hide(); // in case the user forgot
					jQuery(window).scroll(function() {
					if(jQuery(window).scrollTop() >= settings.min) {
					el.fadeIn(settings.fadeSpeed);
					} else {
					el.fadeOut(settings.fadeSpeed);
					}
				});
			});
			};

	/*-------------------------------------------------------------*/
	//					usage w/ smoothscroll
	/*------------------------------------------------------------*/
			jQuery(document).ready(function() {
			// set the link
				jQuery('#top-link').topLink({
				min: 400,
				fadeSpeed: 500
				});
				
				// smoothscroll
				jQuery('#top-link').click(function(e) {
				e.preventDefault();
				jQuery.scrollTo(0,300);
				});
			});
			
	/*-------------------------------------------------------------*/
	//					Portfolio Filter
	/*------------------------------------------------------------*/	
		zp_portfolio_item_dimension();			
		var jQuerycontainer = jQuery('#container');
		var jQueryoptionSets = jQuery('#options .option-set'),
		jQueryoptionLinks = jQueryoptionSets.find('a');
	
		  jQueryoptionLinks.click(function(){
			var jQuerythis = jQuery(this);
			// don't proceed if already selected
			if ( jQuerythis.hasClass('selected') ) {
			  return false;
			}
			var jQueryoptionSet = jQuerythis.parents('.option-set');
			jQueryoptionSet.find('.selected').removeClass('selected');
			jQuerythis.addClass('selected');
	  
			// make option object dynamically, i.e. { filter: '.my-filter-class' }
			var options = {},
				key = jQueryoptionSet.attr('data-option-key'),
				value = jQuerythis.attr('data-option-value');
			// parse 'false' as false boolean
			value = value === 'false' ? false : value;
			options[ key ] = value;
			if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
			  // changes in layout modes need extra logic
			  changeLayoutMode( jQuerythis, options )
			} else {
			  // otherwise, apply new options
			  jQuerycontainer.isotope( options );
			}
			
			return false;
		  });

	/*-------------------------------------------------*
	//				Mobile Menu
	/*-------------------------------------------------*/
			jQuery('.mobile_menu').toggle(function(){
				jQuery('.nav-primary').slideDown(500);
			},function(){
				jQuery('.nav-primary').slideUp(500);
			});	
	/*-------------------------------------------------*/
	// Mobile Menu Trigger
	/*-------------------------------------------------*/
		
		jQuery('.nav-primary .menu li').each(function(){
			if( jQuery(this).children('ul.sub-menu').length > 0 ){
				jQuery(this).children('a').after('<span class="indicator open"><i class="fa fa-angle-down"></i></span>');	
			}
		});
		
		jQuery('.nav-primary .menu li span.indicator').toggle(function(){
			jQuery(this).parent().children('ul.sub-menu').slideDown();
			jQuery(this).children('i').removeClass('fa-angle-down');
			jQuery(this).children('i').addClass('fa-angle-up');
		},function(){
			jQuery(this).parent().children('ul.sub-menu').slideUp();
			jQuery(this).children('i').removeClass('fa-angle-up');
			jQuery(this).children('i').addClass('fa-angle-down');
		});	
});

/* ========== ISOTOPE FILTERING ========== */

jQuery(window).load(function(){
		zp_portfolio_item_dimension();
		
		var isFilter_value = '';
		if( jQuery('#options').hasClass( 'pre_select' )){			
			isFilter_value = jQuery('.option-set li a.selected ').attr('data-option-value');
		}
		
		var jQuerycontainer = jQuery('#container');
		jQuerycontainer.isotope({
			 itemSelector : '.element',
			 filter : isFilter_value
		});
});

/*-------------------------------------------------------------*/
//			Refresh isotope when window resize
/*------------------------------------------------------------*/	
jQuery( window ).resize(function() {
	
	zp_portfolio_item_dimension();
	
	var jQuerycontainer = jQuery('#container');
	jQuerycontainer.isotope({
		 itemSelector : '.element'
	});

});				
				