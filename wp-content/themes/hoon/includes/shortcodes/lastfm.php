<?php
/**
 * Last.fm Shortcode
 * [p75_lastfm username="username" period="period" count="5"]
 *
 * This shortcode grabs the feed for a Last.fm  user id and photo set.
 * This shortcode is also used by the Last.fm  widget.
 *
 * @attr $period recenttracks, 7day, 3month, 6month, 12month, overall, topalbums, lovedtracks
 */
class Hoon_Lastfm_Shortcode {
	static $add_script;
	static $username;
	static $period;
	static $count;
 
	static function init() {
		add_shortcode( 'p75_lastfm', array( __CLASS__, 'handle_shortcode' ) );
 
		add_action( 'init', array( __CLASS__, 'register_script' ) );
		add_action( 'wp_footer', array( __CLASS__, 'print_script' ) );
	}
 
	static function handle_shortcode( $atts ) {
 
		extract( shortcode_atts( array(
			'username' => '',
			'period' => 'recenttracks',
			'count' => 10
		), $atts ) );
		
		self::$add_script = true;
		self::$username = $username;
		self::$period = $period;
		self::$count = $count;
		
		$output = '<div class="lastfm feed">';
			$output .= sprintf( '<div id="%1$s-lastfmrecords"></div>', esc_html( self::$username ) );
			
		    // Helpful for user debugging purposes
		    $output .= sprintf( '<!-- Username: %1$s, Period: %2$s, Count: %3$s -->',
		        esc_html( self::$username ),
		        esc_html( self::$period ),
		        absint( self::$count )
		    );
		    
		    if( empty( self::$username ) ) {
		        $output .= sprintf( '<p>%s</p>',
		        	__( 'Last.FM username has not been set.', 'hoon' )
		        );
		    } else {
				add_action( 'wp_footer', array( __CLASS__, 'print_inline_script' ) );
		    }
		$output .= '</div>';
		
		return $output;
	}
 
	static function register_script() {
		wp_register_script( 'hoon_lastfmrecords', get_template_directory_uri() . '/javascripts/last.fm.records.js', array( 'jquery' ), '1.0', true );
	}
 
	static function print_script() {
		if ( ! self::$add_script )
			return;
 
		wp_enqueue_script( 'hoon_lastfmrecords' );
	}
	
	static function print_inline_script() {
		?>
		<script type='text/javascript'>
		    jQuery(document).ready( function() {
		        var _config = {
		        	username: '<?php echo esc_html( self::$username ); ?>',
		        	placeholder: '<?php echo esc_html( self::$username ); ?>-lastfmrecords',
		        	period: '<?php echo esc_html( self::$period ); ?>',
		        	count: <?php echo absint( self::$count ); ?>
		        };
		        lastFmRecords.init(_config);
		    });
		</script>
		<?php
	}
}
 
Hoon_Lastfm_Shortcode::init();

?>