<?php

//set up global environment variables
/* DEFINE ENVIRONMENT GLOBAL */
$host = $_SERVER['HTTP_HOST'];
if (stristr($host, 'local') !== FALSE){
    define('SITE_ENVIRONMENT', "development");

    }
    elseif ((stristr($host, 'staging') !== FALSE) || (stristr($host, 'wpengine') !== FALSE)){
        
        define('SITE_ENVIRONMENT', "staging");
                
        }
        else{
            define('SITE_ENVIRONMENT', "production");
            }

//ACF SETUP
require_once('functions/functions-acf.php');

//enqueue styles and scripts
require_once('functions/functions-enqueue.php');

?>