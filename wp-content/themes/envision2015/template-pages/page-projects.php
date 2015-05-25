<?php
/*
Template Name: Project Portfolio
*/

get_header();

//HERO AREA
	//TITLE
	//SUB-TITLE (BLOG DESCRIPTION)
	//BG-IMAGE

//ARTICLE
	//LEAD
	//CALL TO ACTION
	//PROJECT GALLERY
		//FILTER MENU
		//PROJECTS (paged)
			//PROJECT
				//THUMBNAIL
				//TITLE
				//TAGS - suppliers
				//PERMALINK
	//NEXT PREV LINKS
get_template_part('template-parts/hero');
get_template_part('template-parts/lead');
get_template_part('template-parts/post-grid');
get_template_part('template-parts/contact-banner');

get_footer();

?>