<?php /*

**************************************************************************

Plugin Name:  Supplier Custom Post Type
Plugin URI:   http://envisioninteriorsinc.com
Description:  Supplier custom post type for envision interiors site.
Version:      1.0
Author:       Gabe Shaughnessy
Author URI:   http://gabesimagination.com/

**************************************************************************/
//set up meta boxes
global $meta_boxes;

//create custom post types
// prefix for the site is env_
//suppliers
require_once('supplier_creator.php');

//Custom metabox on pages and posts too 
require_once('page_metaboxes.php');

//Set up taxonomies to relate everything
require_once('env_taxonomies.php');

?>