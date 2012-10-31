<?php
/**
 * Template Name: Format Gallery: Audio
 * Description: A Page Template that displays all Audio post formats in a gallery view.
 *
 * @package WordPress
 * @subpackage Hoon
 * @since 1.0
 */
	
get_header(); ?>

<?php  
$post_class = hoon_main_column_width() . ' audio-gallery gallery-blocks';

if ( hoon_option( 'audio_artwork_animate_spin' ) ) {
	$post_class .= ' animate-spin';
}
?>

<div class="row">

	<section id="content" class="<?php echo esc_attr( $post_class ); ?>">
		
		<div class="row">
			
			<?php the_post(); ?>
			
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'twelve columns entry' ); ?>>			    
    			<div class="entry-header">
    				<?php get_template_part( 'partials/post', 'header' ); ?>
    				<?php get_template_part( 'partials/post', 'audio' ); ?>
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