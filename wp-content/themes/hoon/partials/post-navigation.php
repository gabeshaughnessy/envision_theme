<?php if ( is_single() ) : ?>
<nav id="single-navigation">
    <span class="prev"><?php previous_post_link( '%link', '<i class="icon-chevron-left"></i> ' . __( 'Prev', 'hoon' ) ); ?></span>
    <span class="next"><?php next_post_link( '%link', __( 'Next', 'hoon' ) . ' <i class="icon-chevron-right"></i>' ); ?></span>
</nav><!-- #nav-single -->
<?php endif; ?>  
