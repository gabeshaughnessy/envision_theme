<figure class="entry-thumbnails play-player">
    <?php if ( has_post_thumbnail() ) { ?>
        <?php the_post_thumbnail( 'post-thumbnail' ); ?>
    <?php } else { ?>
        <img src="<?php echo get_template_directory_uri(); ?>/images/default-artwork.png" alt="<?php esc_attr_e( 'Default Album Artwork', 'hoon' ); ?>">
    <?php } ?>
</figure>

<hgroup class="details">
    <h5>
    	<a class="post-link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
    		<?php the_title(); ?>
    	</a>
    </h5>
    <h6><?php echo get_the_time( 'Y' ); ?></h6>
</hgroup>
