<?php
/**
 * Template Name: Format Gallery: Image & Gallery
 * Description: A Page Template that displays all Gallery post formats in a gallery view.
 *
 * @package WordPress
 * @subpackage Hoon
 * @since 1.0
 */
	
get_header(); ?>

<div class="row">

	<section id="content" class="<?php echo esc_attr( hoon_main_column_width() . ' gallery-gallery gallery-blocks' ); ?>">
	
		<div class="row">
			<?php the_post(); ?>
			
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'twelve columns entry' ); ?>>			    
    			<div class="entry-header">
    				<?php get_template_part( 'partials/post', 'header' ); ?>
    			</div><!-- .entry-header -->
	    		
	    		<div class="entry-content clearfix">
					<?php edit_post_link( __( '<i class="icon-edit"></i>' ) ); ?>
	    			
					<?php if ( '' != $post->post_content ) : ?>
						<?php get_template_part( 'partials/post', 'content' ); ?>
	    			<?php endif; ?>
	    			
					<div class="blocks">
						<?php get_template_part( 'loop', 'gallery-blocks' ); ?>
					</div><!-- .blocks .row -->
				</div><!-- .entry-content -->
			</article><!-- .entry -->
		
		</div><!-- .row -->

	</section><!-- #content -->
	
</div><!-- .row -->

<?php get_footer() ?>