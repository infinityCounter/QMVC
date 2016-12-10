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

//Load composer dependencies
if (file_exists(ROOT_PATH . 'vendor/autoload.php')) {
    require ROOT_PATH . 'vendor/autoload.php';
}

/**
* Load required classes, uses spl_autoload_register 
* as __autoload is to be depricated
**/
spl_autoload_register( function ($class) {

    if (file_exists(ROOT_PATH . 'library/' . strtolower($className) . '.class.php')) {
        require_once(ROOT_PATH . 'library/' . strtolower($className) . '.class.php');
    } else if (file_exists(ROOT_PATH . 'application/controllers/' . DS . strtolower($className) . '.php')) {
        require_once(ROOT_PATH . 'application/controllers/' . DS . strtolower($className) . '.php');
    } else if (file_exists(ROOT_PATH . 'application/models/' . DS . strtolower($className) . '.php')) {
        require_once(ROOT_PATH . 'application/models/' . DS . strtolower($className) . '.php');
    } else {
        /* Error Generation Code Here */
    } 

    require_once(ROOT_PATH . "library/" . $class . 'php');
});


/**
*
* Main routing function
* instantiates controller based on route 
* Also makes appropriate function call
**/
function route(){
  $url = explode("/", $_GET["url"]);
  $route = isset($routes[$url[0]])? $routes[$url[0]] : null;
  if($route === null){
      throw exception('ROUTE NOT FOUND');
  }else{

    $controller = $route['controller'];
    $template = $route['template'];
    $activeSubView = $route['subView'];
    
    $action = $url[1];
    unset($url[0], $url[1]);
    $args = $url;

    $controller = new Controller($template, $activeSubView);
    if(method_exists($controller, $action)){
        if(empty($args)){
            $controller->{$action}();
        }else{
            call_user_func_array(array($controller, $action), $args);
        }
    }
  }
}


?>