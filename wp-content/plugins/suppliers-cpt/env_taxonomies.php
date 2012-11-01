<?php 
function build_taxonomies() {
	register_taxonomy('supplier-type', array('supplier'), array(
	
	'hierarchical' => false,  'label' => 'Supplier Type',
	
	'query_var' => true, 'rewrite' => true)); 
	
		 
  }
  add_action( 'init', 'build_taxonomies', 0 );
  ?>