<?php

namespace QMVC\Base\Routing;

class Router 
{
    private static $routeMap = [GET => [], POST => [], PUT => [], DELETE => []];

    public static function getRouteMap()
    {
        return self::$routeMap;
    }

    public static function get($URI, $routeHandler) 
    { 
        self::addRoute($URI, GET, $routeHandler); 
    }

    public static function post($URI, $routeHandler) 
    { 
        self::addRoute($URI, POST, $routeHandler); 
    }

    public static function put($URI, $routeHandler) 
    { 
        self::addRoute($URI, PUT, $routeHandler); 
    }

    public static function delete($URI, $routeHandler) 
    { 
        self::addRoute($URI, DELETE, $routeHandler); 
    }

    public static function any($URI, $routeHandler)
    {
        self::get($URI, $routeHandler);
        self::post($URI, $routeHandler);
        self::put($URI, $routeHandler);
        self::delete($URI, $routeHandler);
    }

    public static function addRoute($URI, $reqType, $routeHandler)
    {
        $Sanitizers::cleanURI = Sanitizers::cleanURI($URI);
        $cleanReqType = trim(strtoupper($reqType));
        if(!validReqType($cleanReqType)) 
            throw new InvalidArgumentException("${cleanReqType} is not a supported HTTP method.");
        $route = ($routeHandler instanceof Route ) ? new Route($Sanitizers::cleanURI, $routeHandler) : $routeHandler;
        self::$routeMap[$cleanReqType][$Sanitizers::cleanURI] = $route; 
    }

    public static function matchRoute($requestedURI)
    {
        // Requested URI is clean and returned without query string
        // ex. /uri/fX/19/hello/?million=5 => uri/fx/19/hello
        $cleanReqURI = Sanitizers::cleanURI(strtok($requestedURI, '?'));
        
    }
}

?>