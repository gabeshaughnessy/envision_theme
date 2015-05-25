<?php
/*
Template Name: Page w/ Hero
*/

get_header();

get_template_part('template-parts/hero');

//ARTICLE
	//PAGE CONTENT
get_template_part('template-parts/page-content');

//if show_contact banner
get_template_part('template-parts/contact-banner');
	
get_footer();

?>