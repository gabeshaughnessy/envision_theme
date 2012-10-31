(function($) {

/*-----------------------------------------------------------------------------------*/
/*	Browser Detect - Find OS
/*-----------------------------------------------------------------------------------*/
	// We are doing this because Windows is displaying certain HTML entities differently
	// in terms of size for browsers.
	$('html').addClass( BrowserDetect.OS.toLowerCase() );


/*-----------------------------------------------------------------------------------*/
/*	Anystretch.js Init
/*-----------------------------------------------------------------------------------*/
	var background_image = hoon_background_image.background_image;
	if ( background_image != '' ) {
		$.anystretch( background_image, { speed: 400 } );
	}


/*-----------------------------------------------------------------------------------*/
/*	Hide URL Bar for iOS
/*-----------------------------------------------------------------------------------*/
	/* @link  http://remysharp.com/2010/08/05/doing-it-right-skipping-the-iphone-url-bar/ */
	/mobile/i.test(navigator.userAgent) && !location.hash && setTimeout(function () {
	  window.scrollTo(0, 1);
	}, 1000);

	
/*-----------------------------------------------------------------------------------*/
/*	Tabs
/*-----------------------------------------------------------------------------------*/
	function activateTab($tab) {
		var $activeTab = $tab.closest('ul').find('a.active'),
				contentLocation = $tab.attr("href") + '-tab';

		//Make Tab Active
		$activeTab.removeClass('active');
		$tab.addClass('active');

    	//Show Tab Content
		$(contentLocation).closest('.tabs-content').children('li').hide();
		$(contentLocation).css('display', 'block');
	}

	$('ul.tabs').each(function () {
		//Get all tabs
		var tabs = $(this).children('li').children('a');
		tabs.click(function (e) {
			activateTab($(this));
		});
	});

	if (window.location.hash) {
		activateTab($('a[href="' + window.location.hash + '"]'));
	}	
	

/*-----------------------------------------------------------------------------------*/
/*	Block Grid Support for IE6/7/8
/*-----------------------------------------------------------------------------------*/
	$('.block-grid.two-up>li:nth-child(2n+1)').css({clear: 'left'});
	$('.block-grid.three-up>li:nth-child(3n+1)').css({clear: 'left'});
	$('.block-grid.four-up>li:nth-child(4n+1)').css({clear: 'left'});
	$('.block-grid.five-up>li:nth-child(5n+1)').css({clear: 'left'});

})(window.jQuery);




