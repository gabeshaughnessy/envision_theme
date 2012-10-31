<?php

/*********************************************************************************************

Plugin Name: Featured Posts
Plugin URI: http://www.lukemcdonald.com/
Description: Display featured posts.
Author: Luke McDonald
Version: 1.0
Author URI: http://www.lukemcdonald.com/

**********************************************************************************************/

add_action( 'widgets_init', 'hoon_posts_widget_load' );

function hoon_posts_widget_load() { 
	register_widget( 'hoon_posts_widget' ); // register the widget
} 

class hoon_posts_widget extends WP_Widget {

	function hoon_posts_widget() {
		// define widget settings
		$widget_ops = array( 
			'classname' => 'hoon_posts_widget', 
			'description' => __( 'Display Featured Posts', 'hoon' ) 
		);
		
		// widget control settings_fields
		$control_ops = array( 
			'width' => 250, 
			'height' => 250, 
			'id_base' => 'hoon_posts_widget' 
		);
		
		// create the widget
		$this->WP_Widget( 'hoon_posts_widget', __( 'Featured Posts', 'hoon' ), $widget_ops, $control_ops ); 
	}
	
    function form( $instance ) {
	    $defaults = array(
	    	'title' => __( 'My Latest Blog Posts:', 'hoon' ),
	    	'category' => '',
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
		
		// Category
		printf( '<p><label for="%2$s">%1$s</label><br />%4$s</p>',
			esc_html__( 'Category:', 'hoon' ),
			esc_attr( $this->get_field_id( 'category' ) ),
			esc_attr( $this->get_field_name( 'category' ) ),
			wp_dropdown_categories( array( 
				'name' => $this->get_field_name( 'category' ), 
				'selected' => $instance['category'],
				'show_option_all' => __( 'All Categories', 'hoon' ),
				'show_count' => 1,
				'class' => 'widefat',
				'echo' => 0
			) )
		);
		
		// Post Count
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
 		$instance['category'] = absint( $new_instance['category'] );
 		$instance['count'] = absint( $new_instance['count'] );
 		
        return $new_instance;
    }
    
    function widget( $args, $instance ) {
		extract( $args );
		
		print $before_widget; 
		
		print $before_title . $instance['title'] . $after_title;
		
		print do_shortcode( sprintf( '[p75_posts category="%1$s" count="%2$s"]', 
		    esc_html( $instance['category'] ),
		    absint( $instance['count'] )
		) );
		
		print $after_widget;
    }
}

?>