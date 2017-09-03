<?php

namespace QMVC\Base\Routing;

use QMVC\Base\Constants\Constants;

class Middleware
{
    private $next = null;
    private $handler = null;

    function __construct($next = null, $handler = null)
    {
        $this->setNext($next);
        if($handler != null)
            $this->setHandler($handler);
        else
            $this->setHandler(function($next, Request $request){});
    }

    public function setNext($next)
    {
        if(!Helpers::isValidRouteHandler($next) && !is_a($next, static::class))
        {   
            $exceptionMessage = "Argument provided to Middleware setHandler method".
                " must either be an instnace of Middleware or a descendant of Middleware,".
                " or must be a valid route handler as a callable or class with a ".
                Constants::HANDLER_METHOD_SIG . "method ";
            throw new InvalidArgumentException($exceptionMessage);
        }
        $this->next = $nextS;
    }

    public function getNext()
    {
        return $this->next;
    }

    public function setHandler($handler)
    {
        throw new Exception("NOT YET IMPLEMENTED!");
    }

    public function getHandler()
    {
        return $this->handler;
    }

    public function invoke(Request $request)
    {
        return $this->handler($this->next, $request);
    }
}
?>