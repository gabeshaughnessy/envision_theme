<?php global $post; ?>
<div class="outer container">
	<div class="row">
		<div class="medium-6 columns">
			<div class="map">
				<?php get_template_part('template-parts/maps/blue-slate'); ?>

			</div>
		</div>
		<div class="medium-6 columns">
			<div class="contact-form ">
				<h4>Send us a Message</h4>
				<?php echo do_shortcode("[contact-form to='info@envisioninteriorsinc.com' subject='Envision Interiors website contact form submission'][contact-field label='First Name' type='first-name' required='1'/][contact-field label='Last Name' type='last-name' required='1'/][contact-field label='Email' type='email' required='1'/][contact-field label='Message' type='textarea' required='1'/][/contact-form]"); ?>

			</div>
		</div>
	</div>
</div>