<?php
/**
 * Functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * @package WordPress
 * @subpackage Hoon
 * @since 1.0
 */

/**
 * Create "non-cachable" version ID. 
 * Helpful for caching issues in development.
 *
 * @return int
 * @since 1.0
 */
define( 'VERSION', '1.2.1' );

function hoon_version_id() {

	if ( WP_DEBUG )
		return time();
		
	return VERSION;
	
}


/**
 * Theme Setup
 *
 * If you would like to customize the theme setup you
 * are encouraged to adopt the following process.
 *
 * <ol>
 * <li>Create a child theme with a functions.php file.</li>
 * <li>Create a new function named mytheme_setup().</li>
 * <li>Hook this function into the 'after_setup_theme' action at or after 11.</li>
 * <li>call remove_filter(), remove_action() and/or remove_theme_support() as needed.</li>
 * </ol>
 *
 * @return void
 * @since 1.0
 */
function hoon_setup_hoon() {

	// Include cusotm styles
	locate_template( 'style-custom.php', true );
	
	// Text domain setup
	load_theme_textdomain( 'hoon', get_template_directory() . '/languages' );
	
	// Add editor styles
	add_editor_style( 'stylesheets/style-editor.css' );
	
	// Add page excrpt
	add_post_type_support( 'page', 'excerpt' );
	
	// Add automatic feed links in header
	add_theme_support( 'automatic-feed-links' );
	
	// Add custom background support
	add_theme_support( 'custom-background', array(
		'wp-head-callback' => 'hoon_add_custom_background_callback'
	) );
			
	// Add support for post formats
	add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'status', 'quote', 'video' ) );
	
	// Post Thumbnail Image sizes and support
	add_theme_support( 'post-thumbnails' );
	
	// Set post thumbnail size
	set_post_thumbnail_size( 200, 200, true );
	
	// Add themes custom image sizes
	add_image_size( 'theme-default', 675, 999, false );
	add_image_size( 'theme-wide',    753, 999, false );
	add_image_size( 'theme-wider',   831, 999, false );
	add_image_size( 'theme-widest',  910, 999, false );
	
	add_image_size( 'theme-default-crop', 675, 450, true );
	add_image_size( 'theme-wide-crop',    753, 502, true );
	add_image_size( 'theme-wider-crop',   831, 554, true );
	add_image_size( 'theme-widest-crop',  910, 607, true );
	
	// Add support for navigation menus and register menus
	add_theme_support( 'menus' );
	register_nav_menus( array(
		'primary-nav' => __( 'Primary Menu', 'hoon' ),
	));
	
	// Audio Track Details
	locate_template( 'includes/audio-track-details.php', true );
	
	// Load custom shortcodes
	locate_template( 'includes/shortcodes/delicious.php', true );
	locate_template( 'includes/shortcodes/dribbble.php', true );
	locate_template( 'includes/shortcodes/rss.php', true );
	locate_template( 'includes/shortcodes/flickr.php', true );
	locate_template( 'includes/shortcodes/lastfm.php', true );
	locate_template( 'includes/shortcodes/posts.php', true );
	locate_template( 'includes/shortcodes/twitter.php', true );
	locate_template( 'includes/shortcodes/vimeo.php', true );
	locate_template( 'includes/shortcodes/youtube.php', true );

	// Load custom widgets
	locate_template( 'includes/widgets/delicious.php', true );
	locate_template( 'includes/widgets/dribbble.php', true );
	locate_template( 'includes/widgets/rss.php', true );
	locate_template( 'includes/widgets/flickr.php', true );
	locate_template( 'includes/widgets/lastfm.php', true );
	locate_template( 'includes/widgets/posts.php', true );
	locate_template( 'includes/widgets/twitter.php', true );
	locate_template( 'includes/widgets/vimeo.php', true );
	locate_template( 'includes/widgets/youtube.php', true );
	
	// Video Hooks
	add_filter( 'embed_defaults',        'hoon_embed_defaults' );
	add_filter( 'embed_oembed_html',     'hoon_embed_html', 10, 2 );
	
	// Other WordPress hooks
	add_action( 'admin_enqueue_scripts', 'hoon_admin_scripts', 10, 1 );
	add_filter( 'body_class',            'hoon_add_body_classes' );
	add_filter( 'comment_form_defaults', 'hoon_comment_form_defaults' );
	add_filter( 'comment_post_redirect', 'hoon_comment_post_redirect' );
	add_filter( 'excerpt_length',        'hoon_excerpt_length' );
	add_filter( 'excerpt_more',          'hoon_excerpt_more' );
	add_filter( 'post_class',            'hoon_add_post_classes' );
	add_filter( 'post_gallery',          'hoon_gallery_display', 10, 2 ); // Filter [gallery] display
	add_filter( 'post_link',             'hoon_post_link_filter', 10, 2 );
	add_filter( 'the_title',             'hoon_post_title_filter', 10, 1 );
	add_action( 'widgets_init',          'hoon_register_sidebars' );
	add_action( 'wp_head',               'hoon_print_custom_logo_styles', 11, 1 );
	add_action( 'wp_head',               'hoon_print_custom_option_styles', 11, 2 );
	add_filter( 'wp_title',              'hoon_wp_title' );
	
	add_action( 'wp_enqueue_scripts',    'hoon_theme_styles' );
	add_action( 'wp_enqueue_scripts',    'hoon_theme_scripts' );
	add_action( 'wp_enqueue_scripts',    'hoon_localize_background' );
	add_action( 'wp_enqueue_scripts',    'hoon_localize_slideshow' );
	add_action( 'wp_enqueue_scripts',    'hoon_localize_jplayer' );
	add_action( 'wp_enqueue_scripts',    'hoon_localize_view' ); // Get images for view.js lightbox
	
	/* Filter the gallery images with user options. */
	add_filter( 'hoon_gallery_image', 'hoon_gallery_image', 10, 4 );
	
	/* Like It Up */
	locate_template( 'includes/like-it-up/like-it-up.php', true );

	/* Initialize theme options */
	locate_template( 'options.php', true );
	hoon_options_init();
	
}

add_action( 'after_setup_theme', 'hoon_setup_hoon' );


/* Include Custom Metaboxes (WPAlchemy) */
include_once 'includes/metaboxes/metaboxes.php';


/**
 * Set content width based on if the page has a sidebar
 *
 * @since 4.0
 */
function hoon_set_content_width() {

	global $content_width;
	
	if ( ! isset( $content_width ) ) {
		switch ( $content_width ) :
			
			case 'wide' :
				$content_width = 637;
				break;
			
			case 'wider' :
				$content_width = 705;
				break;
			
			case 'widest' :
				$content_width = 776;
				break;
			
			default :
				$content_width = 645;
				break;
			
		endswitch;
	}
}

add_action( 'template_redirect', 'hoon_set_content_width' );



/**
 * Main Content Width 
 *
 * Set the main content width by number of columns
 *
 * @return string Column number name that will be used as a class value
 * @since 1.0
 */
function hoon_main_column_width( $columns = null ) {
	
	$columns = ( null === $columns ) ? hoon_get_main_column_width() : $columns;
	
	return $columns . ' columns centered';
	
}

function hoon_get_main_column_width() {
	
	$main_width = hoon_option( 'main_width' );
	
	switch ( $main_width ) :
		
		case 'wide' :
			return 'ten';
			break;
		
		case 'wider' :
			return 'eleven';
			break;
		
		case 'widest' :
			return 'twelve';
			break;
		
		default :
			return 'nine';
			break;
		
	endswitch;

}


function hoon_get_image_size( $crop = false ) {
	
	$size = 'theme-' . hoon_option( 'main_width', 'default' );

	return $crop ? $size . '-crop' : $size;

}



/**
 * Filter WP Title 
 *
 * Filter the title depending upon the page.
 *
 * @since 1.0
 */
function hoon_wp_title() {

	$sep = '&nbsp;&mdash;&nbsp;';
	$title = '%1$s' . $sep . '%2$s';

	if ( is_home() )
		printf( esc_html( $title ), get_bloginfo( 'name' ), get_bloginfo( 'description' ) );
	elseif ( is_search() )
		printf( esc_html( $title ), get_bloginfo( 'name' ), __( 'Search Results', 'hoon' ) );
	elseif ( is_author() )
		printf( esc_html( $title ), get_bloginfo( 'name' ), __( 'Author Archives', 'hoon' ) );
	elseif ( is_single() )
		printf( esc_html( $title ), the_title( '', '', false ), get_bloginfo( 'name' ) );
	elseif ( is_page() )
		printf( esc_html( $title ), get_bloginfo( 'name' ), the_title( '', '', false ) );
	elseif ( is_category() )
		printf( esc_html( $title ), get_bloginfo( 'name' ), __( 'Archive', 'hoon' ) . $sep . single_cat_title( '', false ) );
	elseif ( is_month() )
		printf( esc_html( $title ), get_bloginfo( 'name' ), __( 'Archive', 'hoon' ) . $sep . the_time( 'F' ) );
	elseif ( is_tag() )
		printf( esc_html( $title ), get_bloginfo( 'name' ), __( 'Tag Archive', 'hoon' ) . $sep . single_tag_title( '', false ) );
	else 
		print '';
		
}


