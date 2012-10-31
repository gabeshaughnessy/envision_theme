<?php

/*********************************************************************************************

Plugin Name: Custom RSS Feed
Plugin URI: http://www.lukemcdonald.com/
Description: Add a custom RSS feed
Author: Luke McDonald
Version: 1.0
Author URI: http://www.lukemcdonald.com/

**********************************************************************************************/

add_action( 'widgets_init', 'hoon_rss_widget_load' );

function hoon_rss_widget_load() { 
	register_widget( 'hoon_rss_widget' ); // register the widget
} 

class hoon_rss_widget extends WP_Widget {

	function hoon_rss_widget() {
		// define widget settings
		$widget_ops = array( 
			'classname' => 'hoon_rss_widget', 
			'description' => __( 'Add a Custom RSS Feed', 'hoon' ) 
		);
		
		// widget control settings_fields
		$control_ops = array( 
			'width' => 250, 
			'height' => 250, 
			'id_base' => 'hoon_rss_widget' 
		);
		
		// create the widget
		$this->WP_Widget( 'hoon_rss_widget', __( 'Custom RSS Feed', 'hoon' ), $widget_ops, $control_ops ); 
	}
	
    function form( $instance ) {
	    $defaults = array(
	    	'title' => __( 'Latest Updates via Site Name:', 'hoon' ),
	    	'rss_feed' => '',
	    	'count' => 6
	    );
	
	    $instance = wp_parse_args( (array) $instance, $defaults );
	    
	    $input_option = '<p><label for="%2$s">%1$s</label><br /><input type="text" class="widefat" id="%2$s" name="%3$s" value="%4$s" /></p>';
				
		// Section Title
		printf( $input_option,
			esc_html__( 'Section Title:', 'hoon' ),
			esc_attr( $this->get_field_id( 'title' ) ),
			esc_attr( $this->get_field_name( 'title' ) ),
			esc_attr( $instance['title'] )
		);
		
		// RSS Feed Address
		printf( $input_option,
			esc_html__( 'RSS Feed Address:', 'hoon' ),
			esc_attr( $this->get_field_id( 'rss_feed' ) ),
			esc_attr( $this->get_field_name( 'rss_feed' ) ),
			esc_attr( $instance['rss_feed'] )
		);
		
		// Count
		printf( $input_option,
			esc_html__( 'Count:', 'hoon' ),
			esc_attr( $this->get_field_id( 'count' ) ),
			esc_attr( $this->get_field_name( 'count' ) ),
			esc_attr( $instance['count'] )
		);
    }
    

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
 		$instance['rss_feed'] = esc_url_raw( $new_instance['rss_feed'] );
 		$instance['count'] = absint( $new_instance['count'] );
 		
        return $new_instance;
    }
    
    function widget( $args, $instance ) {
		extract( $args );
		
		print $before_widget; 
		
		print $before_title;
		printf( __( '%s', 'hoon' ), esc_html( $instance['title'] ) );
		print $after_title;
		
		print do_shortcode( sprintf( '[p75_rss url="%1$s" count="%2$s"]', 
		    esc_html( $instance['rss_feed'] ),
		    absint( $instance['count'] )
		) );
		
		print $after_widget;
    }
}

?>