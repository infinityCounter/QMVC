<?php

namespace QMVC\Base\Routing;

class Router 
{
    private $routeMap = [GET => [], POST => [], PUT => [], DELETE => []];

    public function get($URI, $routeHandler) 
    { 
        addRoute($URI, GET, $routeHandler); 
    }

    public function post($URI, $routeHandler) 
    { 
        addRoute($URI, POST, $routeHandler); 
    }

    public function put($URI, $routeHandler) 
    { 
        addRoute($URI, PUT, $routeHandler); 
    }

    public function delete($URI, $routeHandler) 
    { 
        addRoute($URI, DELETE, $routeHandler); 
    }

    public function addRoute($URI, $reqType, $routeHandler)
    {
        $cleanURI = cleanURI($URI);
        $cleanReqType = trim(strtoupper($reqType));
        if(!validReqType($cleanReqType)) 
            throw new InvalidArgumentException("${cleanReqType} is not a supported HTTP method.");
        $route = ($routeHandler instanceof Route ) ? new Route($cleanURI, $routeHandler) : $routeHandler;
        $this->routeMap[$cleanReqType][$cleanURI] = $route; 
    }
}

?>