/**
 * Display Future Posts
 *
 * Display future post in the events category to all users.
 */
add_filter( 'the_posts', 'hoon_show_all_future_posts' );

function hoon_show_all_future_posts( $posts ) {

	global $wp_query, $wpdb;

	if ( is_single() && $wp_query->post_count == 0 ) {
		$events_cat = hoon_option( 'events_category' );
		$request = $wpdb->get_results( $wp_query->request );
			
  		if ( post_is_in_descendant_category( $events_cat, $request[0]->ID ) || in_category( $events_cat, $request[0]->ID ) ) {
			$posts = $request;
		}
	}
	
	return $posts;
	
}


/**
 * Post In Descendant Category
 *
 * Check if post is a decendent of the parent category
 */
function post_is_in_descendant_category( $cats, $_post = null ) {
	
	foreach ( (array) $cats as $cat ) {
		$descendants = get_term_children( (int) $cat, 'category');
		if ( $descendants && in_category( $descendants, $_post ) )
			return true;
	}
	
	return false;
	
}


/**
 * Multiple Post Page
 *
 * Checking to see if page type may contain multiple posts
 *
 * @since 1.8
 */
function hoon_is_multiple() {
	
	global $wp_query;

	if ( is_page_template( 'template-blog.php' ) || is_category() || is_search() || is_archive() || is_home() || $wp_query->is_posts_page  )
		return true;
	
	return false;
	
}



/**
 * Get Custom Post Meta
 *
 * This is a simple function to quickly access the
 * custom post meta. Custom post meta is setup
 * in includes/metaboxes.php
 */
function hoon_get_custom_post_meta( $ID = 0 ) {

	if ( 0 == $ID )
		$ID = get_the_ID();
	
	global $hoon_post_options;
	
	$meta = get_post_meta( get_the_ID(), $hoon_post_options->get_the_ID(), true );
	
	return $meta;
	
}


/**
 * Set Default Background Meta
 *
 * Here we look to gather the meta information set
 * for the post via a custom metabox.
 *
 * @returns array
 * @since 1.0
 */
function hoon_get_default_background_meta() {
	
	return array(
		'background_image'      => '',
		'background_color'      => '',
		'background_responsive' => ''
	);

}


/**
 * Custom Background Meta
 *
 * Here we look to gather the meta information set
 * for the post via a custom metabox.
 *
 * @param $args an array of options
 * @returns array
 * @since 1.0
 */
function hoon_get_custom_background_meta( $args = array() ) {
	
	$defaults = hoon_get_default_background_meta();
	$meta     = hoon_get_custom_post_meta();
	
	if ( is_array( $meta ) ) {
		foreach ( $meta as $option => $value ) {
			if ( array_key_exists( $option, $defaults ) ) {
				$args[$option] = $value;
			}
		}
	}
	
	return wp_parse_args( $args, $defaults );
	
}


/**
 * Default WP Background Meta
 *
 * Here we look to get the values set by WordPress
 * background feature. The responsive option is set
 * in the theme options, but we'll include that here too.
 *
 * @param $args an array of options
 * @returns array
 * @since 1.0
 */
function hoon_get_wp_background_meta( $args = array() ) {
	
	$args = array(
		'background_image'      => get_background_image(),
		'background_color'      => get_background_color(),
		'background_responsive' => hoon_option( 'responsive_bg' )
	);
	
	return wp_parse_args( $args, hoon_get_default_background_meta() );
		
}


/**
 * Add Custom Background Callback
 *
 * Callback function for add_custom_background().
 * This function fixes the issue where the theme
 * declares a background image via style.css and
 * the color set in the add_custom_background()
 * option does not show.
 *
 * @return html css markup
 * @since 1.0
 */
function hoon_add_custom_background_callback() {
	
	// Don't check for custom post background on multiple post pages
	if ( is_singular() ) :
		/**
		 * Post Background Settings
		 *
		 * Check post for custom background image and
		 * color settings. These settings are set view
		 * a custom metabox.
		 */
		$meta = hoon_get_custom_background_meta();
		extract( $meta );
		
		if ( $background_image || $background_color ) {
			// If image and responsive, call custom background callback w/o image set so it doesn't show
			if ( $background_image && $background_responsive ) {
				return hoon_custom_background_cb( '', $background_color );
			} 
			// Call custom callback with image and color if set, the callback will know what to do with either
			else {
				return hoon_custom_background_cb( $background_image, $background_color );
			}
		}
		
		// Return early if post is set to responsive, 
		// this will be handled by hoon_localize_background 
		if ( $background_responsive ) {
			return;
		}
	endif; // end is_archive()
	
	/**
	 * Default WP Background Settings
	 *
	 * Check WordPress default background image and
	 * color settings. The responsive option is actually
	 * pulled from the Theme Options.
	 */
	$meta = hoon_get_wp_background_meta();
	extract( $meta );
	
	// Return early by calling the custom callback without an image, 
	// which will be handled by hoon_localize_background()
	if ( $background_responsive ) {
		return hoon_custom_background_cb( '', $background_color );
	}
	
	// Return early if background image is set as there is no need to display the bg color
	if ( ! empty( $background_image ) ) {
	    _custom_background_cb();
	    return;
	}
	
	// Return early if no background color set
	if ( empty( $background_color ) )
		return;
	
	// Set body background css
	$body_bg = sprintf( 'body { background: #%s !important; }', esc_html(  $background_color ) );
	
	// Print style tag and css to page
	printf( '<style type="text/css">%1$s</style>', trim( $body_bg ) );
}


/**
 * Modified WP Custom Background Callback
 *
 * Display a custom image as the background. Use the settings set
 * by WordPress custom Background options. This allows posts to
 * use a custom field to display a different bg image. This function
 * is used in hoon_add_custom_background_callback()
 */
function hoon_custom_background_cb( $custom_image = '', $custom_color = '' ) {

	$style = ! empty( $custom_color ) ? 'background-color: #' . strtolower( ltrim( $custom_color, '#' ) ) . ';' : '';

	if ( ! empty( $custom_image ) ) {
		$image = " background-image: url('$custom_image');";
		
		$repeat = get_theme_mod( 'background_repeat', 'repeat' );
		
		if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )
		    $repeat = 'repeat';
		
		$repeat = " background-repeat: $repeat;";
		
		$position = get_theme_mod( 'background_position_x', 'left' );
		
		if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )
		    $position = 'left';
		
		$position = " background-position: top $position;";
		
		$attachment = get_theme_mod( 'background_attachment', 'scroll' );
		
		if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )
		    $attachment = 'scroll';
		
		$attachment = " background-attachment: $attachment;";
		
		$style .= $style . $image . $repeat . $position . $attachment;			
	}
	
	printf( '<style type="text/css">body.custom-background { %1$s }</style>', trim( $style ) );

}


/**
 * Set Default Logo Meta
 *
 * Sets default options for a text logo's color
 *
 * @returns array
 * @since 1.0
 */
function hoon_get_custom_logo_meta() {
	
	$defaults = array(
		'site_title_color' => '',
	);
	
	return apply_filters( 'hoon_get_custom_logo_meta', $defaults );

}


/**
 * Print Custom Logo Styles
 *
 * Prints custom logo styles to head if set by post.
 *
 * @since 1.0
 */
function hoon_print_custom_logo_styles( $args = array() ) {
	
	$meta = hoon_get_custom_post_meta();
	
	if ( ! isset( $meta['site_title_color'] ) || empty( $meta['site_title_color'] ) )
		return;
		
	$defaults = hoon_get_custom_logo_meta();
		
	if ( $defaults['site_title_color'] == $meta['site_title_color'] )
		return;
	?>
	
	<style>
		/* Site Info Text Color */
		#site-title a,
		#site-title a:hover,
		#site-title a:visited,
		#site-description {
			color: <?php echo $meta['site_title_color']; ?>;
		}
	</style>
	
	<?php
}


/**
 * Print Custom Logo Styles
 *
 * Prints custom logo styles to head if set by post.
 *
 * @since 1.0
 */
function hoon_print_custom_option_styles() {
	
	if ( ( $custom_css_code = hoon_style( 'custom_css_code' ) ) ) {	?>
	
	<style>
		<?php print $custom_css_code; ?>
	</style>

<?php }
}


