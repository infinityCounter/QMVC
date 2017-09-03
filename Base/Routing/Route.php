<?php

namespace QMVC\Base\Routing;

use QMVC\Base\Constants\Constants;
use QMVC\Base\Helpers\Helpers;
use QMVC\Base\Security\Sanitizers;
use QMVC\Base\HTTPContext\Request;
use QMVC\Base\HTTPContext\Response;
use QMVC\Base\Routing\Middleware;
use QMVC\Base\Lib\ResponseWrapper;

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
        $cleanedTypes = Sanitizers::cleanInputStrArray($actionTypes, false, true);
        $cleanedActions = array_combine($cleanedTypes, $actions);
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
        $this->pushResponseWrapperMiddleware();
    }

    public function pushMiddleware($handler)
    {
        if(!is_callable($handler) && !Helpers::isMiddleware($handler))
            throw new InvalidArgumentException("Argument must either be callable or a descendant of the Middleware class.");
        if(is_callable($handler))
        {
            // Create new middleware pointing to route handler
            $newMidware = $this->createMiddlewareFromCallable($handler);
            // get the current number of middleware
            $numMidware = count($this->middlwareStack);
            // get the current last middleware
            $currentLastMidware = $this->middlewareStack[$numMidware - 1];
            $currentLastMidware->setNext($newMidware);
            $this->middlewareStack[$numMidware - 1] = $currentLastMidware;
            // Push new middleware to stack
            array_push($this->middlewareStack, $newMidware);
        } 
        else 
        {
            $newMidware = $handler;
            $numMidware = count($this->middlwareStack);
            $currentLastMidware = $this->middlewareStack[$numMidware - 1];
            $newMidware->setNext($currentLastMidware->getNext());
            $currentLastMidware->setNext($newMidware);
            $this->middlewareStack[$numMidware - 1] = $currentLastMidware;
            // Push new middleware to stack
            array_push($this->middlewareStack, $newMidware);
        }
        $this->removeFrontMiddlewareStack();
        $this->pushResponseWrapperMiddleware();
    }

    private function createMiddlewareFromCallable(callable $callable)
    {
        $numMidware = count($this->middlwareStack);
        if($numMidware > 0)
        {
            $currentLastMidware = $this->middlewareStack[$numMidware - 1];
            return new Middlware($currentLastMidware->getNext(), $callable);
        } 
        else
        {
            return new Middlware($this->handler, $callback);
        }
    }

    private function pushResponseWrapperMiddleware()
    {
        $wrapper = new ResponseWrapper($this->handler);
        $numMidware = count($this->middlewareStack);
        if($numMidware > 0)
        {
            $currentLastMidware = $this->middlewareStack[$numMidware - 1];
            $currentLastMidware->setNext($wrapper);
            $this->middlewareStack[$numMidware - 1] = $currentLastMidware;
        }
        array_push($this->middlewareStack, $wrapper);
    }

    private function removeFrontMiddlewareStack()
    {
        $this->middlewareStack = array_shift($this->middlewareStack);
    }

    public function getNumMiddleware()
    {
        return count($this->middlewareStack);
    }

    public function popMiddleware()
    {
        $this->middlewareStack = array_pop($this->middlewareStack);
    }

    public function execPipeline(Request $request): Response
    {
        // Invoke request should chain down piple of middlewares and route handler and back up
        return $this->middlewareStack[0]->invoke($request);
    }
}

?>