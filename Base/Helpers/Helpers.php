<?php

namespace QMVC\Base\Helpers;

use QMVC\Base\Constants\Constants;
use QMVC\Base\Security\Sanitizers;
use QMVC\Base\Security\Middleware;

final class Helpers
{
    /* VALIDATORS */
    public static function objectHasPublicRequestHandler($object)
    {
        if(!method_exists($object, Constants::HANDLER_METHOD_SIG) ) return false;
        $reflection = new \ReflectionMethod($object, Constants::HANDLER_METHOD_SIG);
        if (!$reflection->isPublic()) return false;
        return true;
    }

    public static function isValidRouteHandler($uncheckedHandler) 
    {
        if(is_callable($uncheckedHandler)) return true;
        if((is_object($uncheckedHandler) || class_exists($uncheckedHandler)) && 
            Self::objectHasPublicRequestHandler($uncheckedHandler)) return true;
        return false;
    }

    public static function isValidHTTPRequestType($unsureType)
    {
        if($unsureType === Constants::GET) return true;
        if($unsureType === Constants::POST) return true;
        if($unsureType === Constants::PUT) return true;
        if($unsureType === Constants::DELETE) return true;
        return false;
    }

    public static function isMiddleware($speculatedMiddleware)
    {
        return is_a($next, Middleware::class);
    }

    /* END VALIDATORS */

    /* ACCESSORS */
    function getHTTPProtocol()
    {
        return (isset($_SERVER['HTTPS'])) ? HTTPS : HTTP;
    }

    public static function getClientRemoteAddr()
    {
        return (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) ? 
                      $_SERVER['HTTP_X_FORWARDED_FOR'] : 
                      $_SERVER['REMOTE_ADDR'];
    }

    public static function getAllHeaders() 
    { 
        $headers = []; 
        foreach ($_SERVER as $name => $value) 
        { 
            if (substr($name, 0, 5) == 'HTTP_') 
            { 
                $headers[str_replace(' ', '-', 
                                    ucwords(
                                    strtolower(
                                    str_replace('_', ' ', 
                                    substr($name, 5)))))
                        ] = $value; 
            } 
        }    
        return $headers; 
    } 

    public static function isValidRespBodyType(int $type)
    {
        if($type === Constants::FILESTREAM_RESP) return true;
        if($type === Constants::JSON_RESP) return true;
        if($type === Constants::HTML_RESP) return true;
        return false;
    }
    
    /* END ACCESSORS */

    public static function arrayTrueDiff($arr1, $arr2, $typeStrict = false)
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

    public static function convertValPairsToAssociate($valPairsArr)
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
    
    /**
    * Return file size (even for file > 2 Gb)
    * For file size over PHP_INT_MAX (2 147 483 647), PHP filesize function loops from -PHP_INT_MAX to PHP_INT_MAX.
    *
    * @param string $path Path of the file
    * @return mixed File size or false if error
    */
    public static function realFileSize($path)
    {
        $cleanedPath = self::cleanInputStr($path, false, true);
        if (!file_exists($cleanedPath))
            return false;

        $size = filesize($cleanedPath);
    
        if (!($file = fopen($cleanedPath, 'rb')))
            return false;
    
        if ($size >= 0)
        {//Check if it really is a small file (< 2 GB)
            if (fseek($file, 0, SEEK_END) === 0)
            {//It really is a small file
                fclose($file);
                return $size;
            }
        }
    
        //Quickly jump the first 2 GB with fseek. After that fseek is not working on 32 bit php (it uses int internally)
        $size = PHP_INT_MAX - 1;
        if (fseek($file, PHP_INT_MAX - 1) !== 0)
        {
            fclose($file);
            return false;
        }
        $length = 1024 * 1024;
        while (!feof($file))
        {//Read the file until end
            $read = fread($file, $length);
            $size = bcadd($size, $length);
        }
        $size = bcsub($size, $length);
        $size = bcadd($size, strlen($read));
    
        fclose($file);
        return $size;
    }
}
?>