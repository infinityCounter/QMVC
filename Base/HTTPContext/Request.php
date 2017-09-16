<?php

namespace QMVC\Base\HTTPContext;

require_once('FileUpload.php');
require_once(dirname(__DIR__) . '/Helpers.php');
require_once(dirname(__DIR__) . '/Constants.php');
require_once(dirname(__DIR__) . '/AppConfig.php');
require_once(dirname(__DIR__) . '/Security/Sanitizers.php');

use QMVC\Base\Helpers;
use QMVC\Base\Constants;
use QMVC\Base\AppConfig;
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

    public static function cleanQueryStringArgs($queryStringArgs) 
    {
        if (!is_array($queryStringArgs)) 
            throw new InvalidArgumentException('cleanQueryString Args only accepts arrays as argument. Argument was not array');
        return array_map(function($arg) {
            return Sanitizers::stripAllTags($arg);
        }, $queryStringArgs);
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
        $request->requestHTTPProtocol = Helpers::getHTTPProtocol();
        $request->setHeaders(Helpers::getAllHeaders());
        $request->requestClientRemoteAddr = Helpers::getClientRemoteAddr();
        // There is no case where this property should need to be modified
        // Futhermore no validation / sanitization is requires for REQUEST_Time
        // Therefore this property requires no setter, only a getter
        $request->requestDateTime = $_SERVER['REQUEST_TIME'];
        $request->setQueryStringArgs($_REQUEST);
        if(isset($_FILES))
        {
            $file = self::getUploadedFile();
            $request->setBodyArgs($file);
        }
        if(isset($_POST))
        {
            $request->setBodyArgs($_POST);
        }
        else
        {
            $request->setBodyArgs(file_get_contents('php://input'));
        }
        return $request;
    }

    private static function getUploadedFile()
    {
        $errs = [];
        $fileKey = array_keys($_FILES)[0];
        // If errors (WHICH SHOULD BE DEFINED) is undefined, if there are multiple files
        // or a corruption
        if (!isset($_FILES[$fileKey]['error']) || is_array($_FILES[$fileKey]['error']))
        {
            array_push($errs, 'Invalid parameters in file upload.');
        }
        switch ($_FILES[$fileKey]['error'])
        {
            case UPLOAD_ERR_OK:
                break;

            case UPLOAD_ERR_NO_FILE:
                return null;
            
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                array_push($errs, 'Uploaded file exceeded filesize limit.');
                return null;
            
            default:
                array_push($errs, 'Unknown errors.');
                return null;
        }
        // Based on configurations of php.ini there can be multiple properties that may limit 
        // file size upload. These may not all fall under UPLOAD_ERR_INI_SIZE and 
        // UPLOAD_ERR_FORM_SIZE, thus double checking here
        if ($_FILES[$fileKey]['size'] > Helpers::getMaxFileUploadInBytes())
        {
            array_push($errs, 'Uploaded file exceeded filesize limit.');
        }
        // MIME type may be altered, checking self
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        var_dump($finfo->file($_FILES[$fileKey]['tmp_name']));
        var_dump(AppConfig::getUploadExtensionsWhitelist());
        if (false === ($ext = array_search($finfo->file($_FILES[$fileKey]['tmp_name']), 
            AppConfig::getUploadExtensionsWhitelist() , true)))
        {
            array_push($errs,'Uploaded invalid file format.');
        }
        $uploadedfile = new FileUpload($_FILES[$fileKey]['tmp_name'], $ext, $_FILES[$fileKey]['size'], $errs);
        return $uploadedfile;
    }

    public function setURI($url)
    {
        $cleanedURI = strtolower(Sanitizers::stripAllTags(parse_url($url, PHP_URL_PATH)));
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
            return Sanitizers::stripAllTags($header);
        }, $headers);
    }

    public function getHeaders()
    {
        return $this->requestHeaders;
    }

    public function setBodyArgs($bodyArgs)
    {
        if(is_array($bodyArgs))
        {
            $this->requestBodyArgs = array_merge($this->requestBodyArgs, array_map(function($val)
            {
                return htmlentities($val, true);
            },  $bodyArgs));
        }
        else if(is_string($bodyArgs) && Helpers::isJson($bodyArgs))
        {
            $this->requestBodyArgs = array_merge($this->requestBodyArgs, json_decode($bodyArgs, true));
        }
        else
        {
            if(is_string($bodyArgs)) $this->requestBodyArgs = htmlentities($bodyArgs);
            else array_push($this->requestBodyArgs, $bodyArgs);
        }
    }

    public function getBodyArgs()
    {
        return $this->requestBodyArgs;
    }

    public function setQueryStringArgs($queryStringArgs)
    {
        if(!is_array($queryStringArgs)) 
            throw new InvalidArgumentException("The argument passed is not an array. An array must be passed to the setQueryStringArgs method.");
        $this->requestQueryStringArgs = array_map(function($arg) {
            return Sanitizers::stripAllTags($arg);
        }, $queryStringArgs);
    }

    public function getQueryStringArgs()
    {
        return $this->requestQueryStringArgs;
    }

    public function setRESTArgs($routeURI)
    {
        $cleanedRouteURI = Sanitizers::stripAllTags(parse_url($routeURI, PHP_URL_PATH));
        $exactURIArr = explode(Constants::DELIM_URI, trim($this->requestURI, Constants::DELIM_URI));
        $matchedURIArr = explode(Constants::DELIM_URI, trim($cleanedRouteURI, Constants::DELIM_URI));
        $matchedURIArr = array_map(function($val)
        {
            return trim($val, "{}");
        }, $matchedURIArr);   
        $arrDiffPairs = Helpers::arrayTrueDiff($matchedURIArr, $exactURIArr);
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
        if (array_key_exists($memberName, $this->requestRESTArgs)) 
            return $this->requestRESTArgs[$memberName];
        if (array_key_exists($memberName, $this->requestQueryStringArgs)) 
            return $this->requestQueryStringArgs[$memberName];
        if (is_array($this->requestBodyArgs) && array_key_exists($memberName, $this->requestBodyArgs)) 
            return $this->requestBodyArgs[$memberName];
        throw new \RuntimeException("{$memberName} property does not exist on Request object");
    }

    public function __set($memberName, $value)
    {
        if(array_key_exists($memberName, $this->requestRESTArgs))
            $this->requestRESTArgs[$memberName] = $value;
        if(array_key_exists($memberName, $this->requestQueryStringArgs))
            $this->requestQueryStringArgs[$memberName] = $value;
        if(is_array($this->requestBodyArgs) && array_key_exists($memberName, $this->requestBodyArgs))
            $this->requestBodyArgs[$memberName] = $value;
        throw new \RuntimeException("{$memberName} property does not exist on Request object");
    }
}

?>