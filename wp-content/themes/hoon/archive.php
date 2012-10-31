<?php get_header(); ?>

<section id="uncontained">
	
	<div class="row">
		
		<div class="<?php echo esc_attr( hoon_main_column_width() ); ?>">
			
			<?php if ( have_posts() ) : ?>
				<?php the_post(); ?>
				<div id="page-header">
					<h1 class="archive-title"><?php hoon_archives_title(); ?></h1>
					
					<?php if ( is_category() ) : ?>
						<div class="archive-list">
							<h4><?php _e( 'Choose another category?', 'hoon' ); ?></h4>
							<ul>
								<?php wp_list_categories( 'hide_empty=1&title_li=&hierarchical=0' ); ?>
							</ul>
						</div>
					<?php elseif ( is_tag() ) :?>
						<div class="archive-list">
							<h4><?php _e( 'Choose another tag?', 'hoon' ); ?></h4>
							<?php the_tags( '<ul><li>', '</li><li>', '</li></ul>' ); ?>
						</div>
					<?php endif; ?>
					
					<?php rewind_posts(); ?>
				</div>
			<?php endif; ?>
		
		</div>
	
	</div><!-- .row -->
	
</section><!-- #uncontained -->

<div class="row">
	<section id="content" class="<?php echo esc_attr( hoon_main_column_width() ); ?>">
		<?php get_template_part( 'loop' ); ?>
	</section><!--end content-->
	
	<?php get_template_part( 'partials/page', 'pagination' ); ?>	
</div>

<?php get_footer(); ?>