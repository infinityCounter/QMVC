<?php

/*Config file containing details of project routing*/

//$states array contains all the states for the application
/**
*
* stateName => array(
*   'uri' => [URL to be displayed],
*   'controllerPath' => [Path to controller with relation from application folder],
*   'controllerName' => [Name of controller class],
*   'template' => [Path to template for view with relation from application folder],
*   'subView' => [Boolean to enable or disable subviews for this view]
* )
**/
 $states = array(
     
     'home' => array(
         'uri' => '/home',
         'controllerPath' => 'controllers/home.php',
         'controllerName' => 'Home',
         'template' => 'views/home.php',
         'subView' => false
     ) 

);
?>