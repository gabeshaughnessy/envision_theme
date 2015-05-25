<?php global $post, $page_query; 
?>

<div class="outer container">
	<div class="section-navigation">
		<ul class="section-link-list">
			<?php
			foreach ($page_query as $page) {
				if($page->have_posts()) : while ($page->have_posts()) : $page->the_post();

				?>
					<li class="section-link">
						<a href="#<?php echo $page->query['pagename']; ?>">
							<?php if(has_post_thumbnail( $post->ID)) : ?>
								<?php $bg_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' ); ?>
								<div class="link-image" style="background-image:url('<?php echo $bg_image[0]; ?>');" ></div>
							<?php endif; ?>
							
							<h3 class="link-title"><?php the_title(); ?></h3>
							<p class="description">
								<?php 
									$desc = get_field('description');
										if(isset($desc) && !empty($desc)){
											echo '<p class="subtitle">'.$desc.'</p>';
											}
								?>
							</p>
						</a>
					</li>
				<?
				endwhile;
				endif;
			}?>
		</ul>
	</div>
</div>