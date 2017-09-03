<?php

namespace QMVC\Base\Routing;

use QMVC\Base\Constants\Constants;

abstract class Middleware
{
    private $next = null;
    private $handler = null;

    function __construct($next = null)
    {
        if($next != null)
            $this->setHandler($next);
        else
            $this->setHandler(function($next, Request $request){});
    }

    public function setHandler($next)
    {
        if(!Helpers::isValidRouteHandler($next) && !is_a($next, static::class))
        {   
            $exceptionMessage = "Argument provided to Middleware setHandler method".
                " must either be an instnace of Middleware or a descendant of Middleware,".
                " or must be a valid route handler as a callable or class with a ".
                Constants::HANDLER_METHOD_SIG . "method ";
            throw new InvalidArgumentException($exceptionMessage);
        }
        
    }

    public function invoke(Request $request)
    {
        return $this->handler($this->next, $request);
    }
}
?>