<?php

namespace QMVC\base;
use Security;

/**
* class Request
*
* Request class, contains mutable operations for requests
* abstracts Request manipulation functions from Router
**/

class Request
{	
	
	private $requestType = null;
	private $requestURL = null;
	private $requestBody = null;
	private $requestURLArgs = null;
	private $requestRESTArgs = null;

	
	/**
	* public function getRequestType
	*
	* @return string The type of the request(GET, POST, PUT, DELETE)
	*/
	public function getRequestType()
	{
		return $this->requestType;
	}
	
	/**
	* public function getRequestBody
	*
	* @return array Contains all key value vairs from the request body
	*/
	public function getRequestBody()
	{
		return $this->requestBody;
	}
	
	/**
	* public function getRequestUrl
	*
	* @return string The URI specified by the request
	*/
	public function getRequestUrl() //SHOULD BE RENAMED TO getRequestUri
	{
		return $this->requestURL;
	}
	
	/**
	* public function getRequestUrlArgs
	*
	* @return array Contains arguments from URL query string
	*/
	public function getRequestUrlArgs()
	{
		return $this->requestURLArgs;
	}
	
	/**
	* public function getRequestRestArgs
	*
	* @return array Contains arguments defined in the Uri of the request
	*/
	public function getRequestRestArgs()
	{
		return $this->requestRESTArgs;
	}
	
	/**
	* public function spliceRestArgs
	*
	* Stores the argument components of a uri request
	*
	* @param string The uri from the matching route in the $states variable
	* @return void
	*/
	public function spliceRestArgs($routeURI)
	{
		//Split the original request url, using / as a delimeter. Store segments in array
		$requestURLArray = explode('/', self::getRequestUrl());
		$routeURIArray = explode('/', $routeURI);
		//Compare the two arrays, store the values that differ in class member $requestRESTArgs
		$this->requestRESTArgs = array_diff($requestURLArray, $routeURIArray);
	}
	
	/**
	* public function parseRequest
	*
	* Performs operations on the request received and stores it's components in member variables
	*
	* @return void
	*/
	public function parseRequest()
	{	
		//Get the request type from the $_REQUEST global variable
		$this->requestType = $_REQUEST["requestType"];
		$requestURL = $_REQUEST["url"];
		//Trim any white space, tabs or line feeds from the URL
		$requestURL = trim($requestURL);
		//Trim any forward slashes from the body and concatiante one to the start of the string
		//Allows it to later properly match routes defines in $state
		$this->requestURL = "/".trim($requestURL, '/');
		
		//Series of if then to determine how to read the data body sent with the request
		//Which may or not be in the request body itself.
		if ($this->requestType === 'PUT' && $_SERVER["CONTENT_TYPE"] !== 'application/json'){
			//Read the contents of the input stream, parse the string to get values, store in $requestBody memeber
			parse_str(file_get_contents("php://input"), $this->requestBody); 
		} else if (($this->requestType === 'PUT' || $this->requestType === 'POST')&& $_SERVER["CONTENT_TYPE"] === 'application/json'){
			//Decode json data from input stream
			$this->requestBody = json_decode(file_get_contents("php://input"), true);
		} else if ($this->requestType === 'POST' && $_SERVER["CONTENT_TYPE"] !== 'application/json'){
			
			$this->requestBody = $_POST;
		}
		$this->requestURLArgs = $_REQUEST;
		unset($this->requestURLArgs['requestType'], $this->requestURLArgs['url']);
    }
}
?>