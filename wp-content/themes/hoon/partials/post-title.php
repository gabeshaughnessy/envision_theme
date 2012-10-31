<?php get_template_part( 'partials/post', 'sharing' ); ?>

<?php edit_post_link( '<i class="icon-edit"></i>' ); ?>

<h1 class="entry-title">
    <?php
    $link_it =  is_singular() && ! is_page_template( 'template-blog.php' ) ? false : true;
    
    printf( '%1$s<span>%2$s</span>%3$s',
    	$link_it ? sprintf( '<a href="%1$s" title="%2$s">', get_permalink(), the_title_attribute( array( 'echo' => 0 ) ) ) : '',
    	get_the_title(),
    	$link_it ? '</a>' : ''
    );
    ?>
</h1>

<?php if ( 'post' == get_post_type() ) : ?>
<div class="posted-on">
    <?php hoon_posted_on(); ?>
        
    <?php if ( hoon_option( 'post_comments_meta' ) || comments_open() ) : ?>
    <div class="comment-count">
		<span class="sep">&middot;</span>
		<a class="" href="<?php the_permalink() ?>/?comment_posted=1#comments" title="View Comments"><i class="icon-comment-alt"></i> <?php echo get_comments_number() ?></a>
    </div>
    <?php endif; ?>
         
	<?php if ( hoon_option( 'like_it_up' ) ) : ?>
	<div class="like-it-up">
		<span class="sep">&middot;</span>
	    <?php
	    if ( Like_It_Up::get_post_cookie( get_the_ID() ) ) {
	    	$like_class = ' liked';
	    } else {
	    	$like_class = ' unliked';
	    }
	
	    printf( '<a href="#" id="%1$s-%3$s" data-post-id="%3$s" class="rate-up sharing-link %2$s" title="%1$s"><i class="heart icon-heart-empty"></i><span class="post-rating"></span></a>', 
	    	esc_attr__( 'Like', 'hoon' ),
	    	esc_attr( $like_class ),
	    	esc_attr( get_the_ID() )
	    );
	    ?>
	</div>
	<?php endif; ?>
</div>
<?php endif; ?>
