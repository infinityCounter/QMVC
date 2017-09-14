<?php

namespace QMVC\Base\Routing;

use QMVC\Base\Security\Sanitizers;
use QMVC\Base\Constants\Constants;

class Router 
{
    private static $routeMap = [];

    public static function getRouteMap()
    {
        return self::$routeMap;
    }

    public static function get(string $URI, $routeHandler, array $middlewares = []) 
    { 
        self::addRoute($URI, [Constants::GET => true], $routeHandler, $middlewares); 
    }

    public static function post(string $URI, $routeHandler, array $middlewares = []) 
    { 
        self::addRoute($URI, [Constants::POST => true], $routeHandler, $middlewares); 
    }

    public static function put(string $URI, $routeHandler, array $middlewares = []) 
    { 
        self::addRoute($URI, [Constants::PUT => true], $routeHandler, $middlewares); 
    }

    public static function delete(string $URI, $routeHandler, array $middlewares = []) 
    { 
        self::addRoute($URI, [Constants::DELETE => true], $routeHandler, $middlewares); 
    }

    public static function any(string $URI, $routeHandler, array $middlewares = [])
    {
        $reqs = [
            Constants::GET => true, 
            Constants::POST => true,
            Constants::PUT => true,
            Constants::DELETE => true
        ];
        self::addRoute($URI, $reqs, $routeHandler, $middlewares);
    }

    public static function addRoute(string $URI, array $reqTypes = [], $routeHandler, array $middlewares = [])
    {
        array_walk($middlewares, function($middleware) {
            if(!Helpers::isMiddleware($middleware))
                throw new InvalidArgumentException("Invalid middleware passed to addRoute method.");
        });
        $cleanedURI = Sanitizers::stripAllTags($URI);
        $cleanReqType = trim(strtoupper($reqType));
        if(!validReqType($cleanReqType)) 
            throw new InvalidArgumentException("${cleanReqType} is not a supported HTTP method.");
        $route = ($routeHandler instanceof Route ) ? new Route($cleanedURI, $reqTypes, $routeHandler) : $routeHandler;
        self::$routeMap[$cleanedURI] = $route; 
    }

    public static function getRoute(string $requestedURI)
    {
        // Requested URI is clean and returned without query string
        // ex. /uri/fX/19/hello/?million=5 => uri/fx/19/hello
        $cleanReqURI = Sanitizers::stripAllTags(strtok($requestedURI, '?'));
        if(isset(self::$routeMap[$cleanReqURI])) return $routeMap[$cleanReqURI];
        foreach ($routeMap as $routeURI => $routeObj) {
            if (self::isURIRegexRoute($cleanReqURI, $routeURI))
            {
                return $routeObj;
            }
        }
        return null;
    }

    public static function isURIRegexRoute(string $URI, string $speculatedURI)
    {
        $cleanedURI = Constants::DELIM_URI . Sanitizers::stripAllTags($URI);
        $cleanSpeculatedURI = Constants::DELIM_URI . Sanitizers::stripAllTags($speculatedURI);
        if ($cleanedURI === $cleanSpeculatedURI) return true;
        return preg_match(self::convertRESTToRegexURI($cleanSpeculatedURI), $cleanedURI);
    }

    private static function convertRESTToRegexURI(string $restURI)
    {
        $preRegexURI = str_replace('/', '\/', $restURI);
        $regexURI = preg_replace("/\/{[a-zA-Z][a-zA-Z0-9]*}/", '/[a-zA-Z0-9.()]+', $preRegexURI);
        $regexURI = "/\A" . $regexURI . "\z/";
        return $regexURI;
    }
}

?>