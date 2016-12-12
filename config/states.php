<?php

/*Config file containing details of project routing*/

//$states array contains all the states for the application



/**
* stateURI => array(
*   'uri' => [URL to be displayed],
*   'model' => [Name of model class],
*   'controller' => [Name of controller class],
*   'template' => [Path to template for view with relation from application folder],
*   'subView' => [Boolean to enable or disable subviews for this view] (NOT YET IMPLEMENTED)
* )
* 
* othwise is to be set to the fallback/default state at all times.
**/
$states = array(
    '/home' => array(
        'model'     => 'SchoolModel',
        'controller' => 'SchoolCtrl',
        'template' => 'application/views/school.php',
        'actions' => array('GET' => 'getSchools', 
                           'POST' => 'insertSchool')
    ),

    '/home/{id}' => array(
        'model'     => 'SchoolModel',
        'controller' => 'SchoolCtrl',
        'template' => 'application/views/school.php',
        'actions' => array('GET' => 'getSchool', 
                           'PUT' => 'updateSchool',
                           'DELETE' => 'deleteSchool')
    ),

    '/otherwise' => array(
         'template' => 'views/error.php',
     ),
);
?>