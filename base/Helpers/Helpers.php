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

function arrayTrueDiff($arr1, $arr2, $typeStrict = false)
{
    if(!is_array($arr1) || !is_array($arr2))
        throw new InvalidArgumentException("Invalid argument passed, array expected, argument supplied is not array.");
    $array1Len = count($arr1);
    $array2Len = count($arr2);
    $diffArr = [];
    $constraintLen = ($array1Len < $array2Len) ? $array2Len : $array1Len;
    for($counter = 0; $counter < $constraintLen; $counter++)
    {
        if(!isset($arr1[$counter]))
        {
            array_push($diffArr, [null, $arr2[$counter]]);
        }
        else if(!isset($arr2[$counter]))
        {
            array_push($diffArr, [$arr1[$counter], null]);
        }
        else if(($typeStrict && $arr1[$counter] !== $arr2[$counter]) || 
                (!$typeStrict && $arr1[$counter] != $arr2[$counter]))
        {
            array_push($diffArr, [$arr1[$counter], $arr2[$counter]]);
        }               
    }
    return $diffArr;
}

function convertValPairsToAssociate($valPairsArr)
{
    if(!is_array($valPairsArr))
        throw new InvalidArgumentException("Invalid argument passed, array expected, argument supplied is not array.");
    $associateArray = [];
    foreach($valPairsArr as $valPair)
    {
        if(!is_array($valPairsArr))
            throw new InvalidArgumentException("Invalid argument passed. All array members must be an array of pair values.");
        $associateArray[$valPair[0]] = $valPair[1];
    }
    return $associateArray;
}
?>