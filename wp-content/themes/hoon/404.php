<?php get_header() ?>

<section id="uncontained">
	<div class="row">
		<div class="<?php echo esc_attr( hoon_main_column_width() ); ?>">
			<h1 class="page-title"><?php _e( '404: Page Not Found', 'hoon' ); ?></h1>
			<div>
				<p><?php _e( 'We are terribly sorry, but the URL you typed no longer exists. It might have been moved or deleted. Try searching the site:', 'hoon' ); ?></p>
				<?php get_search_form(); ?>
			</div>
		</div>
	</div>
</section><!-- #content -->

<?php get_footer() ?>

