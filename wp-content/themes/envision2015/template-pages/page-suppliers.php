<?php
/*
Template Name: Suppliers Page
*/
get_header();

get_template_part('template-parts/hero');
get_template_part('template-parts/lead');
get_template_part('template-parts/page-content');

//for each post in the supplier archive:
$args = array(
'post_type' => 'supplier',
'posts_per_page'   => -1
	);
$supplierQuery = new WP_Query($args);
?>
<div class="outer container">
	<div class="post-grid-wrapper">
		<ul class="post-grid supplier-grid">

<?php
if($supplierQuery->have_posts()) : while($supplierQuery->have_posts()) : $supplierQuery->the_post();
get_template_part('template-parts/post-grid-supplier');
endwhile;
endif;
?>
		</ul>
	</div>
</div>
<?php
//contact banner

get_template_part('template-parts/contact-banner');

get_footer();

?>