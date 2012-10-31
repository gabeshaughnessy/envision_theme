<?php  

class Hoon_Audio {
	
	/**
	 * Post ID
	 *
	 * Numberic ID of an "audio" post
	 */
	static $id = '';
	
	/**
	 * Album Name
	 *
	 * The album name of the track
	 */
	static $album;
	
	/**
	 * Artist Name
	 *
	 * The artist name of the track
	 */
	static $artist;
	
	/**
	 * Artwork URL
	 *
	 * URL of the tracks artwork
	 */
	static $artwork;
	
	/**
	 * Track Number
	 *
	 * The track number
	 */
	static $number;
	
	/**
	 * Audio Source
	 *
	 * URL of the audio source to be played back
	 */
	static $src;
	
	/**
	 * Track Title
	 *
	 * The title of the track
	 */
	static $title;
	
	/**
	 * Track Object
	 *
	 * Track details will be stored in an array.
	 */
	static $track;
	
	/**
	 * Tracks Object
	 *
	 * Tracks will be stored in an array.
	 */
	static $tracks;
	

	/**
	 * Init
	 *
	 * @since 2.0.0
	 */
	function __construct( $post_id ) {
	
		$this->id = ( isset( $post_id ) ) ? $post_id : get_the_ID();
		$this->number = 0;
		
	}
	
	
	/**
	 * Get Album
	 *
	 * @since 2.0.0
	 */
	function get_album( $attachment ) {
	
		if ( $attachment ) {
			$attachment_description = apply_filters( 'the_content', $attachment->post_content );
		}
		
		if ( isset( $attachment_description ) && ! empty( $attachment_description ) ) {
		    $this->album = $attachment_description;
		} else {
		    $this->album = get_the_title();
		}

		return $this->album;
		
	}


	/**
	 * Get Artwork
	 *
	 * @since 2.0.0
	 */
	function get_artwork() {
	
		if ( has_post_thumbnail() ) {
		    $this->artwork = wp_get_attachment_image_src( get_post_thumbnail_id(), 'post-thumbnail' );
		    $this->artwork = $this->artwork[0];
		} else {
			$this->artwork = get_template_directory_uri() . '/images/default-artwork.png';
		}

		return $this->artwork;
		
	}


	/**
	 * Get Artist
	 *
	 * @since 2.0.0
	 */
	function get_artist( $attachment ) {
	
		if ( $attachment ) {
			$attachment_caption = apply_filters( 'the_excerpt', $attachment->post_excerpt );
		}
		
		if ( isset( $attachment_caption ) && ! empty( $attachment_caption ) ) {
		    $this->artist = $attachment_caption;
		} else {
		    $this->artist = get_the_author_meta( 'display_name' );
		}

		return $this->artist;
		
	}
	
	
	/**
	 * Get Source
	 *
	 * @since 2.0.0
	 */
	function get_src( $attachment ) {
		
		if ( $attachment ) {
			$attachment_url = '';
			
			if ( 0 == $this->is_attachement_playable( $attachment->ID ) ) {
				$external_url = $this->get_external_url( $attachment->ID );
				
				if ( $external_url ) {
					$this->src = $external_url;
				} else {
					$this->src = wp_get_attachment_url( $attachment->ID );
				}
			} else {
				$this->src = '';
			}
			
		} else {
		    $this->src = $this->get_default_audio();
		}
		
		return $this->src;
		
	}


	/**
	 * Get Title
	 *
	 * @since 2.0.0
	 */
	function get_title( $attachment ) {
	
		if( $attachment ) {
			$attachment_title = apply_filters( 'the_title', $attachment->post_title );
		}
			
		if( isset( $attachment_title ) && ! empty( $attachment_title ) ) {
		    $this->title = $attachment_title;
		} else {
		    $this->title = __( 'No Title', 'hoon' );
		}
		
		return $this->title;
		
	}


	/**
	 * Increment Track Number
	 *
	 * @since 2.0.0
	 */
	function increment_number() {
	
		return $this->number++;
		
	}
	
	
	/**
	 * Default Audio URL
	 *
	 * @since 2.0.0
	 */
	function get_default_audio() {
	
		return get_template_directory_uri() . '/images/default-audio.mp3';
		
	}
	
	
	/**
	 * Get External URL
	 *
	 * @since 2.1.0
	 *
	 * @param int $post_id Optional. Post ID.
	 * @return string
	 */
	function get_external_url( $attachment_id = null ) {
	
		$attachment_id = ( null === $attachment_id ) ? get_the_ID() : $attachment_id;
		return get_post_meta( $attachment_id, 'atd_p75_external_url', true );
		
	}
	
	
	/**
	 * Is Attachement Playable?
	 *
	 * @since 2.1.0
	 *
	 * @param int $post_id Optional. Post ID.
	 * @return string
	 */
	function is_attachement_playable( $attachment_id = null ) {
	
		$attachment_id = ( null === $attachment_id ) ? get_the_ID() : $attachment_id;
		return get_post_meta( $attachment_id, 'atd_p75_playable', true );
		
	}


	/**
	 * Get Audio Attachements
	 *
	 * Retrieve all audio attachements for a post
	 *
	 * @since 2.0.0
	 */
	function get_audio_attachments() {
	
		return get_children( array(
		    'post_parent'    => $this->id,
		    'post_type'      => 'attachment',
		    'post_mime_type' => 'audio',
		    'post_status'    => null,
		    'numberposts'    => -1,
		    'order'          => 'ASC',
		    'orderby'        => 'menu_order'
		) );
		
	}


	/**
	 * Create Track
	 *
	 * Create a track object with it's unique info
	 *
	 * @since 2.0.0
	 */
	function track( $attachment = false ) {
	
		return array( 
			'number' => absint( $this->number ),
			'title'  => esc_attr( strip_tags( $this->get_title( $attachment ) ) ),
			'artist' => esc_attr( strip_tags( $this->get_artist( $attachment ) ) ),
			'album'  => esc_attr( strip_tags( $this->get_album( $attachment ) ) ),
			'poster' => esc_url( $this->get_artwork( $attachment ) ),
			'mp3'    => esc_url( $this->get_src( $attachment ) )
		);
		
	}
	
	
	/**
	 * Create Playlist
	 *
	 * Create a playlist of all tracks
	 *
	 * @since 2.0.0
	 */
	function tracks() {
	
		$attachments = $this->get_audio_attachments();
		
		if ( $attachments ) :
		    foreach ( $attachments as $attachement ) : 
		    	$this->increment_number();
		    	$this->tracks[] = $this->track( $attachement );
		    endforeach;
		else : 
		    $this->tracks[] = $this->track();
		endif;
		
		return $this->tracks;
		
	}
}

?>