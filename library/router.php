<?php
/**
* Router class
* Manages routing of application and communication between controllers and requests 
**/
class Router {

    /*
    * Constructor accepts the array of all the states
    */
    function __construct($stateTable){
        
        $url = explode('/', $_GET['url']); //Explode the string into an array, using '/' as the delimeter
        $state = isset($stateTable[$url[0]])? $stateTable[$url[0]] : null;
        if($state === null && isset($stateTable['_404Error'])){ 
            //Redirect to 404 error state if requested state does not exist
            echo('no state');
        }else{

            $controllerPath = $state['controllerPath'];
            $controllerClass = $state['controllerName'];
            if(count($url) > 1){ //If an action was provided as well
                $action = $url[1];
                unset($url[0], $url[1]);
            }else{
                unset($url[0]);
            }
            $args = array_values($url);

            if(file_exists(APP_PATH . $controllerPath)){

                require_once(APP_PATH . $controllerPath); //Load controller class file so that class may be used
                $controller = new $controllerClass(APP_PATH . $state['template'], $state['subView']);
                if(isset($action) && method_exists($controller, $action)){
                    if(empty($args)){
                        $controller->{$action}(); //Call the method on the object without any arguments
                    }else if (count($args) === 1){
                        call_user_func(array($controller, $action), $args[0]); //Pass only the first argument, which is the only argument to the target method
                    }else{
                        call_user_func_array(array($controller, $action), $args);
                    }
                }
            }else{

            }
            
        }
    }

}


?>