<?php get_header(); ?>

<div class="row">
	
	<section id="content" class="<?php echo esc_attr( hoon_main_column_width() ); ?>">
		
		<div class="row">
		
			<?php the_post(); ?>
				
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'twelve columns entry' ); ?>>
			
    			<div class="entry-header">
    				<?php get_template_part( 'partials/post', 'header' ); ?>

					<figure class="entry-image">
					    <a href="<?php echo esc_url( wp_get_attachment_url( $post->ID ) ); ?>" title="<?php the_title_attribute(); ?>" class="view" rel="attachment">
					    	<?php
					    	if ( wp_attachment_is_image ( $post->ID ) ) {
					    		$img_src = wp_get_attachment_image_src( $post->ID, hoon_get_image_size() );
					    		$alt_text = get_post_meta( $post->ID, '_wp_attachment_image_alt', true );
					    		
					    		printf(	'<img src="%1$s" alt="%2$s">',
					    			esc_url( $img_src[0] ),
					    			esc_attr__( $alt_text, 'hoon' )
					    		);
					    	} else {
					    		echo basename( $post->guid );
					    	}
					    	?>
					    </a>
					</figure><!-- .entry-image -->
				</div><!-- .entry-header -->
				
				<div class="entry-content">
	    			<?php get_template_part( 'partials/post', 'title' ); ?>
	    			<?php get_template_part( 'partials/post', 'content' ); ?>
				</div><!-- .entry-content -->
				
				<nav id="single-navigation">
				    <ul class="paging">
				        <li class="prev"><?php previous_image_link( 0, '<i class="icon-chevron-left"></i> ' . __( 'Previous', 'hoon' ) ); ?></li>
				        <li class="next"><?php next_image_link( 0, __( 'Next', 'hoon' ) . ' <i class="icon-chevron-right"></i>' ); ?></li>
				        <li class="return"><a href="<?php echo esc_url( get_permalink( $post->post_parent ) ); ?>"><?php _e( 'Return to gallery', 'hoon' ); ?></a></li>
				    </ul>
				</nav>
					
			</article><!-- .attachment -->
			
		</div><!-- .row -->
		
	</section><!-- #content -->
	
</div><!-- .row -->

<div class="row">

	<?php get_template_part( 'partials/post', 'meta' ); ?>

</div>

<?php get_footer(); ?>