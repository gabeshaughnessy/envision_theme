<?php
/*********************************************************************************************

Plugin Name: Twitter.com
Plugin URI: http://www.lukemcdonald.com/
Description: Add your Twitter.com feed
Author: Luke McDonald
Version: 1.0
Author URI: http://www.lukemcdonald.com/

**********************************************************************************************/

add_action( 'widgets_init', 'hoon_twitter_widget_load' );

function hoon_twitter_widget_load() { 
	register_widget( 'hoon_twitter_widget' ); // register the widget
}

class hoon_twitter_widget extends WP_Widget {
	
	function hoon_twitter_widget() {
		// define widget settings
		$widget_ops = array( 
			'classname' => 'hoon_twitter_widget', 
			'description' => __( 'Add Your Twitter.com Feed', 'hoon' ) 
		);
		
		// widget control settings_fields
		$control_ops = array( 
			'width' => 250, 
			'height' => 250, 
			'id_base' => 'hoon_twitter_widget' 
		);
		
		// create the widget
		$this->WP_Widget( 'hoon_twitter_widget', __( 'Twitter.com', 'hoon' ), $widget_ops, $control_ops ); 
	}
	
	function form( $instance ) {
	    $defaults = array(
	    	'title' => __( 'My Tweets via Twitter.com:', 'hoon' ),
	    	'username' => '',
	    	'count' => 3,
	    	'button' => 0
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
		
		// Username
		printf( $input_option,
			esc_html__( 'Username:', 'hoon' ),
			esc_attr( $this->get_field_id( 'username' ) ),
			esc_attr( $this->get_field_name( 'username' ) ),
			esc_attr( $instance['username'] )
		);
		
		// Count
		printf( $input_option,
			esc_html__( 'Count:', 'hoon' ),
			esc_attr( $this->get_field_id( 'count' ) ),
			esc_attr( $this->get_field_name( 'count' ) ),
			esc_attr( $instance['count'] )
		);
		
    	// Button
		printf( '<input class="checkbox" type="checkbox" id="%2$s" name="%3$s" %4$s value="1" /> <label for="%2$s">%1$s</label>', 
			esc_html__( 'Show follow button?', 'hoon' ),
			esc_attr( $this->get_field_id('button') ),
			esc_attr( $this->get_field_name('button') ),
			checked( absint( $instance['button'] ), 1, false )
		);
    }
    
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
 		$instance['username'] = strip_tags( $new_instance['username'] );
 		$instance['count'] = absint( $new_instance['count'] );
 		$instance['button'] = absint( $new_instance['button'] );
       
        return $new_instance;
    }
    
    function widget( $args, $instance ) {
		extract( $args );
		
		print $before_widget; 
		
		print $before_title;
		printf( __( '%s', 'hoon' ), esc_html( $instance['title'] ) );
		print $after_title;
		
		print do_shortcode( sprintf( '[p75_twitter username="%1$s" count="%2$s" button="%3$s"]', 
		    esc_html( $instance['username'] ),
		    absint( $instance['count'] ),
		    absint( $instance['button'] )
		) );
		
		print $after_widget;
    }
}

?>