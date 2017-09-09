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
        return preg_replace('/(<.*>).*?(<\/.*>)*/','', $unstrippedString);
    }

    public static function stripPHPTags($unstrippedString)
    {
        return preg_replace('/(<\?).*(\?>)*/', '', $unstrippedString);
    }

    public static function stripAllTags($unstrippedString)
    {
        $noScriptTags = self::stripScriptTags($unstrippedString);
        $noClosingTags = self::stripClosingTags($noScriptTags);
        $noPHPTags = self::stripPHPTags($noClosingTags);
        return $noPHPTags;
    }

    public static function cleanURI($dirtyURI)
    {
        $URISlashesReplaced = str_replace('\\', '/', $dirtyURI);
        $URISpacesRemoved   = preg_replace( array('/\v/','/\s\s+/'), '', $URISlashesReplaced);
        $URISlashesTrimmed  = trim($URISpacesRemoved, "/");
        return preg_replace("/[^a-zA-Z0-9\-._~:\/?#\[\]@!$&'()*+,;=`]/",'',(strtolower($URISlashesTrimmed)));
    }
}

?>