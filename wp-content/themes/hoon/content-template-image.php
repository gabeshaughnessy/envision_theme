<?php /* Must have featured image to show */ ?>
<?php if ( has_post_thumbnail() ) : ?>
	<figure class="entry-thumbnails">
	    <?php
	    $thumbnail = wp_get_attachment_image_src ( get_post_thumbnail_id( get_the_ID() ), 'large' );
	    printf(
	    	'<a href="%1$s" title="%2$s" class="view" rel="template-images">%3$s</a>',
	    	esc_url( $thumbnail[0] ),
	    	esc_attr( get_the_title() ),
	    	get_the_post_thumbnail( get_the_ID(), 'post-thumbnail' )
	    );
	    ?>	
	</figure>
	
	<hgroup class="details">
	    <h5>
	    	<a class="post-link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
	    		<?php the_title(); ?>
	    	</a>
	    </h5>
	</hgroup>
<?php endif; ?>
