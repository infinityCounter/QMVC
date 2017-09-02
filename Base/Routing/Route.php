<?php

namespace QMVC\Base\Routing;

use QMVC\Base\Contants\Contants as Constants;
use QMVC\Base\Helpers\Helpers as Helpers;

class Route 
{
    private $URI = null;
    private $handler = null;
    // TODO: Implement middleware stack to execute before callback
    private $middlewareStack = [];
    private $allowableActions = [
        Constants::GET => false,
        Constants::POST => false,
        Constants::PUT => false,
        Constants::DELETE => false
    ];
    
    function __construct(string $URI = null, array $allowbles = [], $handler = null)
    {
        $this->setURI($URI);
        $this->setAllowableActions($allowables);
        $this->setHandler($handler);
    }

    public function setURI($URI)
    {
        $this->URI = Sanitizers::cleanURI($URI);
    }

    public function getURI($URI)
    {
        return $this->getURI;
    }

    public function setAllowableActions(array $actions)
    {
        $actionTypes = array_keys($actions);
        $cleanedTypes = Helpers::cleanInputStrArray($actionTypes, false, true);
        $cleanedActions = Helpers::cleanedInputStrArray($actions, false, true);
        array_combine($cleanedTypes, $cleanedActions);
        $filteredActions = array_map(function($action){
            if(Helpers::isValidHTTPRequestType($action)) return $action;
        }, $cleanedActions);
        array_merge($this->allowableActions, $filteredActions);
    }

    public function getAllowableActions()
    {
        return $this->allowableActions;
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