<?php

/*********************************************************************************************

Plugin Name: Dribble.com
Plugin URI: http://www.lukemcdonald.com/
Description: Add your Dribble.com feed
Author: Luke McDonald
Version: 1.0
Author URI: http://www.lukemcdonald.com/

**********************************************************************************************/

add_action( 'widgets_init', 'hoon_dribbble_widget_load' );

function hoon_dribbble_widget_load() { 
	register_widget( 'hoon_dribbble_widget' ); // register the widget
}

class hoon_dribbble_widget extends WP_Widget {

	function hoon_dribbble_widget() {
		// define widget settings
		$widget_ops = array( 
			'classname' => 'hoon_dribbble_widget', 
			'description' => __( 'Add Your Dribbble.com Feed', 'hoon' ) 
		);
		
		// widget control settings_fields
		$control_ops = array( 
			'width' => 250, 
			'height' => 250, 
			'id_base' => 'hoon_dribbble_widget' 
		);
		
		// create the widget
		$this->WP_Widget( 'hoon_dribbble_widget', __( 'Dribbble.com', 'hoon' ), $widget_ops, $control_ops ); 
	}
	
    function form( $instance ) {
	    $defaults = array(
	    	'title' => __( 'My Latest Shots via Dribbble.com:', 'hoon' ),
	    	'username' => '',
	    	'columns' => 'three',
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
		
		$columns = array(
			'one' => __( 'One Column', 'hoon' ),
			'two' => __( 'Two Columns', 'hoon' ),
			'three' => __( 'Three Columns', 'hoon' )
		);
		
    	// Columns
		printf( '<p><label for="%2$s">%1$s</label><br /><select id="%2$s" name="%3$s" class="widefat">%4$s</select></p>',
			esc_html__( 'Columns:', 'hoon' ),
			esc_attr( $this->get_field_id( 'columns' ) ),
			esc_attr( $this->get_field_name( 'columns' ) ),
			// array of options, selected option
			hoon_array_to_select( $columns, $instance['columns'] )
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
		
		print do_shortcode( sprintf( '[p75_dribbble username="%1$s" count="%2$s" columns="%3$s"]', 
		    esc_html( $instance['username'] ),
		    absint( $instance['count'] ),
		    esc_html( $instance['columns'] )
		) );
		
		print $after_widget;
    }
}

?>