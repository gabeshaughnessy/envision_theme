<?php global $post; 
$grid_posts = get_field('portfolio_posts');

if(isset($grid_posts) && !empty($grid_posts)) :
$i = 0;
?>
<div class="outer container">
	<div class="post-grid-wrapper">
		<ul class="post-grid">
			<?php
foreach ($grid_posts as $post) :
	if(!is_front_page() || is_front_page() && $i < 6) :
?>


			<?php get_template_part('template-parts/post-grid-post');?>

<?php 
endif;
$i++;
endforeach;
?>
		</ul>
	</div>
</div>
<?php
endif; 
?>