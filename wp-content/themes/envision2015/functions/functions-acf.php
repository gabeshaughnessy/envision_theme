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




?>
