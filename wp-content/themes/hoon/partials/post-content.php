<?php

/**
 * The Content
 *
 */
if( is_page_template( 'template-blog.php' ) || ! is_singular() ) {
	global $more; $more = 0;
}
?>

<div class="posted-content">
	<?php the_content( sprintf( '<span class="moretext">%1$s</span>', __( '&hellip; Continue Reading', 'hoon' ) ) ); ?>
</div>


<?php
/**
 * Page Links
 *
 */
wp_link_pages( array(
    'before' => sprintf( '<p class="pagelinks"><span>%s</span><br />', __( 'Pages:', 'hoon' ) ),
    'after' => '</p>',
    'link_before' => '<span class="page-numbers">',
    'link_after' => '</span>'
) ); ?>


<?php 
/**
 * Posted In
 *
 */
if ( 'post' == get_post_type() ) :
	printf( '<div class="posted-in">%s</div>', hoon_posted_in() );
endif; ?>