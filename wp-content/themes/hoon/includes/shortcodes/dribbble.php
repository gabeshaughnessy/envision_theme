<?php
/**
 * Dribbble.com Shortcode
 * [p75_dribbble username="username" count="5"]
 *
 * This shortcode grabs the feed for a Dribbble.com username.
 * This shortcode is also used by the Dribbble.com widget.
 */

class Hoon_Dribbble_Shortcode {
	static $add_script;
	static $username;
	static $count;
	static $columns;
 
	static function init() {
		add_shortcode( 'p75_dribbble', array( __CLASS__, 'handle_shortcode' ) );
	}
 
	static function handle_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'username' => '',
			'columns' => 'three',
			'count' => 6,
		), $atts ) );
		
		self::$username = $username;
		self::$count = $count;
		self::$columns = $columns;
		
		$output = '<div class="dribbble feed">';
		    $output .= sprintf( '<ul class="mobile block-grid %1$s-up">', self::$columns );

			    // Helpful for user debugging purposes
			    $output .= sprintf( '<!-- Username: %1$s, Count: %2$s -->',
			        esc_html( self::$username ),
			        absint( self::$count )
			    );
			    
		    	if( empty( self::$username ) ) {
		    		$output .= sprintf( '<li>%s</li>',
		    			__( 'Dribbble username has not been set.', 'hoon' )
		    		);
		    	} else {
					$feed = fetch_feed('feed://dribbble.com/' . self::$username . '/shots.rss');
		
		    		if ( ! is_wp_error( $feed ) ) :
		    			$maxitems = $feed->get_item_quantity( absint( self::$count ) );
		    			
		    			foreach ( $feed->get_items( 0, $maxitems ) as $item ) :
		    			    $output .= sprintf( '<li><div class="inner"><h4><a href="%1$s" title="%4$s" target="_blank">%2$s &rarr;</a></h4>%3$s</div></li>',
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
 
Hoon_Dribbble_Shortcode::init();

?>