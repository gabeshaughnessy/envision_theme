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
if ( is_page_template( 'template-images-galleries.php' ) ) :
    $type = 'image-gallery';
elseif ( is_page_template( 'template-images.php' ) ) :
    $type = 'image';
elseif ( is_page_template( 'template-galleries.php' ) ) :
    $type = 'gallery';
elseif ( is_page_template( 'template-audio.php' ) ) :
    $type = 'audio';
elseif ( is_page_template( 'template-videos.php' ) ) :
    $type = 'video';
endif;

/* Get template arguments based on $type for query and column display */
$template_args = hoon_get_template_args( $type, $meta );
extract( $template_args );

/* Query posts from query args */
$gallery_query = new WP_Query( array(
    'posts_per_page'   => -1,
	'cat'              => implode( ',', $categories ),
    'tax_query'        => array(
    	array (
    		'taxonomy' => 'post_format',
    		'field'    => 'slug',
    		'terms'    => $tax_query_term,
    	)
  	)
) );

$post_count = 0;

/* Display posts */

if ( ! $gallery_query->have_posts() ) :
	printf( '<div class="block row"><p class="no-posts">%s</p></div>', __( 'No posts found.', 'hoon' ) );
else :
	while ( $gallery_query->have_posts() ) : $gallery_query->the_post();
		
		// Basic check to skip posts that do not have a featured image,
		// though they are set as an image post format
		if ( ( 'image' == $type ) && ! has_post_thumbnail() )
			continue;
			
		$class = hoon_get_columns_class_name( $columns );
		$class .= ' columns entry gallery-block';
		$class .= ( $post_count >= $gallery_query->post_count ) ? ' end' : '';
		
		if ( $post_count % $columns == 0 ) 
			echo '<div class="row">';
		?>
		
			<article id="post-<?php the_ID(); ?>" <?php post_class( $class ) ?>>
				<?php get_template_part( 'content', 'template-' . $term ); ?>
			</article>
		
		<?php
		$post_count++;
		 
		// Close row
		if ( $post_count % $columns == 0 ) 
			echo '</div><!-- end row -->';
		
	endwhile;
	
	if ( ( $columns > 0 ) && ( $post_count % $columns !== 0 ) ) 
		echo '</div><!-- end .row -->';
		
endif;
?>