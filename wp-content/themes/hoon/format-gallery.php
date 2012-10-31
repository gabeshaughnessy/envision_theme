<article id="post-<?php the_ID(); ?>" <?php post_class( 'twelve columns entry' ); ?>>
    
    <div class="entry-header">
    	<?php get_template_part( 'partials/post', 'header' ); ?>
    	
    	<?php 
    	$featured_slider   = get_post_meta( get_the_ID(), 'featured_gallery', true ); // true/false
    	$featured_carousel = get_post_meta( get_the_ID(), 'featured_carousel', true ); // top/bottom
    	$featured_link     = get_post_meta( get_the_ID(), 'featured_link', true ); // lightbox/image/attachement
		
		if ( 1 == hoon_option( 'slideshow_auto' ) || 'true' == $featured_slider ) :
		    print do_shortcode( sprintf( '[gallery slider=1 carousel="%1$s" link="%2$s"]', 
		        esc_html( $featured_carousel ? $featured_carousel : hoon_option( 'slideshow_auto_carousel' ) ),
		        esc_html( $featured_link ? $featured_link : hoon_option( 'slideshow_auto_links' ) )
		    ) );
		endif; 
		?>
    </div>
    
	<div class="entry-content">
    	<?php get_template_part( 'partials/post', 'title' ); ?>
    	<?php get_template_part( 'partials/post', 'content' ); ?>
    </div>
    
	<?php get_template_part( 'partials/post', 'navigation' ); ?>
	     
</article><!-- #post-<?php the_ID(); ?> -->				
