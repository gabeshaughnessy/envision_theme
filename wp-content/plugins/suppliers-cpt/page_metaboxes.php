<?php 
/******************************
Edit meta box settings here
******************************/
$prefix = 'env_'; 
$meta_boxes = array();

$meta_boxes[] = array(
	'id' => 'supplier_meta_box',
	'title' => 'Supplier Options',
	'pages' => array('supplier'), // multiple post types -----edit this to change which post type the custom meta box appears on
	'context' => 'normal',
	'priority' => 'high',
	'show_names' => true,
	'fields' => array( //field declarations create the fields in the metabox then get content from the callback function below
		array(
			'name' => 'Website',
			'desc' => 'Put the url to the supplier website here',
			'id' => $prefix . 'supplier_url',
			'type' => 'text', 
			'std' => ''
		),
				
	)
	);
//set up metaboxes 
require_once('metabox/init.php');//gets the metabox framework

?>