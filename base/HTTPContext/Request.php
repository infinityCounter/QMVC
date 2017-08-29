<?php

namespace QMVC\Base\HTTPContext;

use QMVC\Base\Helpers;
use QMVC\Base\Security;

class Request
{
    private $requestURI;
    private $requestHTTPType;
    private $requestHTTPProtocol;
    private $requestHeaders;
    private $requestClientRemoteAddr;
    private $requestDateTime;
    private $requestBodyArgs;
    private $requestQueryStringArgs;
    private $requestRESTArgs;

    const CLEAN_URI = 'cleanURI';
    const CLEAN_STR = 'cleanInputStr';

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
            $request->setRequestURI($overridingURI); 
        else
            $request->setRequestURI($_SERVER['REQUEST_URI']);
        // REQUEST_METHOD is not 100% reliable, therefore a setter is used for validation
        $request->setRequestHTTPType($_SERVER['REQUEST_METHOD']);
        $request->requestHTTPProtocol = getHTTPProtocol();
        $request->setRequestHeaders(getAllHeaders());
        $request->requestClientRemoteAddr = getClientRemoteAddr();
        // There is no case where this property should need to be modified
        // Futhermore no validation / sanitization is requires for REQUEST_Time
        // Therefore this property requires no setter, only a getter
        $this->requestDateTime = $_SERVER['REQUEST_TIME'];
        $request->setRequestBodyArgs(stream_get_contents(STDIN));
        $request->setRequestQueryStringArgs($_REQUEST);
        return $request;
    }

    public function setRequestURI($url)
    {
        $cleanedURI = cleanURI(parse_url($url, PHP_URL_PATH));
        $this->requestURI = $cleanedURI;
    }

    public function setRequestHTTPType($type)
    {
        if(!isValidHTTPRequestType($type))
            throw new InvalidArgumentException("{$type} is not a supported (GET, POST, PUT, DELETE) HTTP type.");
        $this->requestHTTPType = $type;
    }

    public function setRequestHeaders($headers)
    {
        $this->requestHeaders = array_map(CLEAN_STR, $headers);
    }

    public function setRequestBodyArgs($bodyArgs)
    {
        throw new Exception("NOT YET IMPELEMENTED!");
    }

    public function setRequestQueryStringArgs()
    {
        throw new Exception("NOT YET IMPELEMENTED!");
    }

    public function setRequestRESTArgs($routeURI)
    {
        throw new Exception("NOT YET IMPELEMENTED!");
    }

    public function isHTTPS()
    {
        return ($this->requestHTTPProtocol === HTTPS);
    }

    public function __get($memberName)
    {
        $val = (array_key_exists($memberName, $this->requestRESTArgs)) ? $this->requestRESTArgs[$memberName] : null;
        $val = (array_key_exists($memberName, $this->requestQueryStringArgs)) ? $this->requestQueryStringArgs[$memberName] : null;
        $val = (array_key_exists($memberName, $this->requestBodyArgs)) ? $this->requestBodyArgs[$memberName] : null;
        if(!is_null($val)) return $val;
        throw new RuntimeException("{$memberName} property does not exist on Request object");
    }

    public function __set($memeberName, $value)
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