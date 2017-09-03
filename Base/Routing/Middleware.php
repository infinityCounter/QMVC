<?php

namespace QMVC\Base\Routing;

use QMVC\Base\Helpers\Helpers;
use QMVC\Base\Constants\Constants;
use QMVC\Base\HTTPContext\Request;

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
        if(!Helpers::isValidRouteHandler($next) && !Helpers::isMiddlware($next))
        {   
            $exceptionMessage = "Argument provided to Middleware setHandler method".
                " must either be an instnace of Middleware or a descendant of Middleware,".
                " or must be a valid route handler as a callable or class with a ".
                Constants::HANDLER_METHOD_SIG . "method ";
            throw new \InvalidArgumentException($exceptionMessage);
        }
        $this->next = $next;
    }

    public function getNext()
    {
        return $this->next;
    }

    public function setHandler(callable $handler)
    {
        $this->handler = $handler;
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