<?php
/*
Template Name: Contact Page
*/

get_header();

get_template_part('template-parts/hero');
get_template_part('template-parts/lead'); 
get_template_part('template-parts/contact-details');
get_template_part('template-parts/page-content');
get_template_part('template-parts/map-and-form-banner');
?>
<div class="row dark-blue-wrapper">
	<?php
	get_template_part('template-parts/social-profile-banner'); 
	?>
</div>
<?php
	
get_footer();

?>