<?php
/*
Template Name: Suppliers
*/
?>
<?php get_header() ?>

<div class="row">
	
	<section id="content" class="<?php echo esc_attr( hoon_main_column_width() ); ?>">
	
		<div class="row">
			<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'twelve columns entry' ); ?>>			    
    			
    			<div class="entry-header">
    				<?php get_template_part( 'partials/post', 'header' ); ?>
    			</div>
			    
				<div class="entry-content">
			    	<?php get_template_part( 'partials/post', 'title' ); ?>
			    	<?php get_template_part( 'partials/post', 'content' ); ?>
		    	<div class="row panel filter-menu-container">
		    	<ul id="profile-filter" class="filter-menu">
		    	<?php echo isotope_filter_menu('supplier-type'); ?>
		    	</ul>
		    	</div>
		    	
		    	<div class="row filter-target suppliers-container">
			    	<?php get_template_part( 'loop', 'suppliers' ); ?>
		    	</div>
			    
			    </div>
			    <?php if ( comments_open() || pings_open() ) {
			    	get_template_part( 'partials/post', 'meta' ); 
			    } ?>
			    
			</article><!-- #post-<?php the_ID(); ?> -->				
	    	<?php endwhile; ?>
	    
		</div><!-- .row -->
		
	</section><!-- #content -->
	
</div><!-- .row -->

<?php get_footer() ?>

