<?php
/** 
* @author - Emile Keith
* @link https://github.com/infinityCounter/QMVC
*
* QMVC is a PHP microframework application for developing
* small, non enterprise RESTful web based application
*/

//Sets the ROOT_PATH constant to the root of the project
define('ROOT_PATH', dirname(__DIR__) . '/' );
define('APP_PATH', ROOT_PATH . "application/");

//Load composer dependencies
if (file_exists(ROOT_PATH . 'vendor/autoload.php')){
    require ROOT_PATH . 'vendor/autoload.php';
}



//Loads required files for the project
require_once(ROOT_PATH . 'config/definitions.php');
require_once(ROOT_PATH . 'config/environment.php'); 
require_once(ROOT_PATH . 'config/states.php');

//Core includes
require_once(ROOT_PATH . 'base/mySqlDatabase.php');
require_once(ROOT_PATH . 'base/controller.php');
require_once(ROOT_PATH . 'base/model.php');
require_once(ROOT_PATH . 'base/router.php');


//Model includes
require_once(APP_PATH . 'models/school.php');

//Controller includes
require_once(APP_PATH . 'controllers/school.php');

//Creates a new Router object with the states defined in states.php
$Router = new Router($states);
//Load the State that the request Uri mapped to
$Router->loadRequestedState();
?>