/**
 * Load Required Theme Styles
 *
 */
function hoon_theme_styles() {
	
	// Theme Options Color Palette
	$color_palette = hoon_style( 'color_palette', 'default' );
	
	// If set to custom, load default styles with it.
	if ( 'custom' == $color_palette ) {
		$color_palette = 'default';
	}

	wp_enqueue_style( 'hoon-base', get_template_directory_uri() . "/stylesheets/style-base.css", array(), hoon_version_id() );
	wp_enqueue_style( 'hoon-style', get_stylesheet_uri(), array(), hoon_version_id() );
	wp_enqueue_style( 'hoon-palette', get_template_directory_uri() . "/stylesheets/style-$color_palette.css", array(), hoon_version_id() );
	wp_enqueue_style( 'hoon-vollkron', 'http://fonts.googleapis.com/css?family=Vollkorn:400italic,700italic,400,700', array(), hoon_version_id() );

}


/**
 * Load Required Theme Scripts
 *
 */
function hoon_theme_scripts() {
	
	wp_enqueue_script( 'jquery' );
	
	wp_enqueue_script( 'hoon_plugins', get_template_directory_uri() . '/javascripts/plugins.js', array( 'jquery' ), hoon_version_id(), true );
	
	wp_enqueue_script( 'hoon_theme', get_template_directory_uri() . '/javascripts/theme.js', array( 'jquery' ), hoon_version_id(), true );
	
	if ( is_page_template( 'template-audio.php' ) ) :
		wp_enqueue_script( 'hoon_jplayer', get_template_directory_uri() . '/javascripts/jplayer.gallery.playlist.js', array( 'jquery', 'hoon_theme' ), hoon_version_id(), true );	
	else :
		wp_enqueue_script( 'hoon_jplayer', get_template_directory_uri() . '/javascripts/jplayer.single.playlist.js', array( 'jquery' ), hoon_version_id(), true );
	endif;	
	
	wp_enqueue_script( 'hoon_view', get_template_directory_uri() . '/javascripts/view.js', array( 'jquery' ), hoon_version_id() . '&view', true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
		
}


/**
 * Load Required Admin Theme Scripts
 *
 * Loads admin scripts for post pages. Function called by 
 * admin_enqueue_scripts hook in hoon_setup_hoon()
 *
 * @since 1.0
 */
function hoon_admin_scripts( $hook ) {
	
	if ( $hook == 'post.php' || $hook == 'post-new.php' ) {
		wp_enqueue_script( 'hoon_admin', get_template_directory_uri() . '/javascripts/admin.js', array( 'jquery' ), hoon_version_id(), true );
	}
	
}


/**
 * Localize Background Image (for Responsiveness)
 *
 * Set background image for localization. This value is 
 * used by Backstretch.js in javascripts/theme.js
 *
 * @since 1.0
 */
function hoon_localize_background( $args = array() ) {
	
	if ( ! hoon_is_multiple() ) {
		$meta = hoon_get_custom_background_meta();
		extract( $meta );
		
		if ( $background_image ) {
			if ( $background_responsive ) {
				$args = array(
				    'background_image' => esc_url( $background_image )
				);
			}
		} elseif ( $background_color ) {
			$args = array(
			    'background_color' => $background_color
			);
		}
	} else {
		$meta = hoon_get_wp_background_meta();
		extract( $meta );
		
		if( $background_responsive && $background_image ) {
		    $args = array(
		        'background_image' => esc_url( $background_image )
		    );
		}
	}
		
	// Parse arguments. If background_image is set above, it will be localized to
	// be used in JS. Otherwise, it will be empty and the value blank, but still available.
	$background = wp_parse_args( $args, array( 'background_image' => '' ) );
	
	wp_localize_script( 'hoon_theme', 'hoon_background_image', $background );

}


/**
 * Localize Slideshow
 *
 * Set Theme Option values for use in JS slideshow functionality
 *
 * @return void
 * @since 1.0
 */
function hoon_localize_slideshow() {
	
	$slideshow_options = array(
		'slideshow'          => hoon_option( 'slideshow', 0 ),
		'animation'          => hoon_option( 'slideshow_animation', 'fade' ),
		'animation_duration' => absint( hoon_option( 'slideshow_animation_duration', 1 ) ) * 1000,
		'slideshow_speed'    => absint( hoon_option( 'slideshow_speed', 6 ) ) * 1000
	);
	
	wp_localize_script( 'hoon_theme', 'hoon_slideshow_options', $slideshow_options );

}


/**
 * Localize jPlayer (audio)
 * 
 * Localize audio files found in post's gallery
 *
 * @return void
 * @since 1.0
 */
function hoon_localize_jplayer() {
	
	/**
	 * Audio Player Options
	 * 
	 * The next few tid bits get and set audio options from Theme Options 
	 */
	$options = array();
	
	/* Default options */
	$defaults = array(
		'enable_autoplay' => is_single() ? ( hoon_option( 'audio_single_autoplay' ) ? 1 : 0 ) : 0,
		'enable_playlist' => is_single() ? ( hoon_option( 'audio_single_playlist' ) ? 1 : 0 ) : 0
	);

	/* Set different options for Template: Audio */
	if ( is_page_template( 'template-audio.php' ) ) {
		$options = array(
			'enable_autoplay' => hoon_option( 'audio_gallery_autoplay' ) ? 1 : 0,
			'enable_playlist' => hoon_option( 'audio_gallery_playlist' ) ? 1 : 0
		);
	}
	
	/* Merge audio options */
	$options = wp_parse_args( $options, $defaults );
	
	/**
	 * Set Playlist
	 *
	 * Here we will query the audio post format posts.
	 * Before we do that, we'll check to see if we have
	 * done this previously by checking if a particular
	 * transient has been set. If not, we'll run the query
	 * and set the $tracks for the audio players.
	 */
	if ( false === ( $tracks = get_transient( 'hoon_audio_tracks' ) ) ) {
		/* Create playlist object array */
		$playlist = array();
		
		/* Set arguements to query audio post formats */
		$args = array(
		    'posts_per_page' => -1,
		    'post_status' => 'publish',
		    'tax_query' => array(
		    	array (
		    		'taxonomy' => 'post_format',
		    		'field' => 'slug',
		    		'terms' => 'post-format-audio'
		    	)
		  	)
		);
		
		/* Create new query from $args */
		$audio_query = new WP_Query( $args );
		
		/* Include audio class used to create and setup tracks */
		locate_template( 'includes/class-audio-tracks.php', true );
		
		/* Loop through posts and add tracks to the $playlist array */
		while ( $audio_query->have_posts() ) : 
			$audio_query->the_post();
			$post_id = get_the_ID();
			$audio = new Hoon_Audio( $post_id );
			$playlist['playlist'][$post_id] = $audio->tracks();
		endwhile;
		
		/* As it says… */
		wp_reset_postdata();
				
		/* JSON encode playlist */
		$tracks = json_encode( $playlist );
		
		/* Set transient with the $tracks data! */
		set_transient( 'hoon_audio_tracks', $tracks );
	}
	
	/* Set up param object for localization */
	$params = array(
	    'get_template_directory_uri' => get_template_directory_uri(),
	    'options' => $options,
        'format_audio' => $tracks
	);
	    
	/* Localize params to be used in JS */
	wp_localize_script(	'hoon_jplayer', 'jplayer_params', $params );

}


/**
 * Localize View.js (gallery lightbox). 
 * 
 * Localize gallery images for use in view.js
 *
 * @return void
 * @since 1.0
 */
function hoon_localize_view() {
	
	$gallery_sets = array();
	
	if ( is_page_template( 'template-galleries.php' ) || is_page_template( 'template-images-galleries.php' ) ) {
		if ( false === ( $galleries = get_transient( 'hoon_gallery_format_query' ) ) ) {
			$args = array(
			    'posts_per_page' => -1,
			    'tax_query' => array(
			    	array (
			    		'taxonomy' => 'post_format',
			    		'field' => 'slug',
			    		'terms' => 'post-format-gallery'
			    	)
			  	)
			);
			
    		$galleries = get_posts( $args );
    		
			/* Set transient with the $tracks data! */
			set_transient( 'hoon_gallery_format_query', $galleries );
    	} // end transient check

		global $post;
		
    	foreach ( $galleries as $post ) : 
    	    setup_postdata( $post );    	
		    /** Get images for post and add theme to $gallery */
		    if( $images = get_children( array(
		    	'post_parent'    => get_the_ID(),
		    	'post_type'      => 'attachment',
		    	'numberposts'    => -1,
		    	'post_status'    => null,
		    	'post_mime_type' => 'image',
		    	'order'          => 'ASC',
		    	'orderby'        => 'menu_order'
		    ) ) ) {
		    	$gallery = array();
		    	
		    	foreach ( (array) $images as $image ) {
		    		$image_src = wp_get_attachment_image_src( $image->ID, 'large' );
		    		
		    		$gallery[] = array(
		    			'src' => $image_src[0],
		    			'caption' => apply_filters( 'the_title', $image->post_title )
		    		);
		    	}
		    	
		    	$gallery_sets[get_the_ID()] = $gallery;
		    }		
    	endforeach;
    	
    	wp_reset_postdata();
	} // end page template check
	
	// JSON encode playlist
	$gallery_sets = json_encode( $gallery_sets );
	
	// Set up param object for localization
	$params = array(
        'gallery_views' => $gallery_sets
	);
	
	// Localize params to be used in JS
	wp_localize_script(	'hoon_view', 'gallery_params', $params );

}


/**
 * Delete Audio Tracks Transient
 *
 * Deletes audio tracks transient option when a post
 * is updated, edited, or published. This ensures that
 * if a new post was created or was updated
 * to be an Audio Post Format, it will be included in
 * in the results.
 *
 * @see hoon_localize_jplayer()
 * @return void
 * @since 1.0
 */
function hoon_audio_tracks_flusher() {

    delete_transient( 'hoon_audio_tracks' );

}

add_action( 'publish_post', 'hoon_audio_tracks_flusher' );
add_action( 'edit_post', 'hoon_audio_tracks_flusher' );


/**
 * Delete Gallery Format Query Transient
 *
 * Deletes the gallery sets transient option when a post
 * is updated, edited, or published. This ensures that
 * if a new post was created or was updated
 * to be an Gallery Post Format, it will be included in
 * in the results.
 *
 * @see hoon_localize_view()
 * @return void
 * @since 1.0
 */
function hoon_gallery_format_query_flusher() {

    delete_transient( 'hoon_gallery_format_query' );

}

add_action( 'publish_post', 'hoon_gallery_format_query_flusher' );
add_action( 'edit_post', 'hoon_gallery_format_query_flusher' );


/**
 * Arvhives Title
 *
 * Prints the title for the <h1> element on the archives page template
 *
 * @print html
 * @since 1.0
 */
if ( ! function_exists( 'hoon_archives_title' ) ) :
function hoon_archives_title() {
	
	if ( is_category() ) { /* If this is a category archive */
		printf( __( 'Posts from the <em>%s</em> Category', 'hoon' ), single_cat_title( '', false ) );
	} elseif ( is_tag() ) { /* If this is a tag archive */
		printf( __( 'Posts tagged <em>%s</em>', 'hoon' ), single_tag_title( '', false ) );
	} elseif ( is_day() ) { /* If this is a daily archive */
		printf( __( 'Archive for %s', 'hoon' ), get_the_time(  'F jS, Y', 'hoon' ) );
	} elseif ( is_month() ) { /* If this is a monthly archive */
		printf( __( 'Archive for %s', 'hoon' ), get_the_time(  'F, Y', 'hoon' ) );
	} elseif ( is_year() ) { /* If this is a yearly archive */
		printf( __( 'Archive for %s', 'hoon' ), get_the_time(  'Y', 'hoon' ) );
	} elseif ( is_author() ) { /* If this is an author archive */
		printf( __( 'Posts by %s', 'hoon' ), get_the_author() );
	} elseif ( is_paged() ) { /* If this is a paged archive */
		_e( 'Blog Archives', 'hoon' );
	}

}
endif; // hoon_archives_title


/**
 * Filter oEmbed HTML
 *
 * Adds a wrapper to videos from the whitelisted services and attempts to add
 * the wmode parameter to YouTube videos and flash embeds.
 *
 * @since 2.0.1
 * @return string
 */
function hoon_embed_html( $html, $url ) {
	
	$players = array( 'youtube', 'youtu.be', 'vimeo', 'dailymotion', 'hulu', 'blip.tv', 'wordpress.tv', 'viddler', 'revision3' );
	
	foreach ( $players as $player ) {
		if ( false !== strpos( $url, $player ) ) {
			if ( false !== strpos( $url, 'youtube' ) && false !== strpos( $html, '<iframe' ) && false === strpos( $html, 'wmode' ) ) {
				$html = preg_replace_callback( '|https?://[^"]+|im', 'hoon_oembed_youtube_wmode_parameter', $html );
			}
		
			$html = '<div class="wp-embed"><div class="player">' . $html . '</div></div>';
			break;
		}
	}
	
	if ( false !== strpos( $html, '<embed' ) && false === strpos( $html, 'wmode' ) ) {
		$html = str_replace( '</param><embed', '</param><param name="wmode" value="opaque"></param><embed wmode="opaque"', $html );
	}
	
	return $html;
	
}


/**
 * YouTube Wmode
 *
 * Add wmode=transparent to YouTube videos to fix z-indexing issue
 *
 * @since 2.0.1
 */
function hoon_oembed_youtube_wmode_parameter( $matches ) {
	
	return add_query_arg( 'wmode', 'transparent', $matches[0] );

}


/**
 * Embded Default Size
 * 
 * Set the defalut size for embed options
 *
 * @return array
 * @since 1.0
 */
function hoon_embed_defaults( $embed_size ) {
	
	$embed_size['width'] = 560;
	$embed_size['height'] = 350;
	
	return $embed_size;
	
}


/**
 * Additional Body Classes
 *
 * @param array All classes for the body element.
 * @return array Modified classes for the body element.
 * @since 1.0
 */
function hoon_add_body_classes( $classes ) {
	
	global $post;

	/* Add class for pages with multiple posts */
	if ( is_home() || is_archive() || is_search() || is_category() )
		$classes[] = 'multiple';
	
	/* Add main width body class */
	$classes[] = hoon_option( 'main_width', 'default' ) . '-main-width';	
		
	return array_unique( $classes );

}


/**
 * Additional Post Classes
 *
 * @param array All classes for the body element.
 * @return array Modified classes for the post element.
 * @since 1.0
 */
function hoon_add_post_classes( $classes ) {
	
	global $post, $page;
	
	if ( $post->post_excerpt )
		$classes[] = 'excerpt';
	else
		$classes[] = 'no-excerpt';
	
	if ( has_post_format( 'audio' ) && hoon_option( 'audio_artwork_animate_spin' ) )
		$classes[] = 'animate-spin';
	
	return array_unique( $classes );

}


/**
 * Custom Excerpt Length
 *
 * @since 1.0
 */
function hoon_excerpt_length( $length ) {

	return 24;
	
}


/**
 * Excerpt More (auto).
 *
 * @since 1.0
 */
function hoon_excerpt_more( $more ) {

	return ' &hellip;';
	
}


/**
 * Comment Callback Setup
 *
 * @since 1.0
 */
if ( ! function_exists( 'hoon_comment_callback' ) ) :
function hoon_comment_callback( $comment, $args, $depth ) {
	
	$GLOBALS['comment'] = $comment;	?>
	
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID(); ?>">
		
			<div class="seperation-border"></div>
		
			<div class="comment-head">
				
				<figure class="comment-author-avatar">
					<?php 
					$comment_author_url = get_comment_author_url(); 
					
					if ( ! empty( $comment_author_url ) ) {
						printf( 
							'<a href="%1$s" title="%2$s" target="_blank" rel="external nofollow">%3$s</a>',
							esc_url( $comment_author_url ),
							esc_attr( sprintf(
								'%1$s %2$s',
								__( 'Link to', 'hoon' ),
								get_comment_author()
							) ),
							get_avatar( $comment, '35' )
						);
					} else {
						echo get_avatar( $comment, '35' );
					}
					?>
				</figure>
				
				<div class="comment-meta">
	       			<cite class="comment-author-name"><?php echo get_comment_author_link() ?></cite>
					<time class="comment-date" pubdate="<?php echo esc_attr( get_comment_date( 'Y-m-d' ) ); ?>"><?php echo get_comment_date() ?></time>
					<?php 
					comment_reply_link( array_merge( $args, 
						array( 
							'depth' => $depth, 
							'max_depth' => $args['max_depth'],
							'before' => __( ' &middot; ', 'hoon' ),
							'reply_text' => __( ' Reply ', 'hoon' ),
						) 
					) );
					?>
					<?php echo edit_comment_link( ' Edit ', ' &middot; ' ); ?>
				</div>
				
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<p class="comment-moderation"><em><?php _e( 'Your comment is awaiting moderation.', 'hoon' ); ?></em></p>
				<?php endif; ?>
				
			</div>

			<div class="comment-body">
				<?php comment_text(); ?>
				<?php comment_type( ( '' ), ( 'Trackback' ), ( 'Pingback' ) ); ?>
			</div>
		</div>
<?php
}
endif;


/**
 * Pings Callback Setup
 *
 * @since 1.0
 */
if ( ! function_exists( 'hoon_pings_callback' ) ) :
function hoon_pings_callback( $comment, $args, $depth ) {
	
	$GLOBALS['comment'] = $comment; ?>
	
	<li class="ping" id="li-comment-<?php comment_ID(); ?>">
		<div class="seperation-border"></div>
		<?php comment_author_link(); ?>
		
	<?php
}
endif; // hoon_pings_callback


/**
 * Comment Form Redirect
 *
 * Adds a comment_posted query argument to url. 
 * This is used to later check if a comment has been posted,
 * which will then show the comments meta information,
 * overriding any option for default meta display.
 *
 * Basically, show comments meta after a comment is posted, regardless.
 *
 * @since 1.2.0
 */ 
function hoon_comment_post_redirect( $location ) {
	
	return add_query_arg( 'comment_posted', 1, $location );

}


/**
 * Comment Posted?
 *
 * Checks to see if a comment has been posted.
 *
 * @since 1.2.0
 */
function hoon_comment_posted() {
	
	return ( isset( $_GET["comment_posted"] ) && 1 == $_GET["comment_posted"] ) ? true : false;
	
}


/**
 * Comment Form Defaults
 *
 * @since 1.0
 */
function hoon_comment_form_defaults() {

	$req = get_option( 'require_name_email' );
	
	$field = '<p class="comment-form-%1$s"><label for="%1$s" class="comment-field">%2$s</label><input class="text-input" type="text" name="%1$s" id="%1$s" size="22" placeholder="%3$s" tabindex="%4$d"/></p>';
	
	$fields = array(
		'author' => sprintf( $field,
			esc_attr( 'author' ),
			esc_html__( 'Name:', 'hoon' ),
			esc_attr__( $req ? __( '(required)', 'hoon' ) : '' ),
			5
		),
		'email' => sprintf( $field,
			esc_attr( 'email' ),
			esc_html__( 'Email:', 'hoon' ),
			esc_attr__( $req ? __( '(required) (never published', 'hoon' ) : '' ),
			6
		),
		'url' => sprintf( $field,
			esc_attr( 'url' ),
			esc_html__( 'Website:', 'hoon' ),
			esc_attr__( '(optional)', 'hoon' ),
			7
		)
	);
	
	$defaults = array(
		'id_form' => 'commentform',
		'id_submit' => 'submit',
		'label_submit' => __( 'Post Comment', 'hoon' ),
		'comment_field' => sprintf( 
			'<p class="comment-form-comment"><label for="comment" class="comment-field">%1$s</label><textarea id="comment" name="comment" rows="10" aria-required="true" tabindex="8" placeholder="%2$s"></textarea></p>',
			esc_html_x( 'Comment:', 'noun', 'hoon' ),
			esc_html__( 'Leave your comment here...', 'hoon' )
		),
		'comment_notes_before' => '',
		'comment_notes_after' => sprintf(
			'<p class="comments-rss"><a href="%1$s"><span>%3$s</span> %2$s</a></p>',
			esc_attr( get_post_comments_feed_link() ),
			esc_html__( 'Subscribe To Comment Feed', 'hoon' ),
			esc_html__( 'RSS', 'hoon' )
			
		),
		'logged_in_as' => '',
		'fields' => apply_filters( 'comment_form_default_fields', $fields ),
		'cancel_reply_link' => '<div class="cancel-comment-reply">' . esc_html__( 'Click here to cancel reply.', 'hoon' ) . '</div>',
		'title_reply' => esc_html__( 'Leave a Comment', 'hoon' ),
		'title_reply_to' => esc_html__( 'Leave a comment to %s', 'hoon' ),
	);

	return $defaults;
	
}


/**
 * Gallery Display
 *
 * Changes output of [gallery] shortcode in gallery-format posts to use FlexSlider.
 * Also will change output to use FlexSlider if [gallery slider="true"] is used on non-gallery-format post.
 *
 * @since 1.0
 */
if ( ! function_exists( 'hoon_gallery_display' ) ) :
function hoon_gallery_display( $output, $attr ) {
	
	global $post;
	
	static $gallery_instance = 0;
	$gallery_instance++;
	
	/* Ignore feed */
	if ( is_feed() )
		return $output;
		
	/* Orderby */
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}
	
	/* Get Post ID */
	$post_id = isset( $attr['id'] ) ? $attr['id'] : get_the_ID();
	
	$default_attr = array(
		'order' => 'ASC',
		'orderby' => 'menu_order ID',
		'id' => $post->ID,
		'link' => '',
		'itemtag' => 'dl',
		'icontag' => 'dt',
		'captiontag' => 'dd',
		'columns' => 3,
		'size' => 'post-thumbnail',
		'include' => '',
		'exclude' => '',
		'numberposts' => -1,
		'offset' => '',
		'slider' => 0, // theme specific
		'carousel' => '' // theme specific
	);
	
	/* Merge the defaults with user input. Make sure $id is an integer. */
	$attr = shortcode_atts( $default_attr, $attr );
	
	$attr['id'] = intval( $attr['id'] );

	/* Arguments for get_children(). */
	$children = array(
		'post_parent' => $attr['id'],
		'post_status' => 'inherit',
		'post_type' => 'attachment',
		'post_mime_type' => 'image',
		'order' => $attr['order'],
		'orderby' => $attr['orderby'],
		'exclude' => $attr['exclude'],
		'include' => $attr['include'],
		'numberposts' => $attr['numberposts'],
		'offset' => $attr['offset'],
	);
	
	/* Get image attachments. If none, return. */
	$attachments = get_children( $children );

	if ( empty( $attachments ) )
		return '';

	/* Properly escape the gallery tags. */
	$attr['itemtag'] = tag_escape( $attr['itemtag'] );
	$attr['icontag'] = tag_escape( $attr['icontag'] );
	$attr['captiontag'] = tag_escape( $attr['captiontag'] );
	
	$i = 0; // Counter for columns

	/* Count the number of attachments returned. */
	$attachment_count = count( $attachments );
	
	/* Allow developers to overwrite the number of columns. This can be useful for reducing columns with with fewer images than number of columns. */
	$columns = apply_filters( 'hoon_gallery_columns', intval( $attr['columns'] ), $attachment_count, $attr );
	
	if ( 1 == $attr['slider'] ) {
		$output = '';
		
		$output .= '<div class="flexslider-wrapper entry-media">';
		
			/* CAROUSEL */
			if ( 'top' == $attr['carousel'] ) {
			    $output .= hoon_get_flexslider_carousel( $attachments );
			}
			
			/* SLIDER */
		    $output .= '<div class="flexslider slider">';
		        $output .= '<ul class="slides">';
		        
		        foreach ( (array) $attachments as $attachement ) {
		            $image_src = wp_get_attachment_image_src( $attachement->ID, 'large' );
		            
		            if ( isset( $attr['link'] ) && ( 'lightbox' == $attr['link'] || 'file' == $attr['link'] ) ) {
		            	$link = $image_src[0];
		            } else {
		            	$link = get_attachment_link( $attachement->ID );
		            }
		            
		            $output .= '<li>';
		            	$output .= ( isset( $attr['link'] ) && 'none' != $attr['link'] ) ?
		            		sprintf( '<a href="%1$s" rel="gallery-%2$s-%3$s" class="%4$s" title="%5$s">',
		            			esc_url( $link ),
		            			esc_attr( absint( $attr['id'] ) ),
		            			esc_attr( absint( $gallery_instance ) ),
		            			esc_attr( 'lightbox' == $attr['link'] ? 'view' : $attr['link'] ),
		            			esc_attr( apply_filters( 'the_title', $attachement->post_title ) )
		            		) : '';
		            	$output .= wp_get_attachment_image( $attachement->ID, hoon_get_image_size( true ) );
		            	$output .= apply_filters( 'the_excerpt', $attachement->post_excerpt );
		            	$output .= ( isset( $attr['link'] ) && 'none' != $attr['link'] ) ? '</a>' : '';
		            $output .= '</li>';
		        } // end foreach
		        
		        $output .= '</ul>';
		    $output .= '</div><!-- .flexslider .carousel -->';
		    
		    /* CAROUSEL */
		    if ( 'bottom' == $attr['carousel'] ) {
		    	$output .= hoon_get_flexslider_carousel( $attachments );
		    }
		    
		$output .= '</div><!-- .flexslider-wrapper -->';
	} 
	// End slider attribute check
	else {
		/* Open the gallery <div>. */
		$output = sprintf( '<div id="gallery-%1$s" class="gallery galleryid-%2$s gallery-columns-%3$s gallery-size-%4$s">',
			esc_attr( absint( $gallery_instance ) ),
			esc_attr( absint( $attr['id'] ) ),
			esc_attr( absint( $attr['columns'] ) ),
			esc_attr( $attr['size'] )
		);
		
		/* Loop through each attachment. */
		foreach ( (array) $attachments as $id => $attachment ) {
			/* Add  to each row */
			$clearfix = ( $attr['columns'] > 0 && $i % $attr['columns'] == 0 ) ? 'clearfix' : '';
			
			/* Open each gallery item. */
			$output .= sprintf( '<%1$s class="gallery-item col-%2$s %3$s">', strip_tags( $attr['itemtag'] ), esc_attr( $attr['columns'] ), esc_attr( $clearfix ) );
				
			/* Open the element to wrap the image. */
			$output .= sprintf( '<%1$s class="gallery-icon">', strip_tags( $attr['icontag'] ) );
			
			/* Add the image. */
			$image = ( ( isset( $attr['link'] ) && ( 'file' == $attr['link'] || 'lightbox' == $attr['link'] ) ) ? wp_get_attachment_link( $id, $attr['size'], false, false ) : wp_get_attachment_link( $id, $attr['size'], true, false ) );
			$output .= apply_filters( 'hoon_gallery_image', $image, $id, $attr, $gallery_instance );
			
			/* Close the image wrapper. */
			$output .= sprintf( '</%1$s>', strip_tags( $attr['icontag'] ) );
			
			/* Get the caption. */
			$caption = apply_filters( 'hoon_gallery_caption', wptexturize( esc_html( $attachment->post_excerpt ) ), $id, $attr, $gallery_instance );
		
			/* If image caption is set. */
			if ( ! empty( $caption ) )
				$output .= sprintf( '<%1$s class="wp-caption-text gallery-caption hide-on-phones">%2$s<%1$s>', esc_attr( $attr['captiontag'] ), esc_html( $caption ) );
		
			/* Close individual gallery item. */
			$output .= sprintf( '</%1$s>', strip_tags( $attr['itemtag'] ) );
			
			++$i;
		}
		
		/* Close the gallery <div>. */
		$output .= "</div><!-- .gallery -->";
	}
	
	return $output;
	
}
endif; // hoon_gallery_display


