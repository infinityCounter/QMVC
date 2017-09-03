<?php

namespace QMVC\Base\Routing;

use QMVC\Base\Security\Sanitizers;
use QMVC\Base\Security\Constants;

class Router 
{
    private static $routeMap = [];

    public static function getRouteMap()
    {
        return self::$routeMap;
    }

    public static function get(string $URI, $routeHandler) 
    { 
        self::addRoute($URI, [Constants::GET => true], $routeHandler); 
    }

    public static function post(string $URI, $routeHandler) 
    { 
        self::addRoute($URI, [Constants::POST => true], $routeHandler); 
    }

    public static function put(string $URI, $routeHandler) 
    { 
        self::addRoute($URI, [Constants::PUT => true], $routeHandler); 
    }

    public static function delete(string $URI, $routeHandler) 
    { 
        self::addRoute($URI, [Constants::DELETE => true], $routeHandler); 
    }

    public static function any(string $URI, $routeHandler)
    {
        $reqs = [
            Constants::GET => true, 
            Constants::POST => true,
            Constants::PUT => true,
            Constants::DELETE => true
        ];
        self::addRoute($URI, $reqs, $routeHandler);
    }

    public static function addRoute(string $URI, array $reqTypes = [], $routeHandler)
    {
        $cleanedURI = Sanitizers::cleanURI($URI);
        $cleanReqType = trim(strtoupper($reqType));
        if(!validReqType($cleanReqType)) 
            throw new InvalidArgumentException("${cleanReqType} is not a supported HTTP method.");
        $route = ($routeHandler instanceof Route ) ? new Route($cleanedURI, $reqTypes, $routeHandler) : $routeHandler;
        self::$routeMap[$cleanedURI] = $route; 
    }

    public static function getRoute($requestedURI)
    {
        // Requested URI is clean and returned without query string
        // ex. /uri/fX/19/hello/?million=5 => uri/fx/19/hello
        $cleanReqURI = Sanitizers::cleanURI(strtok($requestedURI, '?'));
        if(isset(self::$routeMap[$cleanReqURI])) return $routeMap[$cleanReqURI];
        foreach ($routeMap as $routeURI => $routeObj) {
            if (self::isURIRegexRoute($cleanReqURI, $routeURI))
            {
                return $routeObj;
            }
        }
        return null;
    }

    public static function isURIRegexRoute($URI, $speculatedURI)
    {
        $cleanedURI = Sanitizers::cleanURI($URI);
        $cleanSpeculatedURI = Sanitizers::cleanURI($speculatedURI);
        if ($cleanedURI === $cleanSpeculatedURI) return true;
        $preRegexURI = str_replace('/', '\/', $cleanSpeculatedURI);
        $regexURI = preg_replace("/\/{[a-zA-Z][a-zA-Z0-9]*}/", '/[a-zA-Z0-9.()]+', $preRegexURI);
        $regexURI = "/\A" . $regexURI . "\z/";
        return preg_match($regexURI, $cleanedURI);
    }
}

?>