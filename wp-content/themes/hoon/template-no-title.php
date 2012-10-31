<?php
/**
 * Template Name: No Page Title
 * Description: A page tempalte where the content is contained but no title
 *
 * @package WordPress
 * @subpackage Hoon
 * @since 1.0
 */
	
get_header(); ?>
<div class="row">
	<section id="content" class="<?php echo esc_attr( hoon_main_column_width() ); ?>">
		
		<div class="row">
			<div class="<?php echo esc_attr( hoon_main_column_width() ); ?>">
		
				<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'twelve columns entry' ); ?>>    
					<div class="entry-content">
					    <?php edit_post_link( __( '<i class="icon-edit"></i>' ) ); ?>
					    <?php get_template_part( 'partials/post', 'content' ); ?>
					</div>
				</article>
				<?php endwhile; ?>
		
			</div>
		</div><!-- .row -->
	
	</section><!-- #content -->
</div><!-- .row -->

<?php get_footer(); ?>