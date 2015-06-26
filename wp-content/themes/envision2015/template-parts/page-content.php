<?php global $post; ?>
<article class="page-content">
	<div class="outer container">
		<?php 
		if(!is_page_template('template-pages/page-home.php')){
			if(have_posts()) : while(have_posts()) : the_post();
			the_content(); 
			endwhile;
			endif;
		} else{
			the_content();
		}
		?>
	</div>
</article>