/**
 * Flex Carousel HTML
 *
 * @since 1.2.0
 */
function hoon_get_flexslider_carousel( $attachments ) {
	
	$output = '<nav class="flexslider carousel">';
	    $output .= '<ul class="slides">';
	    foreach ( (array) $attachments as $id => $attachment ) {
	        $output .= sprintf( '<li>%s</li>', wp_get_attachment_image( absint( $id ), 'post-thumbnail' ) );
	    }
	    $output .= '</ul>';
	$output .= '</nav><!-- .flexslider .carousel -->';
	
	return $output;
	
}


/**
 * Gallery Image
 *
 * Modifies gallery images based on user-selected settings.
 *
 * @since 1.0
 */
function hoon_gallery_image( $image, $id, $attr, $instance ) {
	
	/* If the image should link to nothing, remove the image link. */
	if ( 'none' == $attr['link'] ) {
		$image = preg_replace( '/<a.*?>(.*?)<\/a>/', '$1', $image );
	}

	/* If the image should link to the 'file' (full-size image), add in extra link attributes. */
	elseif ( 'lightbox' == $attr['link'] ) {		
		$image = str_replace( '<a href=', sprintf( '<a %s href=', hoon_gallery_lightbox_attributes( $instance ) ), $image );
	}

	/* If the image should link to an intermediate-sized image, change the link attributes. */
	elseif ( in_array( $attr['link'], get_intermediate_image_sizes() ) ) {

		$post = get_post( $id );
		$image_src = wp_get_attachment_image_src( $id, $attr['link'] );

		$attributes = 'lightbox' == $attr['link'] ? hoon_gallery_lightbox_attributes( $instance ) : '';
		$attributes .= sprintf( ' href="%s"', $image_src[0] );
		$attributes .= sprintf( ' title="%s"', esc_attr( $post->post_title ) );

		$image = preg_replace( '/<a.*?>(.*?)<\/a>/', "<a{$attributes}>$1</a>", $image );
	}

	/* Return the formatted image. */
	return $image;
	
}


