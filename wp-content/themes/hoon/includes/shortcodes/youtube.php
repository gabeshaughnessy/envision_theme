<?php
/**
 * YouTube.com Shortcode
 * [p75_youtube username="username" count="5"]
 *
 * This shortcode grabs the feed for a YouTube.com username.
 * This shortcode is also used by the YouTube.com widget.
 */

class Hoon_YouTube_Shortcode {
	static $add_script;
	static $username;
	static $count;
 
	static function init() {
		add_shortcode( 'p75_youtube', array( __CLASS__, 'handle_shortcode' ) );
	}
 
	static function handle_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'username' => '',
			'count' => 6,
		), $atts ) );
		
		self::$username = $username;
		self::$count = $count;
		
		$output = '<div class="youtube feed">';
		    $output .= '<ul class="block-grid four-up">';
			    // Helpful for user debugging purposes
			    $output .= sprintf( '<!-- Username: %1$s, Count: %2$s -->',
			        esc_html( self::$username ),
			        absint( self::$count )
			    );
			    
		    	if( empty( self::$username ) ) {
		    		$output .= sprintf( '<li>%1$s</li>',
		    			__( 'YouTube username has not been set.', 'hoon' )
		    		);
		    	} else {
					$feed = fetch_feed( 'feed://gdata.youtube.com/feeds/base/users/' . self::$username . '/uploads?alt=rss&v=2&orderby=published&client=ytapi-youtube-profile' );

		    		if ( ! is_wp_error( $feed ) ) :
		    			$maxitems = $feed->get_item_quantity( absint( self::$count ) );
		    			
		    			foreach ( $feed->get_items( 0, $maxitems ) as $item ) :
		    			    $output .= sprintf( '<li><div class="inner">%1$s</div></li>', $item->get_description() );
		    			endforeach;
		    		else :
		    			$output .= sprintf( '<li>%1$s</li>',
		    				__( 'Unable to fetch feed at this time.', 'hoon' )
		    			);
		    		endif;
		    	}
		    $output .= '</ul>';
		$output .= '</div>';
		
		return $output;
	}
}
 
Hoon_YouTube_Shortcode::init();

?>