<?php

namespace QMVC\Base\Routing;

require_once(dirname(__DIR__) . '/Constants.php');
require_once(dirname(__DIR__) . '/Helpers.php');
require_once(dirname(__DIR__) . '/Security/Sanitizers.php');
require_once(dirname(__DIR__) . '/HTTPContext/Request.php');
require_once(dirname(__DIR__) . '/HTTPContext/Response.php');
require_once(dirname(__DIR__) . '/Routing/Middleware.php');
require_once(dirname(__DIR__) . '/Lib/ResponseWrapper.php');

use QMVC\Base\Constants;
use QMVC\Base\Helpers;
use QMVC\Base\Security\Sanitizers;
use QMVC\Base\HTTPContext\Request;
use QMVC\Base\HTTPContext\Response;
use QMVC\Base\Lib\ResponseWrapper;

final class Route 
{
    private $URI = null;
    private $handler = null;
    // TODO: Implement middleware stack to execute before callback
    private $middlewareStack = [];
    private $respWrapper = null;
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
        $this->pushResponseWrapperMiddleware();
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
        $cleanedTypes = array_map(function($actionType) {
            return Sanitizers::stripAllTags($actionType);
        }, $actionTypes);
        $cleanedActions = array_map(function($action) {
            return (bool)Sanitizers::stripAllTags((string)$action);
        }, $actions);
        $filteredActions = array_filter($cleanedActions, function($action){
            if(Helpers::isValidHTTPRequestType($action)) return $action;
        }, ARRAY_FILTER_USE_KEY);
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
    public function emptyMiddleware()
    {
        $this->middlewareStack = [];
    }

    public function pushMiddleware($handler)
    {
        if(!is_callable($handler) && !Helpers::isMiddleware($handler))
            throw new \InvalidArgumentException("Argument must either be callable or a descendant of the Middleware class.");
        $newMidware = null;
        $numMidware = count($this->middlewareStack);
        if(is_callable($handler))
        {
            // Create new middleware pointing to route handler
            $newMidware = new Middleware($this->respWrapper, $handler);
        } 
        else 
        {
            $newMidware = new $handler;
            $newMidware->setNext($this->respWrapper);
        }
            
        if($numMidware !== 0)
        {
            // get the current last middleware
            $currentLastMidware = $this->middlewareStack[$numMidware - 1];
            $currentLastMidware->setNext($newMidware);
            $this->middlewareStack[$numMidware - 1] = $currentLastMidware;
        }
        // Push new middleware to stack
        array_push($this->middlewareStack, $newMidware);
    }

    private function pushResponseWrapperMiddleware()
    {
        $wrapper = new ResponseWrapper($this->handler);
        $this->respWrapper = $wrapper;
    }

    private function removeFrontMiddlewareStack()
    {
        return array_shift($this->middlewareStack);
    }

    public function getNumMiddleware()
    {
        return count($this->middlewareStack) + 1;
    }

    public function popMiddleware()
    {
        return array_pop($this->middlewareStack);
    }

    public function execPipeline(Request $request)
    {
        // Invoke request should chain down piple of middlewares and route handler and back up
        if(count($this->middlewareStack) > 0)
            return $this->middlewareStack[0]->invoke($request);
        else
            return $this->respWrapper->invoke($request);
    }
}

?>