/**
 * Gallery Lightbox Attributes
 *
 * Add "view" class to enable view.js to function.
 * Also adds a unique rel attribute to associate
 * related iamges to display in view.js
 *
 * @see hoon_gallery_image()
 */
function hoon_gallery_lightbox_attributes( $instance ) {
	
	return sprintf( 'class="view" rel="gallery-%s"', esc_attr( $instance ) );

}


/**
 * Remove default gallery style
 *
 * Removes inline styles printed when the 
 * gallery shortcode is used.
 *
 * @since 1.0
 */
add_filter( 'use_default_gallery_style', '__return_false' );


/**
 * Active Meta Tab Class Name
 *
 * This function is called by each meta tab link to
 * check if it is suppose to be active. The active state
 * is set via the theme options. If it is not set, then
 * of the meta tabs and content are active/shown.
 * 
 * Each meta tab link has meta content. This function is
 * also used to get the "active" class name for the content.
 *
 * @return html
 * @since 1.0
 */
function hoon_is_active_meta_tab( $tab = '' ) {
	
	// If comment is posted...
	if ( hoon_comment_posted() ) {
		// make comments tab the active tab
		if ( $tab == 'comments' ) {
			return 'active';
		}
		
	// Comment not posted, so find out which tab should be active
	} else {
		if ( false === ( $option = get_transient( 'post_meta_active_tab' ) ) ) {
			$option = hoon_option( 'post_meta_active_tab' );
			set_transient( 'post_meta_active_tab', $option );
		}
			
		if ( $tab == $option ) {
			return 'active';
		}
	}
	
	// No active tabs
	return '';
	
}

