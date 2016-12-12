<?php

/**
*Router class
* Manages routing of application and communication between controllers and requests 
**/

require_once(ROOT_PATH . 'base/request.php');

class Router {
	
	private static $stateTable = NULL;
	
	public static function loadState($stateTable = NULL){
		
        if(self::$stateTable === NULL && $stateTable !== NULL)
		    self::$stateTable = $stateTable;
		
		Request::parseRequest();
		$stateConfig = self::getRouteData();
		
		if(empty($stateConfig))
			header('Location: ' . URL . '/otherwise');

		else if(isset($stateConfig['controller'])){
			
			$model = ($stateConfig['model']) ? new $stateConfig['model']() : NULL;
			$controller = new $stateConfig['controller']($model, $stateConfig['template']);
			
			if(Request::getRequestType() === 'GET' || Request::getRequestType() === 'DELETE')
			    call_user_func_array([$controller, $stateConfig['actions'][Request::getRequestType()]], Request::getRequestRestArgs());
			else if(Request::getRequestType() === 'POST')
			    call_user_func_array([$controller, $stateConfig['actions'][Request::getRequestType()]], Request::getRequestBody());
			else if(Request::getRequestType() === 'PUT'){
				$methodArgs = array_merge(Request::getRequestRestArgs(), Request::getRequestBody());
				call_user_func_array([$controller, $stateConfig['actions'][Request::getRequestType()]], $methodArgs);
			}
			
			$controller->render();
		}

		else 
			include(APP_PATH . $stateConfig['template']);
		
	}
	
	public static function getRouteData(){

        //var_dump(Request::getRequestType());
		if(isset(self::$stateTable[Request::getRequestUrl()])){
			
			return current(array_filter(self::$stateTable, function($stateData, $routeURI){
				if($routeURI === Request::getRequestUrl()){
					
                    if(isset($stateData['actions']) && 
					    array_key_exists(Request::getRequestType(), $stateData['actions'])){
						Request::spliceRestArgs($routeURI);
						return $stateData;
					}
					else if(!isset($stateData['actions'])){
						Request::spliceRestArgs($routeURI);
						return $stateData;
					}
				}
				
			}
			, ARRAY_FILTER_USE_BOTH));
		}
		else {

			$stateKeys = array_keys(self::$stateTable);
			$mutableRoutes = array();
			foreach($stateKeys as $index => $routeURI){

				$escapedRouteURI = str_replace('/','\/', $routeURI);
				$preRegexURI = preg_replace("/{[a-zA-z1-9]+}/", '[a-zA-Z1-9]+\/?', $escapedRouteURI);
				if( ($preRegexURI) !== $escapedRouteURI){

					$regexURI ="/".$preRegexURI."/";
					$matchRequestType = array_key_exists( Request::getRequestType() , self::$stateTable[$routeURI]['actions']  );
					if(preg_match($regexURI, '/' . Request::getRequestUrl()) && $matchRequestType){
						Request::spliceRestArgs($routeURI);
						return self::$stateTable[$routeURI];
					}
				}
			}
		}
		
		return NULL;
	}
	
}


?>