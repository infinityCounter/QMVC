<?php

/**
* states.php contains project routing information
*
* Routes are mapped to states, and request types to 
* action methods of the controller for that route
*/


/**
* $state contains all the routing information for the application
* and take the form 
*
* $states = array(
*   
*    '/routeURI' => array(
*        'model' => 'StateModel',
*        'controller' => 'StateController',
*        'template' => 'application/views/stateOneView.php',
*        'actions' = array('GET' => 'getAction', 'POST' => 'postAction')
*    )
*    '/otherwise' => array(
*        'template' => 'application/views/fallback.php'
*    )
* ) 
*
* '/othwerise' is the default fallback state 
*/
$states = array(

    //Uri for root
    '/' => array(
        //State is only a template
        'template' => 'application/views/home.php'
    ),

    //Uri for the school route
    '/school' => array(
        'model'     => 'SchoolModel',
        'controller' => 'SchoolCtrl',
        'template' => 'application/views/school.php',
        //State supports both GET and POST requests
        'actions' => array('GET' => 'getSchools', 
                           'POST' => 'insertSchool')
    ),

    //REST Uri route for a specific school
    '/school/{id}' => array(
        'model'     => 'SchoolModel',
        'controller' => 'SchoolCtrl',
        'template' => 'application/views/school.php',
        //State supports GET, PUT, and DELETE actions
        'actions' => array('GET' => 'getSchool', 
                           'PUT' => 'updateSchool',
                           'DELETE' => 'deleteSchool')
    ),

    //Fallback state
    '/otherwise' => array(
         'template' => 'application/views/error.php',
     ),
);
?>