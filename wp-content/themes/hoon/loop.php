<?php
while ( have_posts() ) : 
	the_post();
    $supported_formats = get_theme_support( 'post-formats' );
    $format = get_post_format();
    $format = ( in_array( $format, $supported_formats[0] ) ) ? $format : '';
    get_template_part( 'format', $format );
endwhile;
?>
