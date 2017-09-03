<?php

namespace QMVC\Base\Security;

use QMVC\Base\Constants\Constants as Constants;

/**
 * function cleanInputStr
 * 
 * @param string $unsanitizedString
 * @param boolean $doTrim
 */

class Sanitizers
{
    public static function cleanInputStr($unsanitizedString, 
        $preserveHTML = false, 
        $doTrim = false)
    {
        $sanitizedString = ($preserveHTML) ? filter_var($unsanitizedString, FILTER_SANITIZE_STRING) : filter_var($unsanitizedString, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        return ($doTrim) ? trim($sanitizedString) : $sanitizedString;
    }
    
    public static function cleanInputStrArray(array $unsanitizedArr, 
        $preserveHTML = false, 
        $doTrim = false)
    {
        $arrayFilter = function($val) use ($preserveHTML, $doTrim)
        {
            return self::cleanInputStr($val, $preserveHTML, $doTrim);
        };
        return array_map($arrayFilter, $unsanitizedArr);
    }
    
    public static function cleanEmail($unsanitizedEmail)
    {
        throw new Exception("NOT YET IMPELEMENTED!");
    }
    
    public static function cleanURI($dirtyURI)
    {
        $URISlashesReplaced = str_replace('\\', '/', $dirtyURI);
        $URISpacesRemoved   = preg_replace( array('/\v/','/\s\s+/'), '', $URISlashesReplaced);
        $URISlashesTrimmed  = trim($URISpacesRemoved, "/");
        return Self::cleanInputStr(strtolower($URISlashesTrimmed));
    }
    
    public static function cleanQueryStringArg($queryStringArg)
    {
        return filter_var($queryStringArg, FILTER_SANITIZE_URL);
    }
}

?>