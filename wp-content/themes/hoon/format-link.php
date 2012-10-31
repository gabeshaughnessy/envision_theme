<article id="post-<?php the_ID(); ?>" <?php post_class( 'twelve columns entry' ); ?>>
    
    <?php get_template_part( 'partials/post', 'header' ); ?>
    
	<div class="entry-content">
    	<?php get_template_part( 'partials/post', 'content' ); ?>
    </div>
    
	<?php get_template_part( 'partials/post', 'navigation' ); ?>
	 	
</article><!-- #post-<?php the_ID(); ?> -->				
