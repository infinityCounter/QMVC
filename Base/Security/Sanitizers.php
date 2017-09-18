<?php

namespace QMVC\Base\Security;

require_once(dirname(__DIR__) . '/Constants.php');

use QMVC\Base\Constants;

class Sanitizers
{
    public static function stripScriptTags(string $unstrippedString)
    {
         return preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/i', '', $unstrippedString);
    }

    public static function stripClosingTags(string $unstrippedString)
    {
        return preg_replace('/(<.*>).*?(<\/.*>)*/','', $unstrippedString);
    }

    public static function stripPHPTags(string $unstrippedString)
    {
        return preg_replace('/(<\?).*(\?>)*/', '', $unstrippedString);
    }

    public static function stripAllTags(string $unstrippedString)
    {
        $noScript = self::stripScriptTags($unstrippedString);
        $noXML = self::stripClosingTags($noScript);
        $noPHP = self::stripPHPTags($noXML);
        return $noPHP;
    }

    public static function cleanURI(string $dirtyURI)
    {
        $URISlashesReplaced = str_replace('\\', '/', $dirtyURI);
        $URISpacesRemoved   = preg_replace( array('/\v/','/\s\s+/'), '', $URISlashesReplaced);
        $URISlashesTrimmed  = trim($URISpacesRemoved, "/");
        return self::stripAllTags($URISlashesTrimmed);
    }
}

?>