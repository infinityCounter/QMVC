<?php

namespace QMVC\Base\Lib;

use QMVC\Base\Helpers;
use QMVC\Base\Routing\Middleware;
use QMVC\Base\HTTPContext\Request;
use QMVC\Base\HTTPContext\Response;

class ResponseWrapper extends Middleware
{
    public function invoke(Request $request)
    {
        $unwrapped = null;
        if(Helpers::isMiddleware($this->next)) 
            $unwrapped = $this->next->invoke($request);
        // $this->next cannot be set to anything besides a middleware or a route handler
        else {
            if(Helpers::isValidRouteHandlerClass($this->next))
            {
                $controller = new $this->next;
                $unwrapped = $controller->handleRequest($request);
            }
            else if (is_callable($this->next))
            {
                $unwrapped = ($this->next)($request);
            }
        }
        if(is_a($unwrapped, Response::class)) return $unwrapped;
        return new Response($unwrapped);
    }
}

?>