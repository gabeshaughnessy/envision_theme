<?php
/**
 * Template Name: Uncontained - With Page Title
 * Description: A page tempalte where the content is not contained by a border and the page title is displayed.
 *
 * @package WordPress
 * @subpackage Hoon
 * @since 1.0
 */
	
get_header(); ?>

	<section id="uncontained" class="has-title">
	
		<div class="row">
		
			<div class="<?php echo esc_attr( hoon_main_column_width() ); ?>">
				
				<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'twelve columns entry' ); ?>>    
				    <div class="entry-content">
				    	<?php get_template_part( 'partials/post', 'title' ); ?>
				    	<?php get_template_part( 'partials/post', 'content' ); ?>
				    </div>
				</article>
				<?php endwhile; ?>
			
			</div>
			
		</div><!-- .row -->
		
	</section><!-- #content -->

<?php get_footer(); ?>