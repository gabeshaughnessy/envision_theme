<article id="post-<?php the_ID(); ?>" <?php post_class( 'twelve columns entry' ); ?>>
    
    <div class="entry-header">
    	<?php get_template_part( 'partials/post', 'header' ); ?>
    </div>
    
	<div class="entry-content">
    	<?php get_template_part( 'partials/post', 'title' ); ?>
    	<?php get_template_part( 'partials/post', 'content' ); ?>
    </div>
    
	<?php get_template_part( 'partials/post', 'navigation' ); ?>
    
</article><!-- #post-<?php the_ID(); ?> -->				
