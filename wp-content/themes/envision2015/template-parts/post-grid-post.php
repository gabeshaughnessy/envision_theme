<?php global $post; ?>
<li class="post">
	<?php if (has_post_thumbnail( $post->ID ) ): ?>
		<?php $bg_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' ); ?>
		<a class="post-image" href="<?php the_permalink(); ?>" style="background-image:url('<?php echo $bg_image[0]; ?>');" ></a>
	<?php endif; ?>
	
	<div class="post-details">
		<a class="post-title" href="<?php the_permalink(); ?>" title="view post"><h4 ><?php the_title(); ?></h4></a>


		<?php //get tag list 
			$post_tags = wp_get_post_tags( $post->ID);

			if(isset($post_tags) && !empty($post_tags)){
				echo '<ul class="tag-list">';
		
				foreach ( $post_tags as $tag ) {

				    // The $term is an object, so we don't need to specify the $taxonomy.
				    $tag_link = get_term_link( $tag );
				   
				    // If there was an error, continue to the next term.
				    if ( is_wp_error( $tag_link ) ) {
				        continue;
				    }

				    // We successfully got a link. Print it out.
				    echo '<li class="tag"><a href="' . esc_url( $tag_link ) . '">' . $tag->name . '</a></li>';
				}
				echo '</ul>';
			}
			?>
	</div>
</li>