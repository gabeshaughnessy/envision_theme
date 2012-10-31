<?php
/**
 * Template Name: Widgets
 * Description: This page template displays the Widgets Page Template widget area.
 *
 * @package WordPress
 * @subpackage Hoon
 * @since 1.0
 */
get_header(); ?>

<div class="row">

	<section id="content" class="<?php echo esc_attr( hoon_main_column_width() . ' gallery-blocks' ); ?>">
		
		<div class="row">
			<?php the_post(); ?>
			
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'twelve columns entry' ); ?>>			    
    			
    			<div class="entry-header">
    				<?php get_template_part( 'partials/post', 'header' ); ?>
    			</div>
	    	
	    		<div class="entry-content">
					<?php if( $post->post_content != '' ) : ?>
						<?php get_template_part( 'partials/post', 'content' ); ?>
	    			<?php endif; ?>
	    			
					<?php get_sidebar( 'template-widgets' ); ?>
				</div>
			</article>
		</div><!-- .row -->
		
	</section><!-- #content -->

</div><!-- .row -->

<?php get_footer() ?>