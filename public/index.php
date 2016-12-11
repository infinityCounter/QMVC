<?php
/** 
* @author - Emile Keith
* @package quickMVC
* @link https://github.com/infinityCounter/QMVC
**/

//Sets the ROOT_PATJ constant to the root of the project
define('ROOT_PATH', dirname(__DIR__).'/' );
define('APP_PATH', ROOT_PATH . "application/");

//Used for internal domain redirection
define('DOMAIN_PROJECT_DIR', (dirname(dirname($_SERVER['PHP_SELF']))) );

/**
* Configuration files for project, 
* database.php and environment.php can be exempted, 
* but route.php is manditory
**/
require_once(ROOT_PATH . "config/database.php"); 
require_once(ROOT_PATH . "config/environment.php"); 
require_once(ROOT_PATH . "config/states.php");

//Load composer dependencies
if (file_exists(ROOT_PATH . 'vendor/autoload.php')) {
    require ROOT_PATH . 'vendor/autoload.php';
}

/**
* Load required classes, uses spl_autoload_register 
* as __autoload is to be depricated
**/
spl_autoload_register( function ($className) {
    if (file_exists(ROOT_PATH . 'library/' . strtolower($className) . '.php')) {
        require_once(ROOT_PATH . 'library/' . strtolower($className) . '.php');

    } else if (file_exists(APP_PATH . 'controllers/' . strtolower($className) . '.php')) {
        require_once(APP_PATH . 'controllers/' . strtolower($className) . '.php');

    } else if (file_exists(APP_PATH . 'models/' . strtolower($className) . '.php')) {
        require_once(APP_PATH . 'models/' . strtolower($className) . '.php');

    } else if (file_exists(APP_PATH . strtolower($className))) {
        require_once(APP_PATH . strtolower($className));

    } else {
        /* Error Generation Code Here */
    } 
});

$router = new Router($states);
?>