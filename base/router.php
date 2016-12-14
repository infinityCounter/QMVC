<?php

/**
* Router class
* 
* Manages routing of application and communication between controllers and requests 
*/

require_once(ROOT_PATH . 'base/request.php');

class Router 
{	
	private $stateTable = null;
	private $Request = null;
	private $fallback;

	/**
	* Class constructor
	*
	* Inititalizes the value of local memebers from arguments
	*
	* @param array The array containing all states defined states.php config file
	* @param string The fallback state that the class should redirect to if no matching state for request is found
	*/
	function __construct($stateTable, $fallback = '/otherwise')
	{	
		$this->stateTable = $stateTable;
		$this->fallback = $fallback;
		$this->Request = new Request();
	}

	/**
	* public function loadRequestedState 
	*
	* Loads the state for the requested URI if one exists, else redirects to fallback route
	*
	* @return void 
	*/
	public function loadRequestedState()
	{

		if (!isset($this->stateTable) || empty($this->stateTable)){
			//If this method is called white $states are not set
			throw new Exception("NO STATE TABLE PROVIDED TO ROUTER");
		}
		
		//Calls method on Request object to parse the Request
        $this->Request->parseRequest();
		//Gets the information of the state matching the requested uri
		$stateConfig = $this->getRouteData();
        if (empty($stateConfig)){
			//If no state exists for request uri redirect to fallback route
		    header('Location: ' . URL . $this->fallback);
		}

		else if (isset($stateConfig['controller'])){
			//If a model class is defined by the state in $states, instantiate an instance, else set $model to null
			$model = ($stateConfig['model']) ? new $stateConfig['model']() : null;
			//Create new controller object of type defined by the state information, and pass it the model and template required
			$controller = new $stateConfig['controller']($model, $stateConfig['template']);
			//If there exists an action on the state matching the requested type
			$actionExists = isset($stateConfig['actions'][$this->Request->getRequestType()]);
			if ($actionExists){

				if ($this->Request->getRequestType() === 'GET' || $this->Request->getRequestType() === 'DELETE'){
					//Combine the arrays of Uri arguments and query string arguments
					$methodArgs = array_merge($this->Request->getRequestRestArgs(), $this->Request->getRequestUrlArgs());
			    	//Execute method on the controller with said name, passing array of arguments
					call_user_func_array([$controller, $stateConfig['actions'][$this->Request->getRequestType()]], $methodArgs);
				} else if ($this->Request->getRequestType() === 'POST'){

			    	call_user_func_array([$controller, $stateConfig['actions'][$this->Request->getRequestType()]], $this->Request->getRequestBody());
				} else if ($this->Request->getRequestType() === 'PUT'){

					$methodArgs = array_merge($this->Request->getRequestRestArgs(), $this->Request->getRequestBody());
					call_user_func_array([$controller, $stateConfig['actions'][$this->Request->getRequestType()]], $methodArgs);
				}
			}
			//loads the view
			$controller->render();
		}

		else {
			//If there is no controller defined for the state, just load the view
			include(ROOT_PATH . $stateConfig['template']);
		}
					
	}

	/**
	* public function getRouteData 
	*
	* Finds the route that matches the uri provided by the request and returns the information for the state it maps to
	*
	* @return array | null Either the array contianing the state information for the route, or null 
	*/
	public function getRouteData()
	{
		//If there is an entry in $stateTable with a key matching the request Uri
        if (isset($this->stateTable[$this->Request->getRequestUrl()])){

            $stateData = $this->stateTable[$this->Request->getRequestUrl()];
			//If no actions are defined or there is an action defined for the request type
            if (!isset($stateData['actions']) || (isset($stateData['actions']) && array_key_exists($this->Request->getRequestType(), $stateData['actions']))){
                //Splice any Uri arguments (DOES NOTHING HERE BESIDES SETS TO EMPTY ARRAY)
				$this->Request->spliceRestArgs($this->Request->getRequestUrl());
				//Return the information for that state
				return $stateData;
            }
		}
		//If no state matches the Uri
		else {
			//Get all route URIs form the $statTable member
			$stateKeys = array_keys($this->stateTable);
			//Seperate the array of route keys into index and value
			foreach ($stateKeys as $index => $routeURI) {
				//Trim any trailing '/' and append one to the start of strng
				$trimmedRouteURI = '/' . trim($routeURI, '/');
				//Escape any forward slashes
				$escapedRouteURI = str_replace('/','\/', $trimmedRouteURI);
				//Replace any locations for URI arguments (Turning the uri into a regular expression)
				$preRegexURI = preg_replace("/{[a-zA-z0-9]+}/", '[a-zA-Z0-9]+', $escapedRouteURI);
				//If the route and regular expression of the route are the same then this route does not use REST URI arguments
				if (($preRegexURI) !== $escapedRouteURI){
					//Add \A and \Z to the end of the expression to indicate start and end of string when matching
					$regexURI ="/\A".$preRegexURI."\z/";
					$matchRequestType = array_key_exists( $this->Request->getRequestType() , $this->stateTable[$routeURI]['actions']  );
					//If the requested URI and URI from the table match AND there exists an action for the type of request made
					if (preg_match($regexURI, $this->Request->getRequestUrl()) && $matchRequestType){
						
						$this->Request->spliceRestArgs($routeURI);
						return $this->stateTable[$routeURI];
					}
				}
			}
		}
		//Return null otherwise
		return null;
	}
	
}
?>