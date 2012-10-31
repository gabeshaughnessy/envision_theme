<?php
$meta = array(
    'author'   => hoon_option( 'post_author_meta' ),
    'comments' => hoon_option( 'post_comments_meta' ),
    'recent'   => hoon_option( 'post_related_meta' ),
    'popular'  => hoon_option( 'post_popular_meta' )
);

foreach ( (array) $meta as $option ) {
    if ( ! $option ) {
    	$meta_enabled = true;
    	break;
    }
}

if ( isset( $meta_enabled ) ) :
?>

<section id="meta" class="section-meta <?php echo esc_attr( hoon_main_column_width() ); ?>">

	
		<?php  
		/**
		 * Meta Tab Menu
		 *
		 */
		?>
		
	<ul class="tabs">
	    <?php if ( ! is_page() && ! $meta['author'] ) : ?>
	    	<li><?php echo hoon_author_meta_link() ?></li>
	    <?php endif; ?>
	    
	    <?php if ( is_single() && ! is_attachment() && ! $meta['recent'] ) : ?>
	    	<li><?php echo hoon_related_posts_link() ?></li>
	    <?php endif; ?>
	    
	    <?php if ( ! is_page() && ! $meta['popular'] ) : ?>
	    	<li><?php echo hoon_popular_posts_link() ?></li>
	    <?php endif; ?>
	    
	    <?php if ( is_singular() && ! $meta['comments'] && ( comments_open() || pings_open() ) ) : ?>
	    	<li><?php echo hoon_comments_meta_link() ?></li>
	    <?php endif; ?>   
	
	</ul>
	
	
	

	<?php  
	/**
	 * Meta Tab Content
	 *
	 */
	?>
	<ul class="tabs-content">
	    
	    <?php  
	    /**
	     * Author Meta
	     *
	     */
	    $active = hoon_comment_posted() ? '' : hoon_is_active_meta_tab( 'author' ); ?>
	    
	    <li id="author-<?php echo get_the_ID() ?>-tab" class="author-meta <?php echo esc_attr( $active ); ?>">
	    
	    	<figure class="author-avatar">
	    	    <?php echo get_avatar( get_the_author_meta( 'ID' ), 60 ); ?>
	    	</figure>
	    	
	    	<?php if( get_the_author_meta( 'description' ) ) : ?>
	    	<p class="author-description">
	    	    
	    	    <?php the_author_meta( 'description' ); ?>
	    	    
	    	    <span class="author-links">
	    	    	<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php _e( 'View Posts', 'hoon' ); ?></a>
	    	    	
	    	    	<?php if( get_the_author_meta( 'user_url' ) ) : ?>
	    	    		<span class="sep"><!-- nothing to see here --></span>
	    	    		<a href="<?php esc_url( the_author_meta( 'user_url' ) ); ?>"><?php _e( 'Visit Website &rarr;', 'hoon' ); ?></a>
	    	    	<?php endif; ?>
	    	    </span>
	    	
	    	</p>
	    	<?php endif; ?>
	    		
	    </li>
	    
	    
	    <?php  
	    /**
	     * Related Posts
	     *
	     */
	    if ( is_single() && ! is_attachment() ) : ?>
	    
	    	<?php $active = hoon_comment_posted() ? '' : hoon_is_active_meta_tab( 'related' ); ?>
	    	
	    	<li id="related-<?php echo get_the_ID() ?>-tab" class="related-meta <?php echo esc_attr( $active ); ?>">
	    		<ul>
	    		    <?php hoon_related_posts_content() ?>
	    		</ul>
	    	</li>
	    
	    <?php endif; // end ! is_page check ?>
	    
	    
	    <?php  
	    /**
	     * Popular
	     *
	     */
	    if ( ! is_page() ) : ?>
	    	
	    	<?php $active = hoon_comment_posted() ? '' : hoon_is_active_meta_tab( 'popular' ); ?>
	    	
	    	<li id="popular-<?php echo get_the_ID() ?>-tab" class="popular-meta <?php echo esc_attr( $active ); ?>">
	    		<ul>
	    		    <?php hoon_popular_posts_content() ?>
	    		</ul>
	    	</li>
	    	
	    <?php endif; // end ! is_page check ?>
	    
	    
	    <?php  
	    /**
	     * Comments
	     *
	     */
	    if ( is_singular() && ( comments_open() || pings_open() ) ) : ?>
	    	
	    	<?php $active = hoon_comment_posted() ? 'active' : hoon_is_active_meta_tab( 'comments' ); ?>
	    	
	    	<li id="comments-<?php echo get_the_ID() ?>-tab" class="comments-meta <?php echo esc_attr( $active ); ?>">
	    		<?php comments_template( '', true ); ?>
	    	</li>
	    
	    <?php endif; ?>
	    
	    
	    
	</ul>

</section>
<?php endif; // end $meta_enabled check ?>