/**
 * Delete Active Meta Tab Transient
 *
 * Delete transient data when Theme Options get updated
 *
 * @return void
 * @since 1.0
 */
function hoon_active_meta_tab_flusher() {
	
	delete_transient( 'post_meta_active_tab' );

}

add_action( 'update_option_hoon_options', 'hoon_active_meta_tab_flusher' );


/**
 * Author Meta Link
 *
 * Creates a link with the proper href ID. The HREF points
 * to a corresponding content ID container which is displayed
 * when switching tabs (via JS)
 *
 * @return string
 * @since 1.0
 */
function hoon_author_meta_link() {
	
	if ( is_page() ) 
		return;

	$author = array(
		'label' => 'Author',
		'value' => get_the_author_meta( 'display_name' ),
		'link'  => '#author-' . get_the_ID(),
		'desc'  => get_the_author_meta( 'description' ),
		'class' => hoon_is_active_meta_tab( 'author' )
	);
	
	if ( empty( $author['desc'] ) || ! is_singular() ) {
		$author['link'] = get_author_posts_url( get_the_author_meta( 'ID' ) );
	}
	
	$link = sprintf( '<a class="%5$s" href="%1$s" title="%2$s"><span class="meta-title">%3$s</span>%4$s</a>', 
		esc_url( $author['link'] ),
		esc_attr__( $author['label'], 'hoon' ), 
		esc_html__( $author['label'], 'hoon' ), 
		esc_html__( $author['value'], 'hoon' ), 
		esc_attr( $author['class'] )
	);
	
	return $link;
	
}


/**
 * Comments Meta Link
 *
 * Creates a link with the proper href ID. The HREF points
 * to a corresponding content ID container which is displayed
 * when switching tabs (via JS)
 *
 * @return string
 * @since 1.0
 */
function hoon_comments_meta_link() {
	
	if ( comments_open() || pings_open() ) {
		$comments_num = get_comments_number();
		
		$comment = array(
			'label' => _n( 'Comment', 'Comments', $comments_num, 'hoon' ),
			'value' => '',
			'link'  => '#comments-' . get_the_ID(),
			'count' => $comments_num,
			'class' => hoon_is_active_meta_tab( 'comments' )
		);
		
		$link = sprintf( '<a class="%5$s" href="%1$s" title="%2$s"><span class="meta-title">%3$s</span>%4$s</a>', 
			esc_url( $comment['link'] ),
			esc_attr__( $comment['label'], 'hoon' ),
			esc_html__( $comment['label'], 'hoon' ), 
			esc_html__( absint( $comment['count'] ), 'hoon' ),
			esc_attr( $comment['class'] )
		);
		
		return $link;
	}
	
}


/**
 * Get related posts link.
 *
 * Creates a link with the proper href ID. The HREF points
 * to a corresponding content ID container which is displayed
 * when switching tabs (via JS)
 *
 * @return string
 * @since 1.0
 */
