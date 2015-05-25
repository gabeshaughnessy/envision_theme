<?php
global $post, $post_type;
if(!isset($post_type)){
	$post_type = get_post_type($post);
}

require_once('template-archives/archive-'.$post_type.);

?>