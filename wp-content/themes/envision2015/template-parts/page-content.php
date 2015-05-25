<?php global $post; ?>
<article class="page-content">
	<div class="outer container">
		<?php 
		if(have_posts()) : while(have_posts()) : the_post();
		the_content(); 
		endwhile;
		endif;
		?>
	</div>
</article>