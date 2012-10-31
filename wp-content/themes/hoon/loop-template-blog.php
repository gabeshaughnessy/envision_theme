<?php
$meta = hoon_get_custom_post_meta();
$categories = ( isset( $meta['post_categories'] ) && ! empty( $meta['post_categories'] ) ) ? implode( ',', $meta['post_categories'] ) : null;

$blog_args = array(
    'cat'   => $categories,
    'paged' => hoon_get_paged_query_var()
);

$blog_query = new WP_Query( $blog_args );

// Set $wp_query->max_num_pages to the number of the new WP_Query for pagination purposes.
$wp_query->max_num_pages = $blog_query->max_num_pages;

while ( $blog_query->have_posts() ) : 
	$blog_query->the_post();
    $supported_formats = get_theme_support( 'post-formats' );
    $format = get_post_format();
    $format = ( in_array( $format, $supported_formats[0] ) ) ? $format : '';
    get_template_part( 'format', $format );
endwhile;
?>
