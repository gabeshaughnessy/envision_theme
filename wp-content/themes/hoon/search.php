<?php get_header(); ?>

<section id="uncontained">
	<div class="row">
		<div class="<?php echo esc_attr( hoon_main_column_width() ); ?>">
			<?php if( have_posts() ) : ?>
				<div id="page-header">
    				<h1 class="archive-title"><?php printf( __( "Search results for <em>%s</em>", "hoon" ), get_search_query() ); ?></h1>
				</div>
			<?php else : ?>
    			<h1 class="archive-title"><?php _e( "No results found&hellip;", "hoon" ); ?></h1>
	    		<p><?php printf( __( 'Sorry, your search for "%s" did not turn up any results.', 'hoon' ), get_search_query() ); ?></p>
	    		<?php get_search_form(); ?>
			<?php endif; ?>
		</div>
	</div>
</section><!-- #content -->

<?php if ( have_posts() ) : ?>
<div class="row">
    <section id="content" class="<?php echo esc_attr( hoon_main_column_width() ); ?>">
    	<?php get_template_part( 'loop' ); ?>
    </section><!--end content-->
</div>
<?php endif ?>

<?php get_footer(); ?>