<?php
/**
 * Category ID's
 *
 * Create categories array to be used in query.
 * We are going to skip any images, audio, galleries etc,
 * that might set in the events category by setting its ID
 * to a negative value. This will then exclude those posts 
 * from the specific format gallery.
 */
 
/* Theme Options */
$events_cat_option = hoon_option( 'events_category' );

/* Define categories variable as an arry */
$categories = array();

/** 
 * If events category is set, give that a negative value to
 * exclude it gallery blocks display.
 */
if ( isset( $events_cat_option ) && absint( $events_cat_option ) ) {
	$categories[] = 0 - $events_cat_option;
}

/* Custom Post Meta Options */
$meta = hoon_get_custom_post_meta();
$categories[] = ( isset( $meta['post_categories'] ) && ! empty( $meta['post_categories'] ) ) ? implode( ',', $meta['post_categories'] ) : null;

/* Determine template and set type */
if ( is_page_template( 'template-suppliers.php' ) ) :
    $type = 'suppliers';
endif;

/* Get template arguments based on $type for query and column display */
$template_args = hoon_get_template_args( $type, $meta );
extract( $template_args );

/* Query posts from query args */
$supplier_query = new WP_Query( array(
    'posts_per_page'   => -1,
	'post_type' => 'supplier'
) );

$post_count = 0;

/* Display posts */


	while ( $supplier_query->have_posts() ) : $supplier_query->the_post();
		
		// Basic check to skip posts that do not have a featured image,
		// though they are set as an image post format
			
		$class = hoon_get_columns_class_name( $columns );
		$class .= ' columns entry gallery-block';
		$class .= ( $post_count >= $supplier_query->post_count ) ? ' end' : '';
		
		
		?>
			<article id="post-<?php the_ID(); ?>" class="<?php echo $class; 
			echo ' ';
			echo print_the_terms('supplier-type', ' '); ?>">
				<?php get_template_part( 'content', 'template-supplier' ); ?>
			</article>
		
		<?php
		$post_count++;
		 
		
		
		
	endwhile;
	
?>