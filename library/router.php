<?php

class Router {

    function __construct($stateTable){
        
        $url = explode('/', $_GET['url']);
        $state = isset($stateTable[$url[0]])? $stateTable[$url[0]] : null;
        if($state === null && isset($stateTable['_404Error'])){
            echo('no state');
        }else{

            $controllerPath = $state['controllerPath'];
            $controllerClass = $state['controllerName'];
            if(count($url) > 1){
                $action = $url[1];
                unset($url[0], $url[1]);
            }else{
                unset($url[0]);
            }
            $args = array_values($url);
            if(file_exists(APP_PATH . $controllerPath)){
                require(APP_PATH . $controllerPath);
                $controller = new $controllerClass(APP_PATH . $state['template'], $state['subView']);
                if(isset($action) && method_exists($controller, $action)){
                    if(empty($args)){
                        $controller->{$action}();
                    }else if (count($args) === 1){
                        call_user_func(array($controller, $action), $args[0]);
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