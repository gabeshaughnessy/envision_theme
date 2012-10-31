<?php
/**
 * Metaboxes Setup
 *
 * Here we create custom metaboxes using WPAlchemy Metabox Class.
 *{@link http://farinspace.com/wpalchemy-metabox/ }
 *
 * @package WordPress
 * @subpackage Hoon
 * @since 1.0
 */


/**
 * WPAlchemy Metabox Scripts and Styles
 *
 * @since 1.0
 */
function hoon_metabox_init( $hook ) {
	if( $hook == 'post-new.php' || $hook == 'post.php' ) {
		wp_enqueue_style( 'hoon_metabox', get_template_directory_uri() . '/includes/metaboxes/MetaBox.css', array(), hoon_version_id() );
		wp_enqueue_style( 'farbtastic' );
    	wp_enqueue_script( 'farbtastic' );
		wp_enqueue_script( 'hoon_metabox', get_template_directory_uri() . '/includes/metaboxes/MetaBox.js', array( 'farbtastic', 'jquery' ), hoon_version_id(), true );
	}
}
add_action( 'admin_enqueue_scripts', 'hoon_metabox_init' );


/**
 * WPAlchemy Metabox Class
 *
 * This class adds the functionality to easily 
 * create custom metaboxes. Very quick and useful.
 *
 * @since 1.0
 */
locate_template( 'includes/metaboxes/MetaBox.php', true );


/**
 * WPAlchemy MediaAccess Class
 *
 * This class adds the functionality to easily 
 * upload and insert media into metaboxes.
 *
 * @since 1.0
 */
locate_template( 'includes/metaboxes/MediaAccess.php', true );
/* Define a media acess object */
$wpalchemy_media_access = new WPAlchemy_MediaAccess();


/**
 * Post Options Metabox
 *
 * @return array
 * @since 1.0
 */
$hoon_post_options = new WPAlchemy_MetaBox( array(
	'id'       => '_post_options',
	'title'    => __( 'Custom Options', 'hoon' ),
	'types'    => array( 'post', 'page' ),
	'context'  => 'side',
	'template' => get_template_directory() . '/includes/metaboxes/post-options.php'
));


?>