function hoon_related_posts_link() {	
	
	$args = hoon_get_posts_related_by_taxonomy( get_the_ID(), 'category' );
	$related = new WP_Query( $args );
	
	$post_count = hoon_get_related_post_count( $related->post_count );
	
	$related = array(
		'label' => 'Related',
		'value' => sprintf( 'Top %s', $post_count ),
		'link'  => '#related-' . get_the_ID(),
		'class' => hoon_is_active_meta_tab( 'related' )
	);
	
	$link = sprintf( '<a class="%5$s" href="%1$s" title="%2$s"><span class="meta-title">%3$s</span>%4$s</a>', 
		esc_url( $related['link'] ),
		esc_attr__( $related['label'], 'hoon' ), 
		esc_html__( $related['label'], 'hoon' ),
		esc_html__( $related['value'], 'hoon' ),
		esc_attr( $related['class'] )
	);
	
	return $link;
	
}


/**
 * Popular Posts
 *
 * Creates a link with the proper href ID. The HREF points
 * to a corresponding content ID container which is displayed
 * when switching tabs (via JS)
 *
 * @return string
 * @since 1.0
 */
function hoon_popular_posts_link() {	
	
	$popular_posts = hoon_get_popular_posts_query();
	
	$popular = array(
		'label' => 'Popular',
		'value' => sprintf( 'Top %s', $popular_posts->post_count ),
		'link'  => '#popular-' . get_the_ID(),
		'class' => hoon_is_active_meta_tab( 'popular' )
	);
	
	$link = sprintf( '<a class="%5$s" href="%1$s" title="%2$s"><span class="meta-title">%3$s</span>%4$s</a>', 
		esc_url( $popular['link'] ),
		esc_attr__( $popular['label'], 'hoon' ), 
		esc_html__( $popular['label'], 'hoon' ),
		$popular['value'],
		esc_attr( $popular['class'] )
	);
	
	return $link;
	
}


/**
 * Related Post Count
 *
 * Get the post count number for the related posts link.
 *
 * @see hoon_related_posts_link()
 * @see hoon_get_posts_related_by_taxonomy()
 *
 * @return integer
 * @since 1.0
 */
function hoon_get_related_post_count( $related_post_count = null ) {
	
	$default_count = 5;
	
	if ( null === $related_post_count )
		$related_post_count = $default_count;
	 
	return ( $related_post_count <= $default_count ) ? $related_post_count : $default_count;

}


/**
 * Related Post Count
 *
 * Prints related post items into an LI.
 *
 * @uses hoon_get_posts_related_by_taxonomy()
 *
 * @print html
 * @since 1.0
 */
function hoon_related_posts_content() {
	
	global $post;
	
	$args = hoon_get_posts_related_by_taxonomy( get_the_ID(), 'category' );
	$related = new WP_Query( $args );
	
	if ( $related->have_posts() ) : while ( $related->have_posts() ) : $related->the_post();
    		
    		$supported_formats = get_theme_support( 'post-formats' );
    		$format = ( in_array( get_post_format(), $supported_formats[0] ) ) ? get_post_format() : 'Standard';
			?>
			
			<li>
				<div class="format-type">
					<?php
					$events_cat = hoon_option( 'events_category' );
					if ( post_is_in_descendant_category( $events_cat ) || in_category( $events_cat ) ) {
						printf( '%s', ucfirst( esc_html( get_cat_name( $events_cat ) ) ) );
					} else {
						printf( '%s', ucfirst( $format ) );
					}
					?>
				</div>
				<h5 class="title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>"><?php the_title() ?></a></h5>
				<?php if( ! hoon_option( 'post_posted_on' ) ) : ?>
					<div class="posted-on"><?php hoon_posted_on(); ?></div>
				<?php endif; ?>
			</li>
			
			<?php
		endwhile;
	endif;
	
	wp_reset_postdata();
}


/**
 * Popular Posts Query
 *
 * Set a transient for the $popular_posts to avoid 
 * querying the database when not needed.
 *
 * This transient is deleted/reset when the popular
 * post meta action is added, updated, or deleted. 
 * In these cases we will want to update the popular 
 * posts list, thus needing to query the database again.
 *
 * Transient deleted in: hoon_popular_posts_content_flusher()
 *
 * @since 1.0
 */
function hoon_get_popular_posts_query() {
	
	if ( false === ( $popular_posts = get_transient( 'hoon_popular_posts' ) ) ) {

		$popular_posts = new WP_Query( array(
			'ignore_sticky_posts' => 1,
			'post_type' => 'post',
			'post_status' => array( 'publish', 'future' ),
			'meta_query' => array(
				array(
					'key' => '_post_rating',
					'value' => '0',
					'compare' => '>=',
					'type' => 'NUMERIC'
				)
			),
			'meta_key' => '_post_rating',
			'orderby' => 'meta_value',
			'order' => 'DESC',
			'posts_per_page' => 5
		) );

		set_transient( 'hoon_popular_posts', $popular_posts );
	}
	
	return $popular_posts;
	
}


/**
 * Popular Posts Content
 *
 * Displays Popular posts based on Like It Up post ratings.
 * Prints content to page in an LI.
 *
 * @since 1.0
 */
function hoon_popular_posts_content() {
	$popular_posts = hoon_get_popular_posts_query();
	
	if ( $popular_posts->have_posts() ) : while ( $popular_posts->have_posts() ) : $popular_posts->the_post(); ?>
	
			<li>
				<div class="rating">
					<i class="heart icon-heart"></i> <?php echo get_post_meta( get_the_id(),"_post_rating", 1 ); ?>
				</div>
				<div class="title-area">
					<h5 class="title">
						<a href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>"><?php the_title() ?></a> 
					</h5>
					<?php if( ! hoon_option( 'post_posted_on' ) ) : ?>
						<div class="posted-on"><?php hoon_posted_on(); ?></div>
					<?php endif; ?>
			
				</div>
			</li>
			
	<?php endwhile; endif; wp_reset_postdata();
	
}


/**
 * Called when the psot meta is added, updated, or deleted.
 * In this case, we'll check to see if the updated meta is
 * the meta associate with the popular posts. If so, we want
 * to delete the transient set for the popular posts.
 *
 * @uses hoon_popular_posts_content_flusher()
 * @see hoon_get_popular_posts_query()
 */
add_action( 'added_post_meta', 'hoon_popular_posts_content_updated', 10, 4 );
add_action( 'updated_post_meta', 'hoon_popular_posts_content_updated', 10, 4 );
add_action( 'deleted_post_meta', 'hoon_popular_posts_content_updated', 10, 4 );

function hoon_popular_posts_content_updated( $meta_id, $post_id, $meta_key, $meta_value ) {
   
    if ( '_post_rating' == $meta_key )
        hoon_popular_posts_content_flusher();

}


/**
 * Delete Popular Posts Content Transient
 *
 * Delete transient data when Theme Options get updated
 *
 * @since 1.0
 */
function hoon_popular_posts_content_flusher() {

	delete_transient( 'hoon_popular_posts' );

}


/**
 * Posted On
 *
 * Prints HTML with meta information for the current post-date/time.
 * If the post is in the selected category for Events, the date
 * and text is adjusted for the post to reflect the event time.
 *
 * @since 1.0
 */
