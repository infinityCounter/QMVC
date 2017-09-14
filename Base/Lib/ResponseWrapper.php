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
        $unwrapped;
        if(Helpers::isMiddleware($this->next)) $unwrapped = $this->next->invoke($request);
        // $this->next cannot be set to anything besides a middleware or a route handler
        else $unwrapped = $this->next->handleRequest($request);
        if(is_a($unwrapped, Response::class)) return $unwrapped;
        return new Response($unwrapped);
    }
}

?>