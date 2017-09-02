<?php

namespace QMVC\Base\Security;

/**
 * function cleanInputStr
 * 
 * @param string $unsanitizedString
 * @param boolean $doTrim
 */

class Sanitizers
{
    public static function cleanInputStr($unsanitizedString, $preserveHTML = false, $doTrim = false)
    {
        $sanitizedString = ($preserveHTML) ? filter_var($unsanitizedString, FILTER_SANITIZE_STRING) : filter_var($unsanitizedString, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        return ($doTrim) ? trim($sanitizedString) : $sanitizedString;
    }
    
    public static function cleanInputStrArray($unsanitizedArr, $preserveHTML = false, $doTrim = false)
    {
        if (!is_array($unsanitizedArr))
            throw new InvalidArgumentException("The argument passed is not an array. An array must be passed to the cleanInputStrArray method.");
        return array_map(function($val)
        {
            return Self::cleanInputStr($val, $preserveHTML, $doTrim);
        }, $unsanitizedArr);
    }
    
    public static function cleanEmail($unsanitizedEmail)
    {
        throw new Exception("NOT YET IMPELEMENTED!");
    }
    
    public static function cleanURI($dirtyURI)
    {
        return Self::cleanInputStr(strtolower($dirtyURI));
    }
    
    public static function cleanQueryStringArg($queryStringArg)
    {
        return filter_var($queryStringArg, FILTER_SANITIZE_URL);
    }
}

?>