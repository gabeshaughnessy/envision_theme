<?php
/**
 * Flickr.com Shortcode
 * [p75_flickr user_id="userid" set_id="setid" count="5"]
 *
 * This shortcode grabs the feed for a Flickr.com user id.
 * If a photo set is provided, the feed will display that set.
 * This shortcode is also used by the Flickr.com widget.
 */
 
class Hoon_Flickr_Shortcode {
	static $add_script;
	static $user_id;
	static $set_id;
	static $count;
 
	static function init() {
		add_shortcode( 'p75_flickr', array( __CLASS__, 'handle_shortcode' ) );
 
		add_action( 'init', array( __CLASS__, 'register_script' ) );
		add_action( 'wp_footer', array( __CLASS__, 'print_script' ) );
	}
 
	static function handle_shortcode( $atts ) {
 
		extract( shortcode_atts( array(
			'user_id' => '',
			'set_id' => '',
			'count' => 10,
		), $atts ) );
		
		self::$add_script = true;
		self::$user_id = $user_id;
		self::$set_id = $set_id;
		self::$count = $count;
		
		$output = '<div class="flickr feed">';
		    $output .= '<ul class="block-grid five-up">';
		    	// Helpful for user debugging purposes
		    	$output .= sprintf( '<!-- User ID: %1$s, Set ID: %2$s, Count: %3$s -->',
		    		esc_html( self::$user_id ),
		    		absint( self::$set_id ),
		        	absint( self::$count )
		    	);
		    	
		    	if( empty( self::$user_id ) ) {
		    		$output .= sprintf( '<li>%s</li>',
		    			__( 'Flickr User ID has not been set.', 'hoon' )
		    		);
		    	} else {
		    		locate_template( 'includes/flickr.php', true );
		    		
					//add_filter( 'wp_feed_cache_transient_lifetime' , array( __CLASS__, 'wp_feed_lifetime' ) );
					
					if( isset( self::$set_id ) && ! empty( self::$set_id ) ) {
				    	$feed = fetch_feed( 'feed://api.flickr.com/services/feeds/photoset.gne?set=' . self::$set_id . '&nsid=' . self::$user_id . '&lang=en-us&format=rss_200' );
					} else {
				    	$feed = fetch_feed( 'http://api.flickr.com/services/feeds/photos_public.gne?&id=' . self::$user_id . '&lang=en-us&format=rss_200' );
					} 
					
					//remove_filter( 'wp_feed_cache_transient_lifetime' , array( __CLASS__, 'wp_feed_lifetime' ) );	


		    		if ( ! is_wp_error( $feed ) ) :
				    	$full = 'medium';
				    	$thumb = 'square';
		    			$maxitems = $feed->get_item_quantity( absint( self::$count ) );
		    			
		    			foreach ( $feed->get_items( 0, $maxitems ) as $item ) :
			    			$url = flickr::find_photo( $item->get_description() );
			    			$title = flickr::cleanup( $item->get_title() );
			    			$full_url = flickr::photo( esc_url( $url ), esc_html( $full ) );
			    			$thumb_url = flickr::photo( esc_url( $url ), esc_html( $thumb ) );
		    			
		    			    $output .= sprintf( '<li><a class="preview" href="%1$s" data-large="%2$s" title="%4$s"><img class="flickr-img" src="%3$s" alt="%4$s" /></a></li>',
			    				esc_url( $item->get_permalink() ),
			    				esc_url( $full_url ),
			    				esc_url( $thumb_url ),
		    			    	sprintf( esc_attr__( '%s', 'hoon' ), $title )
		    			    );
		    			endforeach;
		    		else :
		    			$output .= sprintf( '<li>%s</li>',
		    				__( 'Unable to fetch feed at this time.', 'hoon' )
		    			);
		    		endif;
		    	}
		    $output .= '</ul>';
		$output .= '</div>';
		
		return $output;
	}
 
	static function register_script() {
		wp_register_script( 'hoon_imagepreview', get_template_directory_uri() . '/javascripts/imagepreview.js', array( 'jquery' ), '1.0', true );
	}
 
	static function print_script() {
		if ( ! self::$add_script )
			return;
 
		wp_enqueue_script( 'hoon_imagepreview' );
	}
	
	static function wp_feed_lifetime( $seconds ) {
	  // change the default feed cache recreation period to 2 hours
	  return 200;
	}
}
 
Hoon_Flickr_Shortcode::init();

?>