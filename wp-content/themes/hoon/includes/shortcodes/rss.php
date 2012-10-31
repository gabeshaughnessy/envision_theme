<?php
/**
 * Custom RSS Feed Shortcode
 * [p75_rss url="username" count="5"]
 *
 * This shortcode grabs the feed for a custom RSS feed address.
 * This shortcode is also used by the Custom RSS Feed widget.
 */
 
class Hoon_RSS_Shortcode {
	static $add_script;
	static $url;
	static $count;
 
	static function init() {
		add_shortcode( 'p75_rss', array( __CLASS__, 'handle_shortcode' ) );
	}
 
	static function handle_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'url' => '',
			'count' => 6,
		), $atts ) );
		
		self::$url = $url;
		self::$count = $count;
		
		$output = '<div class="rss feed">';
		    $output .= '<ul>';
			    // Helpful for user debugging purposes
			    $output .= sprintf( '<!-- Url: %1$s, Count: %2$s -->',
			        esc_html( self::$url ),
			        absint( self::$count )
			    );
			    
		    	if( empty( $url ) ) {
		    		$output .= sprintf( '<li>%s</li>',
		    			__( 'RSS feed address has not been set.', 'hoon' )
		    		);
		    	} else {
					$feed = fetch_feed( self::$url );
		
		    		if ( ! is_wp_error( $feed ) ) :
		    			$maxitems = $feed->get_item_quantity( absint( self::$count ) );
		    			
		    			foreach ( $feed->get_items( 0, $maxitems ) as $item ) :
		    			    $output .= sprintf( '<li><h4><a href="%1$s" title="%4$s" target="_blank">%2$s</a></h4><p>%3$s</p></li>',
		    			    	esc_url( $item->get_permalink() ),
		    			    	esc_html( $item->get_title() ),
		    			    	$item->get_description(),
		    			    	sprintf( esc_html__( 'Posted %s', 'hoon' ), $item->get_date( 'j F Y | g:i a' ) )
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
}
 
Hoon_RSS_Shortcode::init();
?>