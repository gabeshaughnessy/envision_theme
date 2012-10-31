<?php

/*********************************************************************************************

Plugin Name: Delicious.com
Plugin URI: http://www.lukemcdonald.com/
Description: Add your Delicious.com feed
Author: Luke McDonald
Version: 1.0
Author URI: http://www.lukemcdonald.com/

**********************************************************************************************/

add_action( 'widgets_init', 'hoon_delicious_widget_load' );

function hoon_delicious_widget_load() { 
	register_widget( 'hoon_delicious_widget' ); // register widget
}

class hoon_delicious_widget extends WP_Widget {

	function hoon_delicious_widget() {
		// define widget settings
		$widget_ops = array( 
			'classname' => 'hoon_delicious_widget', 
			'description' => __( 'Add Your Delicious.com Feed', 'hoon' )
		);
		
		// widget control settings_fields
		$control_ops = array( 
			'width' => 250, 
			'height' => 250, 
			'id_base' => 'hoon_delicious_widget' 
		);
		
		// create the widget
		$this->WP_Widget( 'hoon_delicious_widget', __( 'Delicious.com', 'hoon' ), $widget_ops, $control_ops ); 
	}
	
    function form( $instance ) {
	    $defaults = array(
	    	'title' => __( 'Recommended Links via Delicious.com:', 'hoon' ),
	    	'username' => '',
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
    }
    
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
 		$instance['username'] = strip_tags( $new_instance['username'] );
 		$instance['count'] = absint( $new_instance['count'] );
 		
        return $new_instance;
    }
	
    function widget( $args, $instance ) {
		extract( $args );
		
		print $before_widget; 
		
		print $before_title;
		printf( __( '%s', 'hoon' ), esc_html( $instance['title'] ) );
		print $after_title;
		
		print do_shortcode( sprintf( '[p75_delicious username="%1$s" count="%2$s"]', 
		    esc_html( $instance['username'] ),
		    absint( $instance['count'] )
		) );
		
		print $after_widget;
    }
}

?>