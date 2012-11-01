<?php add_action('init', 'make_supplier_posts');
function make_supplier_posts() 
{ 
add_theme_support('post-thumbnails');
set_post_thumbnail_size( 80, 80, true );

$labels = array(
    'name' => _x('Suppliers', 'post type general name'),
    'singular_name' => _x('Supplier', 'post type singular name'),
    'add_new' => _x('Add New', 'Supplier'),
    'add_new_item' => __('Add New Supplier'),
    'edit_item' => __('Edit Supplier'),
    'new_item' => __('New Supplier'),
    'view_item' => __('View Supplier'),
    'search_items' => __('Search the Supplier Catalog'),
    'not_found' =>  __('No suppliers found'),
    'not_found_in_trash' => __('No suppliers found in Trash'), 
    'parent_item_colon' => ''
    
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => 19,
	'taxonomies' => array(),
    'supports' => array('title','thumbnail','editor','revisions')
  ); 
  register_post_type('supplier',$args);//this is where the post type is created
  }
//add filter to insure the text supplier, or supplier, is displayed when user updates a supplier 
add_filter('post_updated_messages', 'supplier_updated_messages');
function supplier_updated_messages( $messages ) {
  global $post, $post_ID;
  $messages['supplier'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Supplier updated. <a href="%s">View the Supplier</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('supplier updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('supplier restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Supplier published. <a href="%s">View supplier</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('supplier saved.'),
    8 => sprintf( __('supplier submitted. <a target="_blank" href="%s">Preview supplier</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('supplier scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview supplier</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('supplier draft updated. <a target="_blank" href="%s">Preview supplier</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  return $messages;
}
//display contextual help for suppliers
add_action( 'contextual_help', 'add_supplier_help_text', 10, 3 );
function add_supplier_help_text($contextual_help, $screen_id, $screen) { 
  //$contextual_help .= var_dump($screen); // use this to help determine $screen->id
  if ('supplier' == $screen->id ) {
    $contextual_help =
      '<p>' . __('Things to remember when adding or editing a supplier:') . '</p>' .
      '<ul>' .
      '<li>' . __('Be sure to provide all the supplier info.') . '</li>' .
      '<li>' . __('double check for clarity ') . '</li>' .
      '</ul>' .
      '<p>' . __('If you want to schedule the supplier to be published in the future:') . '</p>' .
      '<ul>' .
      '<li>' . __('Under the Publish module, click on the Edit link next to Publish.') . '</li>' .
      '<li>' . __('Change the date to the date to actual publish this article, then click on Ok.') . '</li>' .
      '</ul>' .
      '<p><strong>' . __('For more information:') . '</strong></p>' .
      '<p>' . __('<a href="http://codex.wordpress.org/Posts_Edit_SubPanel" target="_blank">Edit Posts Documentation</a>') . '</p>' .
      '<p>' . __('<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>') . '</p>' . 
      '<p>' . __('Be Strong, Young Jedi!') . '</p>';
  } elseif ( 'edit-supplier' == $screen->id ) {
    $contextual_help = 
      '<p>' . __('This is the help screen displaying the table of suppliers.') . '</p>' ;
  }
  return $contextual_help;
  }
?>