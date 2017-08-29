<?php

namespace QMVC\Base\Routing;

class Route 
{
    private $URI = null;
    private $handler = null;
    // TODO: Implement middleware stack to execute before callback
    private $middlewareStack = [];
    
    function __construct($URI = null, $handler = null)
    {
        $this->setURI($URI);
        $this->setHandler($handler);
    }

    public function setURI($URI)
    {
        $this->URI = cleanURI($URI);
    }

    public function getURI($URI)
    {
        return $this->getURI;
    }

    public function setHandler($handler) 
    {
        if(!isValidRouteHandler($handler))
            throw new RuntimeException("Handler is not callable. Argument not method or class with public " . HANDLER_METHOD_SIG . " method.");
        $this->handler = $handler;
    }

    public function getHandler()
    {
        return $this->handler;
    }

    public function callHandler($request)
    {
        if(is_callable($this->handler)) return $handler($request);
        return call_user_func([$this->handler, HANDLER_METHOD_SIG], $request);
    }

    // TODO: Implement methods to enable middleware functionality
    public function emptyMiddleware(){}
    public function pushMiddleware(){}
    public function popMiddleware(){}
    public function execMiddleWare(){}
    public function execCallback(){}
}

?>