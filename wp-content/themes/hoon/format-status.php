<article id="post-<?php the_ID(); ?>" <?php post_class( 'twelve columns entry' ); ?>>    
	
	<div class="entry-content">
		<?php get_template_part( 'partials/post', 'sharing' ); ?>
		
		<figure class="status-avatar">
		    <?php echo get_avatar( get_the_author_meta( 'user_email' ), $size = '50' ); ?>
		</figure>
		
		<div class="status-text">
		    <?php get_template_part( 'partials/post', 'content' ); ?>
		    
			<?php if ( 'post' == get_post_type() ) : ?>
			<div class="posted-on">
			    <?php hoon_posted_on(); ?>
			</div>
			<?php endif; ?>
		
		</div>
    </div>
    
	<?php get_template_part( 'partials/post', 'navigation' ); ?>
	 
</article><!-- #post-<?php the_ID(); ?> -->				
