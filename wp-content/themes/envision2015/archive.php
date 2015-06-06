<?php
global $post, $post_type;
$post_type = get_post_type($post);

//get_template_part('template-archives/archive-'.$post_type);
get_template_part('template-archives/archive-post');

?>