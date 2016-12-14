<?php
/** 
* @author - Emile Keith
* @package quickMVC
* @link https://github.com/infinityCounter/QMVC
**/

//Sets the ROOT_PATH constant to the root of the project
define('ROOT_PATH', dirname(__DIR__) . '/' );
define('APP_PATH', ROOT_PATH . "application/");

//Load composer dependencies
if (file_exists(ROOT_PATH . 'vendor/autoload.php')){
    require ROOT_PATH . 'vendor/autoload.php';
}



/**
* Configuration files for project, 
* environment.php can be exempted, 
* but route.php is manditory
**/
require_once(ROOT_PATH . 'config/definitions.php');
require_once(ROOT_PATH . 'config/environment.php'); 
require_once(ROOT_PATH . 'config/states.php');

//Core includes
require_once(ROOT_PATH . 'base/sqlDatabase.php');
require_once(ROOT_PATH . 'base/controller.php');
require_once(ROOT_PATH . 'base/model.php');
require_once(ROOT_PATH . 'base/router.php');


//Model includes
require_once(APP_PATH . 'models/school.php');

//Controller includes
require_once(APP_PATH . 'controllers/school.php');

$Router = new Router($states);
$Router->loadRequestedState();
?>