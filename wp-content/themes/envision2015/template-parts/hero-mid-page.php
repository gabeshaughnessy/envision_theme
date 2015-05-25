<?php global $post; ?>
<div class="hero-area mid-page">
	<div class="pre-hero"></div>
	<div class="title-area">
		<div class="contents">
			<h2><?php the_title(); ?></h2>
			<?php
			$desc = get_field('description');
			if(isset($desc) && !empty($desc)){
				echo '<p class="subtitle">'.$desc.'</p>';
				}
			?>
		</div>
	</div>
	<?php if (has_post_thumbnail( $post->ID ) ): ?>
		<?php $bg_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' ); ?>
		<div class="hero-bg"style="background-image: url('<?php echo $bg_image[0]; ?>')"></div>
	<?php endif; ?>
</div>
