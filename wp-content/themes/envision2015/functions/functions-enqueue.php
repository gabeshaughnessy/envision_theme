<?php
/*
functions.php extension - enqueue
*/


add_action('wp_enqueue_scripts', 'env_theme_enqueue');
add_action('admin_enqueue_scripts', 'env_admin_enqueue');

$env_style_dir_stats = stat(get_template_directory().'/css');
$css_version = $env_style_dir_stats['mtime'];

$env_script_dir_stats = stat(get_template_directory().'/js');
$js_version = $env_script_dir_stats['mtime'];

function env_theme_enqueue() {
    global $css_version, $js_version;
    $env_template_dir = get_template_directory_uri();


    // Register Stylesheets

    wp_register_style('app-css', $env_template_dir.'/css/app.min.css', array(), $css_version);
    wp_register_style('app-homepage-css', $env_template_dir.'/css/app_homepage.min.css', array(), $css_version);
    wp_register_style('dev-only-css', $env_template_dir.'/css/dev_only.min.css', array(), $css_version);

    // Register Javascript
    //wp_deregister_script( 'jquery' ); - using default WordPress jQuery. It would be better to grunt a version of jQuery into app.min.js to avoid two requests here.


      wp_register_script('app-js', $env_template_dir.'/js/app.min.js', false, $js_version);
    


    // Enqueue files
    wp_enqueue_script('app-js', false, array(), $js_version);
    wp_enqueue_style('app-css', false, array(), $css_version);
          
            
    
    }

function env_admin_enqueue(){

    global $css_version, $js_version;
    $env_template_dir = get_template_directory_uri();

    //register
/*    wp_register_script('env-admin-js', $env_template_dir.'/js/admin.min.js', false, $js_version);
    wp_register_style('admin-css', $env_template_dir.'/css/admin.min.css', array(), $css_version);

    //enqueue
    wp_enqueue_script('env-admin-js', false, array('jquery'), $js_version);
    wp_enqueue_style('admin-css', false, array(), $css_version);*/
}



function env_ie_enqueue(){
    global $css_version, $js_version;
    /*echo '
        <link rel="stylesheet" href="'.get_stylesheet_directory_uri().'/css/ie.css?ver='.$css_version.'" type="text/css" media="all">
        <script type="text/javascript" src="'.get_stylesheet_directory_uri().'/js/app_ie.min.js?ver='.$js_version.'"></script>
        ';*/
    }
?>
