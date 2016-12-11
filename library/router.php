<?php
/**
* Router class
* Manages routing of application and communication between controllers and requests 
**/
require_once ROOT_PATH . '/library/url.php';
class Router {

    /*
    * Constructor accepts the array of all the states
    */

    function __construct($stateTable){

        URL::spliceURL($_GET['url']); //Static method call of the URL class to splice the url
        if( !isset($stateTable[URL::getRequestedState()] ) || 
            (URL::getRequestedState() === 'otherwise' && count(URL::getURLArray() ) > 1) ){

            header('Location: http://' . $_SERVER['SERVER_NAME'] . DOMAIN_PROJECT_DIR . '/otherwise');
            /*If no such state exists in the  state table or an action call was made on the otherwise route
            redirect as an http request to /otherwise with no action call*/
        } else if( isset($stateTable[URL::getRequestedState()] ) ){

            $stateData = $stateTable[URL::getRequestedState()];

            /*
            *Init controllerPath to path from $stateData, 
            *and controllerClass to name of controller in state data
            */
            $controllerPath = (isset($stateData['controllerPath'])) ? $stateData['controllerPath'] : null;
            $controllerClass = (isset($stateData['controllerName'])) ? $stateData['controllerName'] : null;

            if( isset($controllerPath) && isset($controllerClass) ) {
                /*If both controllerPath and controllerClass are set
                * Instantiate an instance of the controllerClass and make needed action calls
                */
                require_once(APP_PATH . $controllerPath);
                $controller = new $controllerClass(APP_PATH . $stateData['template'], $stateData['subView']);
                $action = URL::getActionMethod();
                echo isset($action);
                if(isset($action) && method_exists($controller, $action)){
                
                    if(isset($action)){
                        //Execute action method without arguments
                        $controller->{$action}();
                    }else{
                        //Execute action method on controller with arguments in URL
                        call_user_func_array(array($controller, $action), URL::getArgs());
                    }

                }else if(isset($action) && !method_exists($controller, $action)){
                    //If method does not exists on controller
                    header('Location: http://' . $_SERVER['SERVER_NAME'] . DOMAIN_PROJECT_DIR . '/' .URL::getRequestedState());
                }
            } else {
                //If state has no Controller, just load template
                require_once(APP_PATH . $stateData['template']);
            }
        }
    }

}


?>