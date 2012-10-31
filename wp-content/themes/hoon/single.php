<?php get_header(); ?>

<div class="row">

	<section id="content" class="<?php echo esc_attr( hoon_main_column_width() ); ?>">
			
		<div class="row">
		
			<?php get_template_part( 'loop' ); ?>
		
		</div>

	</section><!-- #content -->

</div>

<?php if ( is_single() ) : ?>
<div class="row">

	<?php get_template_part( 'partials/post', 'meta' ); ?>

</div>
<?php endif; ?>
    

<?php get_footer() ?>

