<?php global $post;
$contact_query = new WP_Query(array('pagename' => 'contact'));
if($contact_query->have_posts()) : while($contact_query->have_posts()) : $contact_query->the_post();
 ?>
<div class="section-break white">
	<div class="title-area dark-blue">
		<div class="contents">
			<h2>Contact Us</h2>
			<p class="subtitle">All our contacts are here</p>
		</div>
	</div>
</div>
<div class="dark-blue-wrapper">
	<div class="outer container">
		<?php get_template_part('template-parts/lead'); ?>
		
		<?php get_template_part('template-parts/contact-details'); ?>
		<?php get_template_part('template-parts/social-profile-banner'); ?>

	</div>
</div>
<?php
endwhile;
endif;
?>