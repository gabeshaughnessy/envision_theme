<div class="entry-thumbnails">
	<?php
	// Display one image for image post formats
	if ( has_post_format( 'image' ) ) :

    	$image_total = 1; 
        $thumbnail = wp_get_attachment_image_src ( get_post_thumbnail_id( get_the_ID() ), 'large' );
    	
    	printf(	'<a href="%1$s" title="%2$s" class="view">%3$s</a>',
    		esc_url( $thumbnail[0] ),
    		esc_attr( get_the_title() ),
    		get_the_post_thumbnail( get_the_ID(), 'post-thumbnail' )
    	);

	// Get and loop through gallery of images
	else :
	
		// Get images for post and add them to $gallery
		if ( $images = get_children( array(
			'post_parent'    => get_the_ID(),
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => 'ASC',
			'orderby'        => 'menu_order',
			'numberposts'    => 999
		) ) ) :
		
			$image_block = 4;
			$image_total = count( $images );
			$image_columns = 2;
			$image_count = 0;

			foreach ( (array) $images as $image ) :
				
				if ( $image_count == $image_block ) 
					break;
				
				if ( isset( $image->ID ) ) :
				    echo wp_get_attachment_image( $image->ID, 'thumbnail' );
				else :
				    printf( 
				    	'<img src="%1$s" alt="%2$s" width="150" height="150" />',
				    	esc_url( get_template_directory_uri() . '/images/blank.gif' ),
				    	esc_attr__( 'blank', 'hoon' )
				    ); 
				endif;
				    
				++$image_count;
				    
			endforeach; 
			
		endif; // end images check
		
    endif; // end has_post_format(image) 
    ?>
</div><!-- .entry-thumbails -->
	
<hgroup class="details">
    <h5>
    	<a class="post-link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
    		<?php the_title(); ?>
    	</a>
    </h5>
    
    <h6>
    	<?php
    	printf( '%1$s %2$s',
    		__( absint( $image_total ), 'hoon' ),
    		_n( 'Image', 'Images', $image_total, 'hoon' )
    	);
    	?>
    </h6>
</hgroup><!-- .details -->
