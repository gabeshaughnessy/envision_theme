<?php
/**
 * Featured Posts Shortcode
 * [p75_posts category="category_id" count="5"]
 *
 * This shortcode grabs the posts from a selected category.
 * This shortcode is also used by the Featurd Posts widget.
 */

class Hoon_Posts_Shortcode {
	
	static $add_script;
	static $category;
	static $count;
 
	static function init() {
		
		add_shortcode( 'p75_posts', array( __CLASS__, 'handle_shortcode' ) );
	
	}
 
	static function handle_shortcode( $atts ) {
		
		extract( shortcode_atts( array(
			'category' => null,
			'count' => 6,
		), $atts ) );
		
		self::$category = $category;
		self::$count = $count;
		
		$output = '<div class="posts feed">';
		    $output .= '<ul>';
			    // Helpful for user debugging purposes
			    $output .= sprintf( '<!-- Category: %1$s, Count: %2$s -->',
			        esc_html( self::$category ),
			        absint( self::$count )
			    );
		
				$cat_posts = new WP_Query( 'posts_per_page=' . absint( self::$count ) . '&cat=' . absint( self::$category ) );
		    	
		    	if ( $cat_posts->have_posts() ) :	
			   		while ( $cat_posts->have_posts() ) :
			   			$cat_posts->the_post();
			   			
						$output .= sprintf( '<li><h4><a href="%1$s" title="%4$s" target="_blank">%2$s</a></h4><p>%3$s</p></li>',
							get_permalink(),
							the_title( '', '', false ),
							get_the_excerpt(),
							esc_attr( the_title_attribute( array( 'echo' => 0 ) ) )
						);
			   		endwhile; 
			   		
			   		wp_reset_postdata();
			   	else :
		    		$output .= sprintf( '<li>%s</li>',
		    		    __( 'There were not any posts found.', 'hoon' )
		    		);
			   	endif; // end have_posts()
			   	
		    $output .= '</ul>';
		$output .= '</div>';
		
		return $output;
	}
}
 
Hoon_Posts_Shortcode::init();

?>