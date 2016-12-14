<?php

/**
*Request class, contains mutable operations for requests
* abstracts Request manipulation functions from Router
**/

class Request
{	
	
	private $requestType = NULL;
	private $requestURL = NULL;
	private $requestBody = NULL;
	private $requestURLArgs = NULL;
	private $requestRESTArgs = NULL;
	
	
	public function getRequestType()
	{
		return $this->requestType;
	}
	
	public function getRequestBody()
	{
		return $this->requestBody;
	}
	
	public function getRequestUrl()
	{
		return $this->requestURL;
	}
	
	public function getRequestUrlArgs()
	{
		return $this->requestURLArgs;
	}
	
	public function getRequestRestArgs()
	{
		return $this->requestRESTArgs;
	}
	
	public function spliceRestArgs($routeURI)
	{
		$requestURLArray = explode('/', self::getRequestUrl());
		$routeURIArray = explode('/', $routeURI);
		$this->requestRESTArgs = array_diff($requestURLArray, $routeURIArray);
	}
	
	public function parseRequest()
	{	
		$this->requestType = $_REQUEST["requestType"];
		$requestURL = $_REQUEST["url"];
		$requestURL = trim($requestURL, " ");
		$requestURL = trim($requestURL, " \t");
		$requestURL = trim($requestURL, " \n");
		$this->requestURL = "/".trim($requestURL, '/');
		
		if ($this->requestType === 'PUT' && $_SERVER["CONTENT_TYPE"] !== 'application/json'){
			parse_str(file_get_contents("php://input"), $this->requestBody); 
		}else if (($this->requestType === 'PUT' || $this->requestType === 'POST')&& $_SERVER["CONTENT_TYPE"] === 'application/json'){
			$this->requestBody = json_decode(file_get_contents("php://input"), true);
		}else if ($this->requestType === 'POST' && $_SERVER["CONTENT_TYPE"] !== 'application/json'){
			$this->requestBody = $_POST;
		}
		$this->requestURLArgs = $_REQUEST;
		unset($this->requestURLArgs['requestType'], $this->requestURLArgs['url']);
    }
}
?>