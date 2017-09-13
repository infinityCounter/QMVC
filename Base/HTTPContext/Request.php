<?php

namespace QMVC\Base\HTTPContext;

use QMVC\Base\Helpers\Helpers;
use QMVC\Base\Constants\Constants;
use QMVC\Base\Security\Sanitizers;

class Request
{
    private $requestURI;
    private $requestHTTPType;
    private $requestHTTPProtocol;
    private $requestHeaders;
    private $requestClientRemoteAddr;
    private $requestDateTime;
    private $requestBodyArgs = [];
    private $requestQueryStringArgs = [];
    private $requestRESTArgs = [];

    const CLEAN_URI = 'Sanitizers::cleanURI';
    const CLEAN_STR = 'Sanitizers::cleanInputStr';

    public static function cleanQueryStringArgs($queryStringArgs) 
    {
        if (!is_array($queryStringArgs)) 
            throw new InvalidArgumentException('cleanQueryString Args only accepts arrays as argument. Argument was not array');
        return array_map(CLEAN_URI, $queryStringArgs);
    }

    public static function BuildRequest($overridingURI = null)
    {
        $request = new Self;
        // $_SERVER['REQUEST_URI'] is not completely trustworthy
        // thus it would be best to pass an overriding URI into this method
        // passed to the php script from the web server
        // such as by using redirect rules on the apache web server
        if (isset($overridingURI)) 
            $request->setURI($overridingURI); 
        else
            $request->setURI($_SERVER['REQUEST_URI']);
        // REQUEST_METHOD is not 100% reliable, therefore a setter is used for validation
        $request->setHTTPType($_SERVER['REQUEST_METHOD']);
        $request->requestHTTPProtocol = getHTTPProtocol();
        $request->setHeaders(getAllHeaders());
        $request->requestClientRemoteAddr = getClientRemoteAddr();
        // There is no case where this property should need to be modified
        // Futhermore no validation / sanitization is requires for REQUEST_Time
        // Therefore this property requires no setter, only a getter
        $this->requestDateTime = $_SERVER['REQUEST_TIME'];
        $request->setBodyArgs(stream_get_contents(STDIN));
        $request->setQueryStringArgs($_REQUEST);
        return $request;
    }

    public function setURI($url)
    {
        $cleanedURI = Sanitizers::cleanURI(parse_url($url, PHP_URL_PATH));
        $this->requestURI = $cleanedURI;
    }

    public function getURI()
    {
        return $this->requestURI;
    }

    public function setHTTPType($type)
    {
        if(!Helpers::isValidHTTPRequestType($type))
            throw new InvalidArgumentException("{$type} is not a supported (GET, POST, PUT, DELETE) HTTP type.");
        $this->requestHTTPType = $type;
    }

    public function getHTTPType()
    {
        return $this->requestHTTPType;
    }

    public function setHeaders($headers)
    {
        $this->requestHeaders = array_map(function($header) {
            return Sanitizers::cleanURI($header);
        }, $headers);
    }

    public function getHeaders()
    {
        return $this->requestHeaders;
    }

    public function setBodyArgs($bodyArgs)
    {
        if(!is_array($bodyArgs)) 
            throw new InvalidArgumentException("The argument passed is not an array. An array must be passed to the setBodyArgs method.");
        $this->requestBodyArgs = array_map(function($val)
        {
            return Sanitizers::cleanInputStr($val, true);
        }, $bodyArgs);
    }

    public function getBodyArgs()
    {
        return $this->requestBodyArgs;
    }

    public function setQueryStringArgs($queryStringArgs)
    {
        if(!is_array($queryStringArgs)) 
            throw new InvalidArgumentException("The argument passed is not an array. An array must be passed to the setQueryStringArgs method.");
        $this->requestQueryStringArgs = Sanitizers::stripAllTags($queryStringArgs);
    }

    public function getQueryStringArgs()
    {
        return $this->requestQueryStringArgs;
    }

    public function setRESTArgs($routeURI)
    {
        $cleanedRouteURI = Sanitizers::cleanURI(parse_url($routeURI, PHP_URL_PATH));
        $cleanedRouteURI = array_map(function($val)
        {
            return trim($val, "{}");
        }, $cleanedRouteURI);   
        $exactURIArr = explode(Constants::DELIM_URI, trim($this->requestURI, Constants::DELIM_URI));
        $matchedURIArr = explode(Constants::DELIM_URI, trim($cleanedRouteURI, Constants::DELIM_URI));
        $arrDiffPairs = Helpers::arrayTrueDiff($exactURIArr, $matchedURIArr);
        $this->requestRESTArgs = Helpers::convertValPairsToAssociate($arrDiffPairs);
    }

    public function getRESTArgs()
    {
        return $this->requestRESTArgs();
    }

    public function isHTTPS()
    {
        return ($this->requestHTTPProtocol === Constants::HTTPS);
    }

    public function __get($memberName)
    {
        $val = (array_key_exists($memberName, $this->requestRESTArgs)) ? $this->requestRESTArgs[$memberName] : null;
        $val = (array_key_exists($memberName, $this->requestQueryStringArgs)) ? $this->requestQueryStringArgs[$memberName] : null;
        $val = (array_key_exists($memberName, $this->requestBodyArgs)) ? $this->requestBodyArgs[$memberName] : null;
        if(!is_null($val)) return $val;
        throw new RuntimeException("{$memberName} property does not exist on Request object");
    }

    public function __set($memberName, $value)
    {
        if(array_key_exists($memberName, $this->requestRESTArgs))
            $this->requestRESTArgs[$memberName] = $value;
        if(array_key_exists($memberName, $this->requestQueryStringArgs))
            $this->requestQueryStringArgs[$memberName] = $value;
        if(array_key_exists($memberName, $this->requestBodyArgs))
            $this->requestBodyArgs[$memberName] = $value;
        throw new RuntimeException("{$memberName} property does not exist on Request object");
    }
}

?>