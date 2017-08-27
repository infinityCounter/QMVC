<?php

namespace QMVC\Base\Routing;
use QMVC\Base\Security as Security;

function objectHasPublicRequestHandler($object)
{
    if(!method_exists($object, HANDLER_METHOD_SIG) ) return false;
    $reflection = new ReflectionMethod($object, HANDLER_METHOD_SIG);
    if (!$reflection->isPublic()) return false;
    return true;
}

function validRouteHandler($uncheckedHandler) 
{
    if(is_callable($uncheckedHandler)) return true;
    if(is_object($uncheckedHandler) && 
       objectHasPublicRequestHandler($uncheckedHandler)) return true;
    return false;
}

function cleanURI($dirtyURI)
{
    return Security::cleanInputStr(strtolower($dirtyURI));
}

function validRequestType($unsureType)
{
    if($unsureType == GET) return true;
    if($unsureType == POST) return true;
    if($unsureType == PUT) return true;
    if($unsureType == DELETE) return true;
    return false;
}
?>