jQuery( document ).ready( function($) {

/*-----------------------------------------------------------------------------------*/
/*	Gallery Slider Display (FlexSlider)
/*-----------------------------------------------------------------------------------*/
	$( '.flexslider-wrapper' ).each( function() {
		var hoon_slideshow                    = ( 0 == hoon_slideshow_options.slideshow ) ? false : true;
		var hoon_slideshow_speed              = hoon_slideshow_options.slideshow_speed;
		var hoon_slideshow_animation          = Modernizr.touch ? 'slide' : hoon_slideshow_options.animation;
		var hoon_slideshow_animation_duration = hoon_slideshow_options.animation_duration;
		
		var flexSlider = $('.flexslider.slider', this);
		var flexCarousel = $('.flexslider.carousel', this);
		
		flexSlider.flexslider({
			prevText: '<i class="icon-chevron-left"></i>',
			nextText: '<i class="icon-chevron-right"></i>',
			animation: hoon_slideshow_animation,
			animationSpeed: hoon_slideshow_animation_duration,
			controlNav: false,
			animationLoop: false,
			slideshow: false,
			slideshowSpeed: hoon_slideshow_speed,
			pausePlay: hoon_slideshow,
			pauseText: ' ',
			playText: ' ',
			//smoothHeight: true,
			sync: flexCarousel
		});
		
		flexCarousel.flexslider({
			prevText: '<i class="icon-chevron-left"></i>',
			nextText: '<i class="icon-chevron-right"></i>',
			animation: 'slide',
			controlNav: false,
			animationLoop: false,
			slideshow: hoon_slideshow,
			itemWidth: 95,
			itemMargin: 5,
			asNavFor: flexSlider
		});
		
	
		if ( hoon_slideshow ) {
			flexSlider.flexslider("play"); // Needed to start flexSlider.
			
			var flexDirectionNav = $( '.flex-direction-nav', flexSlider );
			$( 'li:eq(0)', flexDirectionNav ).after('<li>&nbsp;</li>');
		}
	});
	
/*-----------------------------------------------------------------------------------*/
/*	Format Videos Placement
/*-----------------------------------------------------------------------------------*/
	$('#content .format-video').each( function(index, el) {
	    // Find the first oEmbed video
	    var formatVideoCache = $(this).contents().find('.wp-embed').first();
	    // Get the videos content
	    var formatVideoContent = $(formatVideoCache).html();
	    
	    // Place video in the .entry-video container
	    if( '' != formatVideoContent ) {
	        $( '.entry-media', this ).append(formatVideoContent);
	        $(formatVideoCache).remove();
	    }
	    
		/**
		 * Entry Content Cleanup
		 *
		 * Find all video post formats and remove the entry-content if empty.
		 * Because the video is posted in the content area, the entry-content
		 * div container is displayed because the content is technically not empty.
		 */ 
		$( '.entry-content', this ).filter( function() {
    	    return $.trim($(this).text()) === ''
    	}).remove()
	});
	

/*-----------------------------------------------------------------------------------*/
/*	FitVides (FitVids.js)
/*-----------------------------------------------------------------------------------*/
	$('.player').fitVids({ 
		customSelector: "iframe[src^='http://dailymotion.com'], embed[src^='http://v.wordpress.com']"
	});

	
		
	
/*-----------------------------------------------------------------------------------*/
/*	Popup (sharing buttons)
/*-----------------------------------------------------------------------------------*/
	$('.popup').click(function(event) {
	    var width  = 550,
	        height = 420,
	        left   = ($(window).width()  - width)  / 2,
	        top    = ($(window).height() - height) / 2,
	        url    = this.href,
	        opts   = 'status=1' +
	                 ',width='  + width  +
	                 ',height=' + height +
	                 ',top='    + top    +
	                 ',left='   + left;
	    
	    window.open(url, 'share', opts);
	 
	    return false;
	});
	
	
/*-----------------------------------------------------------------------------------*/
/*	Filter Effects
/*-----------------------------------------------------------------------------------*/
	var filterLink = $('#filter a');
	filterLink.click( function() {
	
		$('li.post-event').removeClass('inactive');
		
		filterLink.not(this).removeClass('active');
		$(this).addClass('active');
		
		var activeCat = $(this).data('event-slug');
		
		console.log(activeCat);
		
		$('li.post-event').not('li.'+ activeCat).not('li.past.post-event').addClass('inactive').children().stop(true,true).animate({opacity:".2"},350);
		$('li.'+ activeCat).children().stop(true,true).animate({opacity:"1"},350);
		
		return false;
	});


/*-----------------------------------------------------------------------------------*/
/*	Dropdowns
/*-----------------------------------------------------------------------------------*/
	$('.dropdown dt a').click(function(e) {
		e.preventDefault();
	    $('.dropdown dd ul').toggle();
	});
	            
	$('.dropdown dd ul li a').click(function() {
	    var text = $(this).html();
	    $('.dropdown dt a span').html(text);
	    $('.dropdown dd ul').hide();
	});
	            
	$(document).bind('click', function(e) {
	    var $clicked = $(e.target);
	    if (! $clicked.parents().hasClass('dropdown'))
	        $('.dropdown dd ul').hide();
	});
	
	
/*-----------------------------------------------------------------------------------*/
/*	Responsive Menus
/*-----------------------------------------------------------------------------------*/
	$('#primary-nav .nav').mobileMenu();

	if ( 'Opera' != BrowserDetect.browser ) {
		$('select.select-menu').each(function() {
	        var title = $(this).attr('title');
	        if( $('option:selected', this).val() != ''  ) title = $('option:selected', this).text();
	        $(this)
	        	.css({'z-index':10,'opacity':0,'-khtml-appearance':'none'})
	            .after('<span class="select">' + title + '</span>')
	            .change(function() {
					val = $('option:selected',this).text();
					$(this).next().text(val);
				})
		});
	};	

	
/*-----------------------------------------------------------------------------------*/
/*	Smoothscroll
/*-----------------------------------------------------------------------------------*/
	$("a[href*=#]").click(function() {
		if(location.pathname.replace(/^\//,"")==this.pathname.replace(/^\//,"")&&location.hostname==this.hostname) {
			var a = $(this.hash);
			a = a.length&&a||$("[name="+this.hash.slice(1)+"]");
			
			if(a.length){
				var b = a.offset().top;
				$("html,body").animate({
					scrollTop:b
				}, 1e3);
				return false
			}
		}
	});
	
	
/*-----------------------------------------------------------------------------------*/
/*	Post & Attachement Navigation Filter
/*-----------------------------------------------------------------------------------*/
	$('#single-navigation a').attr('href', function() {
	  return this.href + '#site-info'
	});
	
	
/*-----------------------------------------------------------------------------------*/
/*	Vimeo Feed Widget & Shortcode
/*-----------------------------------------------------------------------------------*/
	$('.vimeo.feed li').each( function() {
		$('p:not(:first-child)', this).remove();
	});
	
	
/*-----------------------------------------------------------------------------------*/
/*	YouTube Feed Widget & Shortcode
/*-----------------------------------------------------------------------------------*/
	$('.youtube.feed li').each( function() {
		var image = $('table tr:first-child td:first-child', this).html();
		$('div:first-child:not(.inner)', this).remove();
		$('div.inner', this).append(image);
	});
	
});

