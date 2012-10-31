<?php

/*********************************************************************************************

Plugin Name: Flickr.com
Plugin URI: http://www.lukemcdonald.com/
Description: Add your Flickr.com feed
Author: Luke McDonald
Version: 1.0
Author URI: http://www.lukemcdonald.com/

**********************************************************************************************/

add_action( 'widgets_init', 'hoon_flickr_widget_load' );

function hoon_flickr_widget_load() { 
	register_widget( 'hoon_flickr_widget' ); // register the widget
};

class hoon_flickr_widget extends WP_Widget {
	function hoon_flickr_widget() {
		// define widget settings
		$widget_ops = array( 
			'classname' => 'hoon_flickr_widget', 
			'description' => __( 'Add Your Flickr.com Feed', 'hoon' )
		);
		
		// widget control settings_fields
		$control_ops = array( 
			'width' => 250, 
			'height' => 250, 
			'id_base' => 'hoon_flickr_widget' 
		);
		
		// create the widget
		$this->WP_Widget( 'hoon_flickr_widget', __( 'Flickr.com', 'hoon' ), $widget_ops, $control_ops ); 
	}
	
	
    function form( $instance ) {
	    $defaults = array(
	    	'title' => __( 'My Pics via Flickr.com:', 'hoon' ),
	    	'user_id' => '',
	    	'set_id' => '',
	    	'count' => 10
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
		
		// User ID
		printf( '<p><label for="%2$s">%1$s <a href="http://idgettr.com/" target="_blank">%5$s</a></label><br /><input type="text" class="widefat" id="%2$s" name="%3$s" value="%4$s" /></p>',
			esc_html__( 'User ID:', 'hoon' ),
			esc_attr( $this->get_field_id( 'user_id' ) ),
			esc_attr( $this->get_field_name( 'user_id' ) ),
			esc_attr( $instance['user_id'] ),
			esc_html__( '(ID Gettr)', 'hoon' )
		);
		
		// Photo Set ID
		printf( $input_option,
			esc_html__( 'Photo Set ID: (optional)', 'hoon' ),
			esc_attr( $this->get_field_id( 'set_id' ) ),
			esc_attr( $this->get_field_name( 'set_id' ) ),
			esc_attr( $instance['set_id'] )
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
 		$instance['user_id'] = strip_tags( $new_instance['user_id'] );
 		$instance['set_id'] = absint( $new_instance['set_id'] );
 		$instance['count'] = absint( $new_instance['count'] );
 		
        return $new_instance;
    }
    
    
    function widget( $args, $instance ) {
		extract( $args );
		
		print $before_widget; 
		
		print $before_title;
		printf( __( '%s', 'hoon' ), esc_html( $instance['title'] ) );
		print $after_title;
		
		print do_shortcode( sprintf( '[p75_flickr user_id="%1$s" count="%2$s" set_id="%3$s"]', 
		    esc_html( $instance['user_id'] ),
		    absint( $instance['count'] ),
		    absint( $instance['set_id'] )
		) );
		
		print $after_widget;
    }
}

?>