<?php 
global $post;

$post_type = get_post_type($post->ID);

if($post_type == 'post'){
	get_template_part('template-singles/single-post');
	} else if($post_type == 'supplier'){
		get_template_part('template-singles/single-supplier');
		}
?>