<?php
    
namespace QMVC\Base\Security;

/**
* function cleanInputStr
* 
* @param string $unsanitizedString
* @param boolean $doTrim
*/

function cleanInputStr($unsanitizedString, $preserveHTML = false, $doTrim = false)
{
    $sanitizedString = ($preserveHTML) ?
                        filter_var($unsanitizedString, FILTER_SANITIZE_STRING) :
                        filter_var($unsanitizedString, FILTER)
    return ($doTrim) ? trim($sanitizedString) : $sanitizedString;
}

function cleanEmail($unsanitizedEmail)
{
    throw new Exception("NOT YET IMPELEMENTED!");
}

function cleanHTML($unsanitizedHTML, $doTrim = false)
{
    $sanitizedHTML = filter_var($unsanitizedHTML, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    return ($doTrim) ? trim($sanitizedHTML) : $sanitizedHTML;
}

function cleanURI($dirtyURI)
{
    return cleanInputStr(strtolower($dirtyURI));
}

?>