if ( ! function_exists( 'hoon_posted_on' ) ) :
function hoon_posted_on() {
	
	$events_cat = hoon_option( 'events_category' );
	    
  	if ( post_is_in_descendant_category( $events_cat ) || in_category( $events_cat ) ) {
	    $date = get_the_date() . get_the_time( ' @ g:i a' );
	} else {
	    $date = get_the_date();
	}

	printf( 
		__( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a>', 'hoon' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( $date )
	);
	
}
endif;


/**
 * Posted In
 *
 * Prints HTML with meta information for the current posts categories and tags.
 *
 * @since 1.0
 */
if ( ! function_exists( 'hoon_posted_in' ) ) :
function hoon_posted_in() {
	
	$categories_list = get_the_category_list( __( ', ', 'hoon' ) );
	$tag_list = get_the_tag_list( '', __( ', ', 'hoon' ) );
	
	if ( '' != $tag_list ) {
	    $utility_text = __( 'Posted in %1$s and tagged %2$s', 'hoon' );
	} elseif ( '' != $categories_list ) {
	    $utility_text = __( 'Posted in %1$s', 'hoon' );
	}

	return sprintf(
	    $utility_text,
	    $categories_list,
	    $tag_list
	);
	
}
endif;


/**
 * Related Posts By Taxonomy
 *
 * Gets posts that are related to current post based
 * on taxonomy. In this case, the theme is more than
 * likely passing in the "category" taxonomy
 *
 * @return array
 * @since 1.0
 */
function hoon_get_posts_related_by_taxonomy( $post_id, $taxonomy, $args = array() ) {
	
	$terms = wp_get_object_terms( $post_id, $taxonomy );
	
	$posts_per_page = isset( $args['posts_per_page'] ) ? $args['posts_per_page'] : null;
	
	if ( count( $terms ) ) {
		foreach( (array) $terms as $term ) {
			$terms_slug[] = $term->slug;
		}
		
		$events_cat = hoon_option( 'events_category' );
		
  		if ( $events_cat && ( post_is_in_descendant_category( $events_cat ) || in_category( $events_cat ) ) ) {
			$post_status = array( 'publish', 'future' );
		} else {
			$post_status = array( 'publish' );
		}
		
		$args = wp_parse_args( $args, array(
			'post_status' => $post_status,
			'post__not_in' => array( $post_id ), // Do not include current post
    		'tax_query' => array(
    			array (
    				'taxonomy' => $taxonomy,
    				'field' => 'slug',
    				'terms' => $terms_slug
    			)
  			),
			'posts_per_page' => hoon_get_related_post_count( $posts_per_page )
		) );
	}
	
	return $args;
	
}


/**
 * Post Link Filter
 * 
 * Filter post title for tumblr style links
 * by graving first URL or Link in post content
 *
 * @since 1.0
 */
if ( ! function_exists( 'hoon_post_link_filter' ) ) :
function hoon_post_link_filter( $link, $post ) {
	
	if ( is_admin() ) 
		return $link;
	
	if ( has_post_format( 'link' ) ) {
		$content = get_the_content();
		
		$linktoend = stristr( $content, "http" );
		$afterlink = stristr( $linktoend, ">" );
		
		if ( ! strlen( $afterlink ) == 0 ):
			$link = substr( $linktoend, 0, -( strlen( $afterlink ) + 1 ) );
		else:
			$link = $linktoend;
		endif;
	}
	
	return $link;
	
}
endif;


/**
 * Post Title Filter
 *
 * Filter post title for tumblr style links
 * by graving first URL or Link in post content
 *
 * @since 1.0
 */
if ( ! function_exists( 'hoon_post_title_filter' ) ) :
function hoon_post_title_filter( $title ) {
	
	if ( is_admin() ) 
		return $title;
	
	if ( has_post_format( 'link' ) ) {
		$title = $title . ' &rarr;';
	}
	
	return $title;
	
}
endif;


/**
 * Create select options from array.
 *
 * This function takes an array and returns a set of options
 * to be used inside a select box.
 */
function hoon_array_to_select( $option = array(), $selected = '', $optgroup = NULL ) {
	
	$select_options = '';

	$option_markup = '<option value="%1$s" %3$s>%2$s</option>';
	
	if ( $selected == '' ) {
		$select_options .= sprintf( $option_markup,	'', __( 'Select one...', 'hoon' ), 'selected="selected"' );
	}
	
	foreach ( $option as $key => $value ) {
		if ( $key == $selected ) {
	    	$select_options .= sprintf( $option_markup,	esc_attr( $key ), sprintf( esc_html__( '%s', 'hoon' ), $value ), 'selected="selected"' );
	    } else {
	    	$select_options .= sprintf( $option_markup,	esc_attr( $key ), sprintf( esc_html__( '%s', 'hoon' ), $value ), '' );
	    }
	}
	
    return $select_options;
    
}


/**
 * Page Query Var
 *
 * The below functionality is used because the query is set
 * in a page template, the "paged" variable is available. However,
 * if the query is on a page template that is set as the websites
 * static posts page, "paged" is always set at 0. In this case, we
 * have another variable to work with called "page", which increments
 * the pagination properly.
 * 
 * Hat Tip: @nathanrice
 * 
 * @link http://wordpress.org/support/topic/wp-30-bug-with-pagination-when-using-static-page-as-homepage-1
 * @since 1.0
 */
if ( ! function_exists( 'hoon_get_paged_query_var' ) ) :
function hoon_get_paged_query_var() {
	
	if ( get_query_var( 'paged' ) ) {
		$paged = get_query_var( 'paged' );
	} elseif ( get_query_var( 'page' ) ) {
		$paged = get_query_var( 'page' );
	} else {
		$paged = 1;
	}
	
	return $paged;
	
}
endif;


/**
 * Limit String
 *
 * Returns a string that is limited if shorter than the desired length.
 * Lenght is determined by number of characters to show, including
 * spaces. If the string is shorter than the desired lenght,
 * the string will be returned.
 *
 * @return string
 * @since 1.0
 */
function hoon_limit_string( $string = '', $args = array() ) {
	
	$defaults = array(
		'length' => 24,
		'more' => '&hellip;',
		'echo' => 0
	);
	
	$args = wp_parse_args( $args, $defaults );
	
	extract( $args );

	if ( absint( $length ) )
		$string = substr( $string, 0, $length );
		
	if ( strlen( $string ) < $length )
		$string = apply_filters( 'hoon_limit_string', $string );
	else
		$string = apply_filters( 'hoon_limit_string', $string . $more );
	
	if ( strlen( $string ) > 0 ) {
		if ( $echo )
			echo $string;
		else
			return $string;
	}
	
}


/**
 * Get Page Template Args
 *
 * Returns an array of arguments used for different query types
 * and page layout column display.
 *
 * @param $type The type of content (post format) required for in the page tempalte
 * @return array
 * @since 1.0
 */
function hoon_get_template_args( $type = '', $meta ) {
	
	if ( ! isset( $meta ) )
		$meta = hoon_get_custom_post_meta();
	
	$defaults = array(
		'term'           => '',
		'tax_query_term' => '',
		'columns'        => ( isset( $meta['columns'] ) && ! empty( $meta['columns'] ) ) ? $meta['columns'] : 3
	);
	
	$args = array();

	if ( 'image-gallery' == $type ) :
		$args = array(
			'term'           => 'gallery',
			'tax_query_term' => array( 'post-format-image', 'post-format-gallery' )
		);
	elseif ( 'image' == $type ) :
		$args = array(
			'term'           => 'image',
			'tax_query_term' => 'post-format-image'
		);
	elseif ( 'gallery' == $type ) :
		$args = array(
			'term'           => 'gallery',
			'tax_query_term' => 'post-format-gallery'
		);
	elseif ( 'audio' == $type ) :
		$args = array(
			'term'           => 'audio',
			'tax_query_term' => 'post-format-audio'
		);
	elseif ( 'video' == $type ) :
		$args = array(
			'term'           => 'video',
			'tax_query_term' => 'post-format-video',
			'columns'        => ( isset( $meta['columns'] ) && ! empty( $meta['columns'] ) ) ? $meta['columns'] : 2
		);
	endif;
		
	return wp_parse_args( $args, $defaults );
	
}


/**
 * Column Class Name
 *
 * This sets the class name based on how many columns
 * are desired for the page layout.
 *
 * @param $columns Number of columns
 * @returns sting
 * @since 1.0
 */ 
function hoon_get_columns_class_name( $columns ) {
	
	$class = '';
	
	switch ( absint( $columns ) ) :
		case 2 :
			$class = 'six';
			break;
		case 3 :
			$class = 'four';
			break;
		case 4 :
			$class = 'three';
			break;
		case 6 :
			$class = 'two';
			break;
		default :
			$class = 'twelve';
			break;
	endswitch;
	
	return $class;
	
}


/**
 * Footer Widget Area Class
 *
 * Count the number of footer sidebars to enable dynamic classes for the footer
 * 
 * @since 1.2.0
 */
function hoon_footer_widget_area_class() {
	
	$count = 0;

	if ( is_active_sidebar( 'sidebar-footer-1' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-footer-2' ) )
		$count++;

	$class = 'columns';

	switch ( $count ) {
		case '1':
			$class .= ' twelve';
			break;
		case '2':
			$class .= ' six';
			break;
	}
	
	return $class;
		
}

function hoon_get_post_count() {
	return $count = isset( $count ) ? $count++ : 1;
}


/**
 * Register Sidebars
 *
 * @since 1.0
 */
function hoon_register_sidebars() {

	register_sidebar( array(
		'id'            => 'sidebar-widgets',
		'name'          => __( 'Widgets Page Template', 'hoon' ),
		'description'   => __( 'These widgets are displayed on the Widgets page template.', 'hoon' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	
	register_sidebar( array(
		'id'            => 'sidebar-footer-1',
		'name'          => __( 'Footer - Column 1', 'hoon' ),
		'description'   => __( 'These widgets are displayed in the first column of the Footer.', 'hoon' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	
	register_sidebar( array(
		'id'            => 'sidebar-footer-2',
		'name'          => __( 'Footer - Column 2', 'hoon' ),
		'description'   => __( 'These widgets are displayed in the first column of the Footer.', 'hoon' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
		
}

?>