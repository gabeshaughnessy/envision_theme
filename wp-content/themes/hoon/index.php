<?php get_header() ?>

<div class="row">

	<section id="content" class="blog <?php echo esc_attr( hoon_main_column_width() ); ?>">
		
		<div class="row">
		
			<?php get_template_part( 'loop' ); ?>
			
		</div>
	
	</section><!-- #content -->
	
	<?php get_template_part( 'partials/page', 'pagination' ); ?>	
</div>

<?php get_footer() ?>

