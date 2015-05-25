<?php global $post;
$grid_posts = get_field('portfolio_posts');

if(isset($grid_posts) && !empty($grid_posts)) :
$i = 0;
foreach ($grid_posts as $post) :
	if(!is_front_page() || is_front_page() && $i < 6) :
		error_log('front_page');
?>

<li class="post">
	<?php if (has_post_thumbnail( $post->ID ) ): ?>
		<?php $bg_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' ); ?>
		<a class="post-image" href="<?php the_permalink(); ?>" style="background-image:url('<?php echo $bg_image[0]; ?>');" ></a>
	<?php endif; ?>
	
	<div class="post-details">
		<a class="post-title" href="<?php the_permalink(); ?>" title="view post"><h4 ><?php the_title(); ?></h4></a>
		
		<ul class="tag-list">
			<li class="tag">
				<a href="tag-link" title="filter by tag">Kitchen</a>
			</li>
			<li class="tag">
				<a href="tag-link">Dining</a>
			</li>
			<li class="tag">
				<a href="tag-link">Marble</a>
			</li>
			<li class="tag">
				<a href="tag-link">Concrete</a>
			</li>
			<li class="tag">
				<a href="tag-link">Wood</a>
			</li>
			<li class="tag">
				<a href="tag-link">Linoleum</a>
			</li>
			<li class="tag">
				<a href="tag-link">Badger Hide</a>
			</li>

		</ul>
	</div>
</li>

<?php 
endif;
$i++;
endforeach;
endif; ?>