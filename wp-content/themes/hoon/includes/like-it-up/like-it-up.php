<?php
/*
 * Plugin Name: Like It Up
 * Description: Like the things.
 * Plugin URI: http://www.lukemcdonald.com
 * Author Name: Luke McDonald
 * Author URIL http://www.lukemcdonald.com/
 */

locate_template( 'includes/like-it-up/wp-ajax.php', true );

function likeitup_scripts() {
	wp_enqueue_script( 'hoon-like-it-up', get_template_directory_uri() . '/includes/like-it-up/like-it-up.js', array( 'jquery' ), hoon_version_id() );
	wp_localize_script( 'hoon-like-it-up', 'like_it_up', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}    
 

class Like_It_Up extends WP_Ajax {

	function __construct() {
		parent::__construct();
		add_action( 'wp_enqueue_scripts', 'likeitup_scripts' );
	}
	
	function get_post_rating( $post_id ) {
		$rating = get_post_meta( $post_id, '_post_rating', true );
		
		if ( ! $rating ) {
			$rating = 0;
		}
		
		return $rating;
	}
	
	function set_post_rating( $post_id, $rating ) {
		update_post_meta( $post_id, '_post_rating', $rating );
	}
	
	function get_post_cookie( $post_id ) {
		if ( isset( $_COOKIE['likeitup_' . $post_id] ) ) {
			return true;
		}
		
		return false;
	}
	
	function set_post_cookie( $post_id, $rating ) {
		if ( $this->get_post_cookie( $post_id ) ) {
			echo $rating;
			die();
		}

		setcookie( 'likeitup_' . $post_id, $post_id, time() + ( 60 * 60 * 24 * 365 ), '/' );
	}
	
	function an_get_post_rating() {
		$id = $_POST['post_id'];
		$rating = $this->get_post_rating( $id );
		echo $rating;
		die();
	}
	
	function an_rate_up() {
		$id = $_POST['post_id'];
		$rating = $this->get_post_rating( $id );
		
		if ( $this->get_post_cookie( $id ) ) {
			echo $rating;
			die();
		}
		
		$this->set_post_cookie( $id, $rating );
		$this->set_post_rating( $id, $rating + 1 );
		echo $rating + 1;
		
		die();
	}
	
	function print_like_buttons( $post_id, $rating ) {
		printf( '<a href="#" class="like-it-up $1$s" id="like-%2$s">%3$s</a>',
			esc_attr( ( $this->get_post_cookie( $post_id ) ) ? 'liked' : 'unliked' ),
			esc_attr( absint( $post_id ) ),
			esc_html__( get_post_rating( $rating ), 'hoon' )
		);
	}
}

new Like_It_Up();