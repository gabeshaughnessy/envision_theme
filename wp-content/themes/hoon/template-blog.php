<?php
/*
Template Name: Blog
*/
?>

<?php get_header(); ?>

<div class="row">
	
	<section id="content" class="<?php echo esc_attr( hoon_main_column_width() ); ?>">
		
		<div class="row">
			<?php get_template_part( 'loop', 'template-blog' ); ?>
		</div><!-- .row -->
	
	</section><!-- #content -->
	
	<?php get_template_part( 'partials/page', 'pagination' ); ?>	

</div><!-- .row -->

<?php get_footer(); ?>