<?php

/**
* Router class
* Manages routing of application and communication between controllers and requests 
*/

require_once(ROOT_PATH . 'base/request.php');

class Router 
{	
	private $stateTable = null;
	private $Request = null;
	private $fallback;

	/**
	* Constructor of Router class.
	* Inititalizes the value of local memebers from input
	*/
	function __construct($stateTable, $fallback = '/otherwise')
	{	
		$this->stateTable = $stateTable;
		$this->fallback = $fallback;
		$this->Request = new Request();
	}

	/**
	* loadRequested() state loads the state matching the requesting URI
	*
	* Calls helper methods from Request class to help manipulate URL
	* and Request objects. Makes secondary call to retreive state data
	* Instantiate state associated with the original requested URI
	*
	* @return void 
	*/
	public function loadRequestedState()
	{

		if (!isset($this->stateTable)){
		
			throw new Exception("NO STATE TABLE PROVIDED TO ROUTER");
		}
		
		/*Calls method on Request object to parse the Request*/
        $this->Request->parseRequest();
		$stateConfig = $this->getRouteData();
        if (empty($stateConfig)){

		    header('Location: ' . URL . $this->fallback);
		}

		else if (isset($stateConfig['controller'])){
			
			$model = ($stateConfig['model']) ? new $stateConfig['model']() : null;
			$controller = new $stateConfig['controller']($model, $stateConfig['template']);
			$actionExists = isset($stateConfig['actions'][$this->Request->getRequestType()]);
			if ($actionExists){

				if ($this->Request->getRequestType() === 'GET' || $this->Request->getRequestType() === 'DELETE'){

			    	call_user_func_array([$controller, $stateConfig['actions'][$this->Request->getRequestType()]], $this->Request->getRequestRestArgs());
				} else if ($this->Request->getRequestType() === 'POST'){

			    	call_user_func_array([$controller, $stateConfig['actions'][$this->Request->getRequestType()]], $this->Request->getRequestBody());
				} else if ($this->Request->getRequestType() === 'PUT'){

					$methodArgs = array_merge($this->Request->getRequestRestArgs(), $this->Request->getRequestBody());
					call_user_func_array([$controller, $stateConfig['actions'][$this->Request->getRequestType()]], $methodArgs);
				}
			}
			$controller->render();
		}

		else 
			include(ROOT_PATH . $stateConfig['template']);		
	}
	
	public function getRouteData()
	{
        if (isset($this->stateTable[$this->Request->getRequestUrl()])){

            $stateData = $this->stateTable[$this->Request->getRequestUrl()];
            if (!isset($stateData['actions']) || (isset($stateData['actions']) && array_key_exists($this->Request->getRequestType(), $stateData['actions']))){
                
				$this->Request->spliceRestArgs($this->Request->getRequestUrl());
				return $stateData;
            }
		}
		else {
			
			$stateKeys = array_keys($this->stateTable);
			$mutableRoutes = array();
			foreach ($stateKeys as $index => $routeURI) {
				$trimmedRouteURI = '/' . trim($routeURI, '/');
				$escapedRouteURI = str_replace('/','\/', $trimmedRouteURI);
				$preRegexURI = preg_replace("/{[a-zA-z0-9]+}/", '[a-zA-Z0-9]+', $escapedRouteURI);
				if (($preRegexURI) !== $escapedRouteURI){
					
					$regexURI ="/\A".$preRegexURI."\z/";
					$matchRequestType = array_key_exists( $this->Request->getRequestType() , $this->stateTable[$routeURI]['actions']  );
					if (preg_match($regexURI, $this->Request->getRequestUrl()) && $matchRequestType){
						
						$this->Request->spliceRestArgs($routeURI);
						return $this->stateTable[$routeURI];
					}
				}
			}
		}
		
		return null;
	}
	
}
?>