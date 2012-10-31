<?php

/*********************************************************************************************

Plugin Name: Last.fm
Plugin URI: http://www.lukemcdonald.com/
Description: Add your Last.fm feed
Author: Luke McDonald
Version: 1.0
Author URI: http://www.lukemcdonald.com/

**********************************************************************************************/

add_action( 'widgets_init', 'hoon_lastfm_widget_load' );

function hoon_lastfm_widget_load() { 
	register_widget( 'hoon_lastfm_widget' ); // register the widget 
}

class hoon_lastfm_widget extends WP_Widget {
	
	function hoon_lastfm_widget() {
		// define widget settings
		$widget_ops = array( 
			'classname' => 'hoon_lastfm_widget', 
			'description' => __( 'Add Your Last.FM Feed', 'hoon' ) 
		);
		
		// widget control settings_fields
		$control_ops = array( 
			'width' => 250, 
			'height' => 250, 
			'id_base' => 'hoon_lastfm_widget' 
		);
		
		// create the widget
		$this->WP_Widget( 'hoon_lastfm_widget', __( 'Last.FM', 'hoon' ), $widget_ops, $control_ops ); 
	}
	
    function form( $instance ) {
	    $defaults = array(
	    	'title' => __( 'My Latest Tracks via Last.FM:', 'hoon' ),
	    	'username' => '',
	    	'period' => '',
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
		
		// Username
		printf( $input_option,
			esc_html__( 'Username:', 'hoon' ),
			esc_attr( $this->get_field_id( 'username' ) ),
			esc_attr( $this->get_field_name( 'username' ) ),
			esc_attr( $instance['username'] )
		);
		
		$periods = array(
    		'recenttracks' => __( 'Recent Tracks', 'hoon' ),
    		'7day' => __( 'Last 7 Days', 'hoon' ),
    		'3month' => __( 'Last 3 Months', 'hoon' ),
    		'6month' => __( 'Last 6 Months', 'hoon' ),
    		'12month' => __( 'Last 12 Months', 'hoon' ),
    		'overall' => __( 'Most Played Overall', 'hoon' ),
    		'topalbums' => __( 'Your Top Albums', 'hoon' ),
    		'lovedtracks' => __( 'Your Loved Tracks', 'hoon' )
    	);
    	
    	// Display
		printf( '<p><label for="%2$s">%1$s</label><br /><select id="%2$s" name="%3$s" class="widefat">%4$s</select></p>',
			esc_html__( 'Display:', 'hoon' ),
			esc_attr( $this->get_field_id( 'period' ) ),
			esc_attr( $this->get_field_name( 'period' ) ),
			// array of options, selected option
			hoon_array_to_select( $periods, $instance['period'] )
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
 		$instance['period'] = strip_tags( $new_instance['period'] );
 		$instance['count'] = absint( $new_instance['count'] );
 		
        return $new_instance;
    }
    
    function widget( $args, $instance ) {
		extract( $args );
		
		print $before_widget; 
		
		print $before_title;
		printf( __( '%s', 'hoon' ), esc_html( $instance['title'] ) );
		print $after_title;
		
		print do_shortcode( sprintf( '[p75_lastfm username="%1$s" count="%2$s" period="%3$s"]', 
		    esc_html( $instance['username'] ),
		    absint( $instance['count'] ),
		    esc_html( $instance['period'] )
		) );
		
		print $after_widget;
    }
}

?>