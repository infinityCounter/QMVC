<?php

namespace QMVC\Base\Routing;

use QMVC\Base\Constants\Constants;
use QMVC\Base\Helpers\Helpers;
use QMVC\Base\Security\Sanitizers;
use QMVC\Base\HTTPContext\Request;

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
    
    function __construct(string $URI = null, array $allowables = [], $handler = null)
    {
        $this->setURI($URI);
        $this->setAllowableActions($allowables);
        $this->setHandler($handler);
    }

    public function setURI(string $URI)
    {
        $this->URI = Sanitizers::cleanURI($URI);
    }

    public function getURI()
    {
        return $this->URI;
    }

    public function setAllowableActions(array $actions)
    {
        $actionTypes = array_keys($actions);
        $cleanedTypes = Sanitizers::cleanInputStrArray($actionTypes, false, true);
        $cleanedActions = array_combine($cleanedTypes, $actions);
        $filteredActions = array_map(function($action){
            if(Helpers::isValidHTTPRequestType($action)) return $action;
        }, $cleanedActions);
        $this->allowableActions = array_merge($this->allowableActions, $filteredActions);
    }

    public function getAllowableActions()
    {
        return $this->allowableActions;
    }

    public function setHandler($handler) 
    {
        if(!Helpers::isValidRouteHandler($handler))
            throw new RuntimeException("Handler is not callable. Argument not method or class with public " . HANDLER_METHOD_SIG . " method.");
        $this->handler = $handler;
    }

    public function getHandler()
    {
        return $this->handler;
    }

    public function callHandler(Request $request)
    {
        if(is_callable($this->handler)) return ($this->handler)($request);
        return call_user_func([$this->handler, Constants::HANDLER_METHOD_SIG], $request);
    }

    // TODO: Implement methods to enable middleware functionality
    public function emptyMiddleware(){}
    public function pushMiddleware(){}
    public function popMiddleware(){}
    public function execMiddleWare(){}
    public function execCallback(){}
}

?>