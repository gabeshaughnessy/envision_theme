<?php
/*
Template Name: Home Page
*/

get_header();
global $post;

$page_query = array();

$section_pages = array();

$sections = get_field('section_links');
if(isset($sections) && !empty($sections)){
	foreach ($sections as $section) {
		$section_image = $section['link_image'];
		$linked_page = $section['linked_page'];
		if(isset($linked_page) && !empty($linked_page[0])){

			$current_page = $linked_page[0]->post_name;
			$page_query[$current_page] = new WP_Query(array('pagename' => $current_page));
			$section_pages[] = $current_page;

		}

	}
}
get_template_part('template-parts/hero');
get_template_part('template-parts/lead');
get_template_part('template-parts/section-links');



//switch page
$current_post = $page_query[$section_pages[0]];
if($current_post->have_posts()) : while($current_post->have_posts()) : $current_post->the_post();
	echo '<div id="'.$current_post->query['pagename'].'">';
		get_template_part('template-parts/hero-mid-page');
		get_template_part('template-parts/lead');
		get_template_part('template-parts/post-grid');
		get_template_part('template-parts/call-to-action');
	echo '</div>';
endwhile;
endif;


//switch page

$current_post = $page_query[$section_pages[1]];

if($current_post->have_posts()) : while($current_post->have_posts()) : $current_post->the_post();
	echo '<div id="'.$current_post->query['pagename'].'">';
		get_template_part('template-parts/hero-mid-page-medium-blue');
		get_template_part('template-parts/about-us-content');
	endwhile;
	echo '</div>';
endif;	

//switch page
$current_post = $page_query[$section_pages[2]];
if($current_post->have_posts()) : while($current_post->have_posts()) : $current_post->the_post();
	echo '<div id="'.$current_post->query['pagename'].'">';
		get_template_part('template-parts/hero-mid-page-dark-blue');
		get_template_part('template-parts/contact-content');
	echo '</div>';		
endwhile;
endif;
	
get_footer();

?>