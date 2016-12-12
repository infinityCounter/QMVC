<?php

/**
*Request class, contains mutable operations for requests
* abstracts Request manipulation functions from Router
**/

class Request{
	
	
	private static $requestType = NULL;
	private static $requestURL = NULL;
	private static $requestBody = NULL;
	private static $requestURLArgs = NULL;
	private static $requestRESTArgs = NULL;
	
	
	public static function getRequestType(){
		return self::$requestType;
	}
	
	public static function getRequestBody(){
		return self::$requestBody;
	}
	
	public static function getRequestUrl(){
		return self::$requestURL;
	}
	
	public static function getRequestUrlArgs(){
		return self::$requestURLArgs;
	}
	
	public static function getRequestRestArgs(){
		return self::$requestRESTArgs;
	}
	
	public static function spliceRestArgs($routeURI){
		$requestURLArray = explode('/', self::getRequestUrl());
		$routeURIArray = explode('/', $routeURI);
		self::$requestRESTArgs = array_diff($requestURLArray, $routeURIArray);
	}
	
	public static function parseRequest(){
		
		
		self::$requestType = $_REQUEST["requestType"];
		$requestURL = $_REQUEST["url"];
		$requestURL = trim($requestURL, " ");
		$requestURL = trim($requestURL, " \t");
		$requestURL = trim($requestURL, " \n");
		self::$requestURL = "/".trim($requestURL, "/");
		
		
		/***
		* Won't be using the body of DELETE or GET requests
        * But get them anyway
        ***/
        if(self::$requestType === 'PUT' || self::$requestType === 'DELETE'){
            if($_SERVER["CONTENT_TYPE"] !== 'application/json'){
                parse_str(file_get_contents("php://input"), self::$requestBody); 
            }
            else{
                self::$requestBody = json_decode(file_get_contents("php://input"), true);
            }
        }else if(self::$requestType === 'POST'){
            self::$requestBody = $_POST;
        }
		var_dump(self::$requestType);
        self::$requestURLArgs = $_REQUEST; 
        unset(self::$requestURLArgs['requestType'], self::$requestURLArgs['url']);
    }
}
?>