<?php 
function print_the_terms($taxonomy, $separator){
global $terms;
global $post;
$terms = get_the_terms($post->ID, $taxonomy); 
if ( $terms && ! is_wp_error( $terms ) ) : 
	
	foreach ( $terms as $term ) {
		$tax_items[] = $term->slug;
	}
						
	$the_terms = join($tax_items, $separator);
	return $the_terms;
	endif;
}

function isotope_filter_menu($taxonomy){
global $terms;
$terms = get_terms($taxonomy); 
if ( $terms && ! is_wp_error( $terms ) ) { 
	
	foreach ( $terms as $term ) {
	if($term->slug != 'killthe8'){
		$tax_items[] = "<li><a href='#' class='label' data-filter='.".$term->slug."'>".$term->name." </a></li>";
		
		$the_terms = join($tax_items, ' ');
	}
	}
	$tax_items[] = "<li><a href='#' class='label' data-filter='*'>show all</a></li>";
	$the_terms = join($tax_items, ' ');
	return $the_terms;
}
else {
return "no terms";
}

}

add_action('wp_enqueue_scripts', 'isotope_enqueue');
function isotope_enqueue(){
wp_enqueue_script('isotope', get_bloginfo('stylesheet_directory') .'/javascripts/isotope.pkgd.min.js', 'jquery');//isotope from metafizzy
wp_enqueue_script('custom', get_bloginfo('stylesheet_directory') .'/javascripts/custom.js', 'isotope');//isotope from metafizzy
}


?>