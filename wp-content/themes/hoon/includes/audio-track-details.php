<?php

/**
 * Filter Attachement Fields
 *
 * Filter the edit and save functionality of the attachement fields.
 */
add_action( 'admin_init', 'atd_p75_filter_attachement_fields' );

function atd_p75_filter_attachement_fields() {

	add_filter( 'attachment_fields_to_edit', 'atd_p75_attachment_artist_name', 10, 2 );
	add_filter( 'attachment_fields_to_save', 'atd_p75_attachment_artist_name_save', 10, 2 );
	
	add_filter( 'attachment_fields_to_edit', 'atd_p75_attachment_album_name', 10, 2 );
	add_filter( 'attachment_fields_to_save', 'atd_p75_attachment_album_name_save', 10, 2 );
	
	add_filter( 'attachment_fields_to_edit', 'atd_p75_attachment_external_url', 10, 2 );
	add_filter( 'attachment_fields_to_save', 'atd_p75_attachment_external_url_save', 10, 2 );
	
	add_filter( 'attachment_fields_to_edit', 'atd_p75_attachment_playlist', 10, 2 );
	add_filter( 'attachment_fields_to_save', 'atd_p75_attachment_playlist_save', 10, 2 );

}


/**
 * Determine if mime type is audio
 *
 * @param $post, post in question
 * @return $post_mime_type
 */
function atd_p75_is_audio_attachement( $post ) {
	
	return 'audio/mpeg' == get_post_mime_type( $post ) ? 1 : 0;

}


/**
 * Artist Name
 *
 * Add artist name field to media uploader
 *
 * @since 2.1.0
 */
function atd_p75_attachment_artist_name( $form_fields, $post ) {
	
	if ( 0 == atd_p75_is_audio_attachement( $post ) )
		return $form_fields;
	
	$form_fields['post_excerpt'] = array(
	    'label' => __( 'Artist', 'hoon' ),
	    'input' => 'text',
	    'value' => get_post_meta( $post->ID, 'post_excerpt', true )
	);
	
	return $form_fields;
}


/**
 * Album Name
 *
 * Add album name field to media uploader
 *
 * @since 2.1.0
 */
function atd_p75_attachment_album_name( $form_fields, $post ) {

	if ( 0 == atd_p75_is_audio_attachement( $post ) )
		return $form_fields;
	
	$form_fields['post_content'] = array(
	    'label' => __( 'Album', 'hoon' ),
	    'input' => 'text',
	    'value' => get_post_meta( $post->ID, 'post_content', true )
	);
	
	return $form_fields;
	
}


/**
 * External File URL
 *
 * Add Artist Name and Custom Link URL fields to media uploader
 *
 * @since 2.1.0
 */
function atd_p75_attachment_external_url( $form_fields, $post ) {
	
	if ( 0 == atd_p75_is_audio_attachement( $post ) )
		return $form_fields;
	
	$form_fields['atd-p75-external-url'] = array(
	    'label' => __( 'External URL', 'hoon' ),
	    'input' => 'text',
	    'value' => get_post_meta( $post->ID, 'atd_p75_external_url', true ),
	    'helps' => __( 'If provided, this url will be used as the source file for the track.', 'hoon' ),
	);
	
	return $form_fields;
	
}


/**
 * Is Playable?
 *
 * Add "Include in playlist" option to media uploader
 *
 * @since 2.1.0
 */
function atd_p75_attachment_playlist( $form_fields, $post ) {
	
	if ( 0 == atd_p75_is_audio_attachement( $post ) )
		return $form_fields;
		
	// Set up options
	$options = array( 0 => __( 'No', 'hoon' ), 1 => __( 'Yes', 'hoon' ) );
	
	// Get currently selected value
	$selected = get_post_meta( $post->ID, 'atd_p75_playable', true );
	
	// If no selected value, default to 'Yes'
	if ( ! isset( $selected ) || empty( $selected ) )
	    $selected = 0;
	    
	
	// Display each option	
	foreach ( $options as $value => $label ) {
	    $css_id = 'playlist-include-option-' . $value;
	   
		$checked = ( $selected == $value ) ? ' checked="checked"' : '';
		$checked = checked( $value, $selected, false );
	
	    $html = '<div class="playlist-include-option"><input type="radio" name="attachments[' . $post->ID . '][atd-p75-playable]" id="' . esc_attr( $css_id ) . '" value="' . esc_attr( $value ) . '"' . $checked . ' />';
	
	    $html .= '<label for="' . esc_attr( $css_id ) . '">' . sprintf( __( '%s', 'hoon' ), $label ) . '</label>';
	
	    $html .= '</div>';
	
	    $output[] = $html;
	}
	
	// Construct the form field
	$form_fields['atd_p75_playable'] = array(
	    'label' => __( 'Disable Playback?', 'hoon' ),
	    'input' => 'html',
	    'html'  => join( "\n", $output ),
	);
	
	// Return all form fields
	return $form_fields;
	
}


/**
 * Save Artist Name
 *
 * @since 2.1.0
 */
function atd_p75_attachment_artist_name_save( $post, $attachment ) {
	
	if ( isset( $attachment['post_excerpt'] ) )
		update_post_meta( $post['ID'], 'post_excerpt', $attachment['post_excerpt'] );
		
	return $post;
	
}


/**
 * Save Album Name
 *
 * @since 2.1.0
 */
function atd_p75_attachment_album_name_save( $post, $attachment ) {
	
	if ( isset( $attachment['post_content'] ) )
		update_post_meta( $post['ID'], 'post_content', $attachment['post_content'] );
		
	return $post;
	
}


/**
 * Save External File URL
 *
 * @since 2.1.0
 */
function atd_p75_attachment_external_url_save( $post, $attachment ) {
	
	if ( isset( $attachment['atd-p75-external-url'] ) )
		update_post_meta( $post['ID'], 'atd_p75_external_url', $attachment['atd-p75-external-url'] );
	
	return $post;
	
}


/**
 * Save Playable Option
 *
 * @since 2.1.0
 */
function atd_p75_attachment_playlist_save( $post, $attachment ) {
	
	if ( isset( $attachment['atd-p75-playable'] ) ) 
		update_post_meta( $post['ID'], 'atd_p75_playable', $attachment['atd-p75-playable'] );
	
	return $post;
	
}


?>