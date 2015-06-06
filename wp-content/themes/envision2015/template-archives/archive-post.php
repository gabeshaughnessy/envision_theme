<?php
global $post, $post_type;
get_header();
$archive_term_id = get_queried_object()->term_id;
$term_tax = get_queried_object()->taxonomy;
$fieldgroup = $term_tax.'_'.$archive_term_id;
$archive_title = get_field('archive_title', $fieldgroup);
$archive_tagline = get_field('archive_tagline', $fieldgroup);
$bg_image = get_field('archive_image', $fieldgroup); 

?>
<div class="hero-area">
	<div class="title-area">
		<div class="contents">
			<h2><?php echo (isset($archive_title) && !empty($archive_title) ? $archive_title : single_tag_title("", false)); ?></h2>
			<?php 

			echo '<p class="subtitle">'.(isset($archive_tagline) && !empty($archive_title) ? $archive_tagline : "").'</p>';

			?>
		</div>
	</div>

		<?php 
		if(isset($bg_image) && !empty($bg_image)){ ?>
			<div class="hero-bg"style="background-image: url('<?php echo $bg_image["sizes"]["large"]; ?>');"></div>
		<?php
		}
		else if(has_post_thumbnail( $post->ID ) ){ ?>
		<?php $bg_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' ); ?>
		<div class="hero-bg"style="background-image: url('<?php echo $bg_image[0]; ?>')"></div>
		<?php } ?>

</div>

<div class="outer container">
	<?php 
		$lead =  term_description( $archive_term_id );
		if(isset($lead) && !empty($lead)){
			echo '<div class="lead">'.$lead.'</div>';
		} 
	?>
</div>
<div class="outer container">
	<div class="post-grid-wrapper">
		<ul class="post-grid <?php echo $post_type; ?>-grid">
<?php
if(have_posts()) : while(have_posts()) : the_post();
//the posts go here.
	get_template_part('template-parts/post-grid-'.$post_type);

endwhile;
endif; 
?>
		</ul>
	</div>
</div>
<?php
get_template_part('template-parts/contact-banner');
get_footer();
?>