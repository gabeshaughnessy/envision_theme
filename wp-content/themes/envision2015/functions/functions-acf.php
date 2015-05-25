<?php

/* ACF Activiation */
if (SITE_ENVIRONMENT != 'development') {
    add_filter('acf/settings/show_admin', '__return_false');
    }
add_filter('acf/settings/load_json', 'env_acf_json_load_point');


require_once('plugins/advanced-custom-fields-pro/acf.php');
require_once('plugins/advanced-custom-fields-pro/pro/acf-pro.php');
require_once('plugins/acf-field-intelligent-content-select/acf-intelligent-content-select.php');

/* Post ID relationship fix for MAMP
temporarily disabled so we can make it support serialized Post ID values and get the fields that are relationship fields instead of ALL the fields.
if(function_exists('cfr_register_metadata')){
    require_once(get_template_directory() . '/wp-ramp-postid-meta-translation/ramp-postid-meta-translation.php');
    }
*/

if (SITE_ENVIRONMENT != 'development'){ // If this is staging or production load ACF declarations
    // require_once(get_stylesheet_directory() . 'plugins/advanced-custom-fields-pro/register-fields.php');
    }
    else{  // If this is dev, include the ACF admin
        add_action( 'admin_menu', 'env_acf_menu', 9 );
        function env_acf_menu(){
            add_submenu_page( 'edit.php?post_type=acf', __('Custom Fields','acf'), __('Custom Fields','acf'), 'manage_options', 'edit.php?post_type=acf');
            add_submenu_page( 'edit.php?post_type=acf', __('Import ACF','acf'), __('Import ACF','acf'), 'manage_options', 'admin.php?import=wordpress');
            }
        }

//configure ACF to work within the theme directory.
//http://www.advancedcustomfields.com/resources/how-to/including-acf-in-a-plugin-theme/

// Set the path to ACF
add_filter('acf/settings/path', 'env_acf_settings_path');
function env_acf_settings_path( $path ) {
    $path = dirname(__FILE__) . '/plugins/advanced-custom-fields-pro/';
    return $path;
    }


// Change the settings directory
add_filter('acf/settings/dir', 'env_acf_settings_dir');

function env_acf_settings_dir( $dir ) {
    $dir = get_template_directory_uri().'/functions/plugins/advanced-custom-fields-pro/';
    return $dir;
    }


//change the directory where json field settings get saved
add_filter('acf/settings/save_json', 'env_acf_json_save_point');
function env_acf_json_save_point( $path ) {
    unset($path); // kill the default value from ACF Pro
    $path = get_stylesheet_directory() . '/functions/plugins/advanced-custom-fields-pro/acf-json';
    return $path;
    }
//change the directory where json field settings get loaded
function env_acf_json_load_point( $path ) {
    unset($path); // kill the default value from ACF Pro
    $path[] = get_stylesheet_directory() . '/functions/plugins/advanced-custom-fields-pro/acf-json';
    return $path;
    }

// Modify the label of the ACF repeater add row button
add_filter('acf/load_field/type=repeater', 'env_rename_add_rows', 9, 1);

function env_rename_add_rows($field){

    if(strpos($field['label'], 's') == strlen($field['label'])-1){
        //fix for plural/singular
        $btn_label = trim($field['label'], 's');
    }
    else{
        $btn_label = $field['label'];
    }
    if($field['layout'] === 'row'){
        $field['button_label'] = 'Add '.$btn_label;
        }
    return $field;
    }


// Tweak the admin view for field groups
add_filter('get_user_option_edit_acf-field-group_per_page', 'env_show_all_field_groups', 10, 3);
function env_show_all_field_groups($result, $option, $user) {
    if((int)$result < 1){
        return 500;
        }
    }

// Add options page for Admin Alerts
acf_add_options_sub_page(array(
        'title' => 'Admin Alerts',
        'parent' => 'options-general.php',
        'capability' => 'add_users'
    ));




/* DEBUG get_fields() */
function debugACF($fields){
    echo '<div class="outer container"><table class="acf-debug" border="1"><tr><th colspan="2">DEBUG Advanced Custom Fields</th></tr>';
    if(!empty($fields)){
        foreach($fields as $field => $value){
            echo '
                <tr>
                    <th>
                        '.$field.'
                    </th>';
            if(is_array($value) || is_object($value)){
                echo '<td><table class="acf-debug acf-debug-sub" border="1">';
                foreach($value as $key => $val){
                    echo '<tr><th>'.$key.'</th><td><pre>'.print_r($val, true).'</pre></td></tr>';
                    }
                echo '</table></td>';
                }
                else{
                    echo '<td>'.$value.'</td>';
                    }

            echo '</tr>';
            }
        }
        else{
            echo 'No Advanced Custom Fields Data For this Page';
            }
    echo '</table></div>';
    }


