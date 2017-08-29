<?php

namespace QMVC\Base\Helpers;

use QMVC\Base\Constants as Constants;
use QMVC\Base\Security as Security;

/* VALIDATORS */
function objectHasPublicRequestHandler($object)
{
    if(!method_exists($object, HANDLER_METHOD_SIG) ) return false;
    $reflection = new ReflectionMethod($object, HANDLER_METHOD_SIG);
    if (!$reflection->isPublic()) return false;
    return true;
}

function isValidRouteHandler($uncheckedHandler) 
{
    if(is_callable($uncheckedHandler)) return true;
    if(is_object($uncheckedHandler) && 
       objectHasPublicRequestHandler($uncheckedHandler)) return true;
    return false;
}

function isValidHTTPRequestType($unsureType)
{
    if($unsureType == GET) return true;
    if($unsureType == POST) return true;
    if($unsureType == PUT) return true;
    if($unsureType == DELETE) return true;
    return false;
}

/* END VALIDATORS */

/* ACCESSORS */
function getHTTPProtocol()
{
    return (isset($_SERVER['HTTPS'])) ? HTTPS : HTTP;
}

function getClientRemoteAddr()
{
    return (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) ? 
                    $_SERVER['HTTP_X_FORWARDED_FOR'] : 
                    $_SERVER['REMOTE_ADDR'];
}

// getAllHeadersDefined in Apache Extensions
if (!function_exists('getAllHeaders')) 
{ 
    function getAllHeaders() 
    { 
        $headers = []; 
        foreach ($_SERVER as $name => $value) 
        { 
            if (substr($name, 0, 5) == 'HTTP_') 
            { 
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value; 
            } 
        } 
        return $headers; 
    } 
} 

/* END ACCESSORS */
?>