<?php

/**
 * Initializes and loads up theme options. Uses the Struts option framework.
 * See https://github.com/jestro/struts
 */
if ( ! function_exists( 'hoon_options_init' ) ) :
function hoon_options_init() {
/**
 * Options Setup (struts)
 *
 */
	locate_template( '/includes/options/classes/struts.php', true );

	Struts::load_config( array(
		'struts_root_uri' => get_template_directory_uri() . '/includes/options', // required, set this to the URI of the root Struts directory
		'use_struts_skin' => true, // optional, overrides the Settings API html output
	) );
	

/**
 * Theme Options
 *
 */
	global $hoon_options;
	$hoon_options = new Struts_Options( 'hoon_options', 'hoon_options', 'Theme Options' );
	
	/* Sections */
	$hoon_options->add_section( 'logo_section', __( 'Logo and Background', 'hoon' ) );
	$hoon_options->add_section( 'display_section', __( 'Content Display', 'hoon' ) );
	$hoon_options->add_section( 'sharing_section', __( 'Sharing', 'hoon' ) );
	$hoon_options->add_section( 'audio_section', __( 'Audio', 'hoon' ) );
	$hoon_options->add_section( 'gallery_section', __( 'Galleries', 'hoon' ) );
	$hoon_options->add_section( 'image_section', __( 'Images', 'hoon' ) );
	$hoon_options->add_section( 'events_section', __( 'Events', 'hoon' ) );
	$hoon_options->add_section( 'footer_section', __( 'Footer', 'hoon' ) );
	
	/* Logo */
	$hoon_options->add_option( 'logo_url', 'image', 'logo_section' )
		->label( __( 'Logo URL:', 'hoon' ) )
		->description( __( 'Your image can be any width and height.', 'hoon' ) );
		
	$hoon_options->add_option( 'text_logo_desc', 'checkbox', 'logo_section' )
		->label( __( 'Enable Site Tagline', 'hoon' ) )
		->description( __( 'Display your site tagline beneath your text/image based logo.', 'hoon' ) );
	
	$hoon_options->add_option( 'responsive_bg', 'checkbox', 'logo_section' )
		->label( __( 'Responsive-ish Background Image', 'hoon' ) )
		->description( 
			sprintf( __( 'Attempt to make your %s responsive', 'hoon' ),
				sprintf( '<a href="%1$s" title="%2$s">%3$s</a>',
					esc_url( admin_url( 'themes.php?page=custom-background' ) ),
					esc_attr( 'Link to admin background image settings' ),
					esc_attr( 'background image' )
				)
			)
		);
		
	/* Display */
	$hoon_options->add_option( 'main_width', 'select', 'display_section' )
        ->label( __( 'Main Content Width', 'hoon' ) )
		->description( __( 'Make the main content width wider.', 'hoon' ) )
        ->valid_values( array(
            'default' => __( 'Default', 'hoon' ),
            'wide'    => __( 'Wide', 'hoon' ),
            'wider'   => __( 'Wider', 'hoon' ),
			'widest'  => __( 'Widest', 'hoon' ) ) );
			
	$hoon_options->add_option( 'top_search_form', 'checkbox', 'display_section' )
		->label( __( 'Top Search Form', 'hoon' ) )
		->description( __( 'Display a search form at the top of page.', 'hoon' ) );
	
	$hoon_options->add_option( 'post_meta_active_tab', 'select', 'display_section' )
        ->label( __( 'Active Post Meta Tab', 'hoon' ) )
		->description( __( 'If available, choose a post meta tab to be active.', 'hoon' ) )
        ->valid_values( array(
            ''         => __( 'None', 'hoon' ),
            'author'   => __( 'Author Info', 'hoon' ),
            'related'  => __( 'Related Posts', 'hoon' ),
            'popular'  => __( 'Popular Posts', 'hoon' ),
			'comments' => __( 'Comments', 'hoon' ) ) );
	
	$hoon_options->add_option( 'post_author_meta', 'checkbox', 'display_section' )
		->label( __( 'Hide Author Meta', 'hoon' ) )
		->description( __( 'Hides the Author meta information', 'hoon' ) );
	
	$hoon_options->add_option( 'post_comments_meta', 'checkbox', 'display_section' )
		->label( __( 'Hide Comments Meta', 'hoon' ) )
		->description( __( 'Hides Comments meta information.', 'hoon' ) );
	
	$hoon_options->add_option( 'post_related_meta', 'checkbox', 'display_section' )
		->label( __( 'Hide Related Posts Meta', 'hoon' ) )
		->description( __( 'Hides Related Posts meta information', 'hoon' ) );
	
	$hoon_options->add_option( 'post_popular_meta', 'checkbox', 'display_section' )
		->label( __( 'Hide Popular Posts Meta', 'hoon' ) )
		->description( __( 'Hides Popular Posts meta information', 'hoon' ) );
	
	/* Events */
	$hoon_options->add_option( 'events_category', 'text', 'events_section' )
		->label( __( 'Events: Category ID', 'hoon' ) )
		->description( __( 'Insert the category ID of the parent category in which should be used for display events.', 'hoon' ) );
		
	/* Sharing */
	$hoon_options->add_option( 'like_it_up', 'checkbox', 'sharing_section' )
		->label( __( 'Enable "Like It Up"', 'hoon' ) )
		->description( __( 'Displays an option (heart) for users to like a post.', 'hoon' ) );
	
	$hoon_options->add_option( 'share_on_twitter', 'checkbox', 'sharing_section' )
		->label( __( 'Share On Twitter', 'hoon' ) )
		->description( __( 'Displays an icon to share on Twitter.', 'hoon' ) );
	
	$hoon_options->add_option( 'share_on_facebook', 'checkbox', 'sharing_section' )
		->label( __( 'Share On Facebook', 'hoon' ) )
		->description( __( 'Displays an icon to share on Facebook.', 'hoon' ) );
	
	$hoon_options->add_option( 'share_on_google', 'checkbox', 'sharing_section' )
		->label( __( 'Share On Google+', 'hoon' ) )
		->description( __( 'Displays an icon to share on Google+.', 'hoon' ) );
	
	
	/* Audio Options */
	$hoon_options->add_option( 'audio_artwork_animate_spin', 'checkbox', 'audio_section' )
		->label( __( 'Fancy Artwork', 'hoon' ) )
		->description( __( 'Make the current playing album artwork round and spin while playing.', 'hoon' ) );
		
	$hoon_options->add_option( 'audio_single_autoplay', 'checkbox', 'audio_section' )
		->label( __( 'Autoplay: Single Audio Players', 'hoon' ) )
		->description( __( 'Autoplay audio for individual audio players. (single post pages only)', 'hoon' ) );
	
	$hoon_options->add_option( 'audio_gallery_autoplay', 'checkbox', 'audio_section' )
		->label( __( 'Autoplay: Audio Gallery Page Template', 'hoon' ) )
		->description( __( 'Autoplay audio on Audio Gallery Page Templates.', 'hoon' ) );
	
	$hoon_options->add_option( 'audio_single_playlist', 'checkbox', 'audio_section' )
		->label( __( 'Playlist: Single Audio Players', 'hoon' ) )
		->description( __( 'Show playlist by default for individual audio players.', 'hoon' ) );
	
	$hoon_options->add_option( 'audio_gallery_playlist', 'checkbox', 'audio_section' )
		->label( __( 'Playlist: Audio Gallery Page Template', 'hoon' ) )
		->description( __( 'Show playlist by default for the Audio Gallery Page Templates.', 'hoon' ) );
	
	
	/* Gallery & Slideshow Options */
	$hoon_options->add_option( 'slideshow_auto', 'checkbox', 'gallery_section' )
		->label( __( 'Automatic Slideshow - Creation', 'hoon' ) )
		->description( __( 'Yes, enable galleries to automatically be created for posts with a "Gallery" post format.', 'hoon' ) );

	$hoon_options->add_option( 'slideshow_auto_links', 'select', 'gallery_section' )
        ->label( __( 'Automatic Slideshow - Image Links', 'hoon' ) )
		->description( __( 'Where should gallery images be linked to?', 'hoon' ) )
        ->default_value( 'none' )
        ->valid_values( array(
            'none'        => __( 'Do not link', 'hoon' ),
            'lightbox'        => __( 'Lightbox', 'hoon' ),
            'file'        => __( 'Image', 'hoon' ),
            'attachement' => __( 'Attachement', 'hoon' )
		) );
		
	$hoon_options->add_option( 'slideshow_auto_carousel', 'select', 'gallery_section' )
        ->label( __( 'Automatic Slideshow - Thumbnail Carousel', 'hoon' ) )
		->description( __( 'Where should the thumbnail carousel be displayed?', 'hoon' ) )
        ->default_value( 'none' )
        ->valid_values( array(
            'none'   => __( 'Do not show', 'hoon' ),
            'top'    => __( 'Top', 'hoon' ),
            'bottom' => __( 'Bottom', 'hoon' )
		) );
            
	$hoon_options->add_option( 'slideshow', 'checkbox', 'gallery_section' )
		->label( __( 'Enable Slideshow', 'hoon' ) )
		->description( __( 'Enable slideshow (auto advance).', 'hoon' ) );

	$hoon_options->add_option( 'slideshow_animation', 'select', 'gallery_section' )
        ->label( __( 'Slide Animation', 'hoon' ) )
		->description( __( 'Choose a type of animation for each slide transition.', 'hoon' ) )
        ->default_value( 'slide' )
        ->valid_values( array(
            'slide' => __( 'Slide', 'hoon' ),
            'fade'  => __( 'Fade', 'hoon' ) ) );
	
	$hoon_options->add_option( 'slideshow_animation_duration', 'text', 'gallery_section' )
		->label( __( 'Slide Animation Speed', 'hoon' ) )
		->description( __( 'Speed (in seconds) at which the slides will animate between transitions.', 'hoon' ) )
        ->default_value( 1 );

	$hoon_options->add_option( 'slideshow_speed', 'text', 'gallery_section' )
		->label( __( 'Slideshow Speed', 'hoon' ) )
		->description( __( 'Time (in seconds) before transitioning to the next slide.', 'hoon' ) )
        ->default_value( 6 );
        
	
	/* Images Options */
	$hoon_options->add_option( 'image_featured_links', 'select', 'image_section' )
        ->label( __( 'Featured Image Links', 'hoon' ) )
		->description( __( 'Where should the Featured Images be linked to?', 'hoon' ) )
        ->default_value( 'none' )
        ->valid_values( array(
            'none' => __( 'Do not link', 'hoon' ),
            'view' => __( 'Lightbox', 'hoon' ),
            'file' => __( 'Image', 'hoon' ),
            'post' => __( 'Post', 'hoon' )
		) );
	
	
	/* Footer Options */
	$hoon_options->add_option( 'footer_text', 'textarea', 'footer_section' )
		->label( __( 'Footer Text', 'hoon' ) )
		->description( __( 'Set the text to be displayed in the footer.', 'hoon' ) );
	
	$hoon_options->initialize();
	
	
/**
 * Theme Styles
 *
 */
	global $hoon_styles;
	
	$hoon_styles = new Struts_Options( 'hoon_styles', 'hoon_styles', 'Theme Styles' );
	
	/* Sections */
	$hoon_styles->add_section( 'enable_section', __( '* Color Palette *', 'hoon' ) );
	$hoon_styles->add_section( 'general_color_section', __( 'General Colors', 'hoon' ) );
	$hoon_styles->add_section( 'navigation_color_section', __( 'Navigation Colors', 'hoon' ) );
	$hoon_styles->add_section( 'css_section', __( 'Custom CSS', 'hoon' ) );
	
	
	/* Enable Styles */
	$hoon_styles->add_option( 'color_palette', 'select', 'enable_section' )
        ->label( __( 'Color Palette', 'hoon' ) )
		->description( __( 'Choose a color palette.', 'hoon' ) )
        ->default_value( 'default' )
        ->valid_values( array(
            'default'   => __( 'Default', 'hoon' ),
			'custom' => __( 'Custom', 'hoon' )
        ) );
        
    
    /* General Color Section */
	$hoon_styles->add_option( 'logo_color', 'color', 'general_color_section' )
		->label( __( 'Logo Color', 'hoon' ) )
		->description( __( 'Text color of a text based logo and description.', 'hoon' ) )
		->default_value( '#333333' );
		
	$hoon_styles->add_option( 'accent_color', 'color', 'general_color_section' )
		->label( __( 'Accent Color', 'hoon' ) )
		->description( __( 'The accent color applies to various elements throughout the theme. (e.g. links, borders, progress bars, etc)', 'hoon' ) )
		->default_value( '#008080' );
		
	        
    /* Navigation Color Section */
	$hoon_styles->add_option( 'nav_background', 'color', 'navigation_color_section' )
		->label( __( 'Background Color', 'hoon' ) )
		->description( __( 'Background color of main nav bar.', 'hoon' ) )
		->default_value( '#222222' );
		
	$hoon_styles->add_option( 'nav_background_hover', 'color', 'navigation_color_section' )
		->label( __( 'Background Color (hover)', 'hoon' ) )
		->description( __( 'Nav item hover background color.', 'hoon' ) )
		->default_value( '#050505' );
		
	$hoon_styles->add_option( 'nav_border_color', 'color', 'navigation_color_section' )
		->label( __( 'Border Color ', 'hoon' ) )
		->description( __( 'Bottom border color.', 'hoon' ) )
		->default_value( '#555555' );
	
	$hoon_styles->add_option( 'nav_link_color', 'color', 'navigation_color_section' )
		->label( __( 'Link Color.', 'hoon' ) )
		->description( __( 'Link color for nav items.', 'hoon' ) )
		->default_value( '#e3e3e3' );
	
	$hoon_styles->add_option( 'nav_link_color_hover', 'color', 'navigation_color_section' )
		->label( __( 'Link Color (hover)', 'hoon' ) )
		->description( __( 'Link color for nav items.', 'hoon' ) )
		->default_value( '#ffffff' );
		
	
    /* Custom CSS Section */
	$hoon_styles->add_option( 'custom_css_code', 'textarea', 'css_section' )
		->label( __( 'Quick CSS Code', 'hoon' ) );
		
	$hoon_styles->initialize();
	
}
endif; // hoon_options_init


/**
 * Get the value of a theme option
 * 
 */
if ( ! function_exists( 'hoon_option' ) ) :
function hoon_option( $option_name, $default = false ) {
	global $hoon_options;

	$option = $hoon_options->get_value( $option_name );

	if ( isset( $option ) && ! empty( $option ) ) {
		return $option;
	}

	return $default;
}
endif;


/**
 * Get the value of a theme style option
 * 
 */
if ( ! function_exists( 'hoon_style' ) ) :
function hoon_style( $option_name, $default = false ) {
	global $hoon_styles;

	$option = $hoon_styles->get_value( $option_name );

	if ( isset( $option ) && ! empty( $option ) ) {
		return $option;
	}

	return $default;
}
endif;


/**
 * Get Category list and return array of category ID and Name
 *
 */
function hoon_get_category_list() {
	// Pull all the categories into an array
	$list = array();  
	$categories = get_categories();
	$list[''] = __( 'Select a category:', 'hoon' );
	
	foreach ( (array) $categories as $category )
	    $list[$category->cat_ID] = $category->cat_name;
	
	return $list;
}

?>