add_action( 'admin_menu', 'env_acf_sync_json', 9.1 );
function env_acf_sync_json() {
    add_submenu_page(
        'edit.php?post_type=acf-field-group',
        'Field Groups',
        'Field Groups',
        'edit_pages',
        'edit.php?post_type=acf-field-group'
        );
    add_submenu_page(
        'edit.php?post_type=acf-field-group',
        'Sync ACF Field Groups From JSON',
        'Sync from JSON',
        'manage_options',
        'options.php?page=jive-acf-sync-tool',
        array(&$this, 'env_acf_sync_page'));
    }

/* Create the ACF JSON Sync Page */
add_action('admin_menu', 'register_env_acf_sync_page');
function register_env_acf_sync_page(){
    add_submenu_page('options.php', 'Sync Field Groups From JSON', 'Sync Field Groups From JSON', 'manage_options', 'jive-acf-sync-tool', 'display_env_acf_sync_page');
    }

function display_env_acf_sync_page(){
    echo '<div class="wrap"><h2>Sync ACF Field Groups from JSON files</h2>';
    // display the button
    if(!isset($_POST['jv_sync_field_groups'])){
        echo '
            <form action="" method="post">
                <p>Do you want to update from the JSON files?</p>
                <input class="button button-primary" type="submit" value="sync field groups" id="jv_sync_field_groups" name="jv_sync_field_groups">
                <p><em>This action can not be undone</em></p>
            </form>
            </div>';
        }
        else{
            // Update the DB from the JSON files
            $message = "";

            // process the json
            echo 'Reading JSON files from: <br>'.env_acf_json_save_point(false);

            $dir = env_acf_json_save_point(false);
            $all_files = scandir($dir);

            foreach ($all_files as $filename) {
                if(preg_match("|group_.*\.json|", $filename)){

                    // read file
                    $json = file_get_contents( $dir.'/'.$filename );

                    // decode json
                    $json = json_decode($json, true);

                    // validate json
                    if( empty($json) ) {
                        acf_add_admin_notice(__('Import file empty', 'acf'), 'error');
                        return;
                        }

                    // if importing an auto-json, wrap field group in array
                    if( isset($json['key']) ) {
                        $json = array( $json );
                        }

                    // vars
                    $added = array();
                    $ref = array();
                    $order = array();

                    foreach( $json as $field_group ) {

                        // check if field group exists
                        if( acf_get_field_group($field_group['key'], true) ) {

                            // if field group exists in db, delete it before import
                            acf_delete_field_group($field_group['key']);
                            //error_log('delete field group: '.$field_group['key']);
                            }

                        // remove fields
                        $fields = acf_extract_var($field_group, 'fields');

                        // format fields
                        $fields = acf_prepare_fields_for_import( $fields );

                        // save field group
                        $field_group = acf_update_field_group( $field_group );

                        // add to ref
                        $ref[ $field_group['key'] ] = $field_group['ID'];

                        // add to order
                        $order[ $field_group['ID'] ] = 0;

                        // add fields
                        foreach( $fields as $field ) {

                            // add parent
                            if( empty($field['parent']) ) {
                                $field['parent'] = $field_group['ID'];
                                }
                                elseif( isset($ref[ $field['parent'] ]) ) {
                                    $field['parent'] = $ref[ $field['parent'] ];
                                    }

                            // add field menu_order
                            if( !isset($order[ $field['parent'] ]) ) {
                                $order[ $field['parent'] ] = 0;
                                }

                            $field['menu_order'] = $order[ $field['parent'] ];
                            $order[ $field['parent'] ]++;

                            // save field
                            $field = acf_update_field( $field );

                            // add to ref
                            $ref[ $field['key'] ] = $field['ID'];
                            }

                        $field_group = acf_update_field_group( $field_group );

                        // append to added
                        $added[] = '<a href="' . admin_url("post.php?post={$field_group['ID']}&action=edit") . '" target="_blank">' . $field_group['title'] . '</a>';
                        }

                    // messages
                    if( !empty($added) ) {
                        $message = __('<p><b>Success</b>. Import tool added %s field groups: %s</p>', 'acf');
                        $message = sprintf( $message, count($added), implode(', ', $added) );
                        echo $message;
                        // acf_add_admin_notice( $message );
                        }

                    }
                }

            }
    echo '</div>';
    }

?>
