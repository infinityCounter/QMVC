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
    public static function stripScriptTags($unstrippedString)
    {
         return preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/i', '', $unstrippedString);
    }

    public static function stripClosingTags($unstrippedString)
    {
        return preg_replace('/(<.*>).*(<\/.*>)*/','', $unstrippedString);
    }

    public static function stripPHPTags($unstrippedString)
    {
        return preg_replace('/(<\?).*(\?>)*/', '', $unstrippedString);
    }

    public static function cleanInputStr($unsanitizedString, $preserveHTML = false)
    {
        $sanitizedString = ($preserveHTML) ? filter_var($unsanitizedString, FILTER_SANITIZE_FULL_SPECIAL_CHARS) : filter_var($unsanitizedString, FILTER_SANITIZE_STRING);
        return preg_replace('/\s+/', ' ', $sanitizedString);
    }
    
    public static function cleanInputStrArray(array $unsanitizedArr, $preserveHTML = false)
    {
        $arrayFilter = function($val) use ($preserveHTML)
        {
            return self::cleanInputStr($val, $preserveHTML);
        };
        return array_map($arrayFilter, $unsanitizedArr);
    }
    
    public static function cleanURI($dirtyURI)
    {
        $URISlashesReplaced = str_replace('\\', '/', $dirtyURI);
        $URISpacesRemoved   = preg_replace( array('/\v/','/\s\s+/'), '', $URISlashesReplaced);
        $URISlashesTrimmed  = trim($URISpacesRemoved, "/");
        return preg_replace("/[^a-zA-Z0-9\-._~:\/?#\[\]@!$&'()*+,;=`]/",'',(strtolower($URISlashesTrimmed)));
    }
    
    public static function cleanQueryStringArg($queryStringArg)
    {
        return filter_var($queryStringArg, FILTER_SANITIZE_URL);
    }
}

?>