<?php
/**
 * Twitter.com Shortcode
 * [p75_twitter username="username" count="5"]
 *
 * This shortcode grabs the feed for a Twitter.com username.
 * This shortcode is also used by the Twitter.com widget.
 *
 */
class Hoon_Twitter_Shortcode {
	static $add_script;
	static $username;
	static $count;
	static $button;
 
	static function init() {
		add_shortcode( 'p75_twitter', array( __CLASS__, 'handle_shortcode' ) );
 
		add_action( 'init', array( __CLASS__, 'register_script' ) );
		add_action( 'wp_footer', array( __CLASS__, 'print_script' ) );
	}
 
	static function handle_shortcode( $atts ) {
		self::$add_script = true;
 
		extract( shortcode_atts( array(
			'username' => '',
			'count' => 3,
			'button' => 0
		), $atts ) );
		
		self::$username = $username;
		self::$count = $count;
		self::$button = $button;
		
		$output = '<div class="twitter feed">';
			$output .= sprintf( '<div id="%1$s-twitter"></div>', esc_html( self::$username ) );
			
		    // Helpful for user debugging purposes
		    $output .= sprintf( '<!-- Username: %1$s, Count: %2$s -->',
		        esc_html( self::$username ),
		        absint( self::$count )
		    );
		    
		    if( empty( self::$username ) ) {
		        $output .= sprintf( '<div class="tweet"><p class="text">%s</p>',
		        	__( 'Twitter.com username has not been set.', 'hoon' )
		        );
		    } else {
				add_action( 'wp_footer', array( __CLASS__, 'print_inline_script' ) );
				
				if( true === self::$button || 1 == self::$button ) {
					$output .= sprintf( '<a href="https://twitter.com/%1$s" class="twitter-follow-button" data-show-count="true" data-size="large">%2$s</a>',
						esc_attr( self::$username ),
						sprintf( esc_html__( 'Follow @%1$s', 'hoon' ), self::$username )
					);
					
					add_action( 'wp_footer', array( __CLASS__, 'print_inline_button_script' ) );
				}
		    }
		$output .= '</div>';
		
		return $output;
	}
 
	static function register_script() {
		wp_register_script( 'hoon_livetwitter', get_template_directory_uri() . '/javascripts/livetwitter.js', array( 'jquery' ), '1.0', true );
	}
 
	static function print_script() {
		if ( ! self::$add_script )
			return;
 
		wp_enqueue_script( 'hoon_livetwitter' );
	}
	
	static function print_inline_script() {
		?>
		<script type="text/javascript">
		    jQuery(document).ready( function() {
		    	jQuery( '#<?php echo esc_html( self::$username ); ?>-twitter' ).liveTwitter( '<?php echo esc_html( self::$username ); ?>', { 
		    		limit: <?php echo absint( self::$count ); ?>, 
		    		rate: 300000, 
		    		mode: 'user_timeline',
		    		localization: {
		    		    seconds: '<?php _e( 'seconds', 'hoon' ); ?>',
		    		    minute:  '<?php _e( 'minute', 'hoon' ); ?>',
		    		    minutes: '<?php _e( 'minutes', 'hoon' ); ?>',
		    		    hour:    '<?php _e( 'minutes', 'hoon' ); ?>',
		    		    hours:   '<?php _e( 'hours', 'hoon' ); ?>',
		    		    day:     '<?php _e( 'day', 'hoon' ); ?>',
		    		    days:    '<?php _e( 'days', 'hoon' ); ?>'
		    		}		    	    	
		    	});
		    });
		</script>
		<?php
	}
	
	static function print_inline_button_script() {
		?>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		<?php
	}
}
 
Hoon_Twitter_Shortcode::init();

?>