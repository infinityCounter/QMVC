<?php
/** 
* @author - Emile Keith
* @package quickMVC
* @link https://github.com/infinityCounter/QMVC
**/

//Sets the ROOT constant to the root of the project
define(ROOT-PATH, dirname(dirname(__FILE__)) );
define(APP_PATH, ROOT_PATH . "application/");

/**
* Configuration files for project, 
* database.php and environment.php can be exempted, 
* but route.php is manditory
**/
require_once(ROOT_PATH . config . "database.php"); 
require_once(ROOT_PATH . config . "environment.php"); 
require_once(ROOT_PATH . config . "route.php");

/**
* Load required classes, uses spl_autoload_register 
* as __autoload is to be depricated
**/
spl_autoload_register( function ($class) { 

    require_once(ROOT_PATH . "library/" . $class . 'php');
});


?>