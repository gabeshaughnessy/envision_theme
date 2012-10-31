<article id="post-<?php the_ID(); ?>" <?php post_class( 'twelve columns entry' ); ?>>
    
    <div class="entry-header">
    	<?php get_template_part( 'partials/post', 'header' ); ?>
    	
    	<?php if ( has_post_thumbnail() ) : ?>
		<figure class="entry-media">
		    <?php
		    /**
		     * Featured Image Link
		     *
		     * Determine how, if at all, the featured image should be linked.
		     * First we'll check for a custom field. If the custom field is\
		     * provided, we'll use that link. If not, we'll use the option
		     * set within the Theme Options.
		     *
		     * By default, the featured image will link to the post. If the
		     * custom meta option is provided, it will trump any Theme Options set.
		     */
		    if ( ( $featured_image_link = get_post_meta( get_the_ID(), 'featured_image_link', true ) ) ) :
		    	$link = $featured_image_link;
		    	$link_option = 'custom';
		    else :
		    	$link_option = hoon_option( 'image_featured_links', 'post' );
		    	
		    	switch ( $link_option ) :
		    		case 'none' :
		    			$link = '#';
		    			break;
		    		case 'view' :
		    			$thumbnail = wp_get_attachment_image_src ( get_post_thumbnail_id( get_the_ID() ), 'large' );
		    			$link = $thumbnail[0];
		    			break;
		    		case 'file' :
		    			$thumbnail = wp_get_attachment_image_src ( get_post_thumbnail_id( get_the_ID() ), 'large' );
		    			$link = $thumbnail[0];
		    			break;
		    		case 'post' :
		    			$link = is_single() ? '#' : get_permalink();
		    			break;
		    	endswitch;
		    endif;
		    
		    printf( '<a href="%1$s" title="%2$s" %4$s>%3$s</a>',
		    	esc_url( $link ),
		    	esc_attr( get_the_title() ),
		    	get_the_post_thumbnail( get_the_ID(), hoon_get_image_size() ),
		    	'custom' == $link_option ? 'target="_blank"' : 'class="' . esc_attr( $link_option ) . '"'
		    );
		    ?>
		</figure>
		<?php endif; ?>
    </div>
    
	<div class="entry-content">
    	<?php get_template_part( 'partials/post', 'title' ); ?>
    	<?php get_template_part( 'partials/post', 'content' ); ?>
    </div>
    
</article><!-- #post-<?php the_ID(); ?> -->				
