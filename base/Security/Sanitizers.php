<?php
    
namespace QMVC\Base\Security;

/**
* function cleanInputStr
* 
* @param string $unsanitizedString
* @param boolean $doTrim
*/

function cleanInputStr($unsanitizedString, $doTrim = false)
{
    $sanitizedString = filter_var($unsanitizedString, FILTER_SANITIZE_STRING);
    return ($doTrim) ? trim($sanitizedString) : $sanitizedString;
}

function cleanEmail($unsanitizedEmail)
{

}

function cleanHTML($unsanitizedHTML, $doTrim = false)
{
    $sanitizedHTML = filter_var($unsanitizedHTML, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    return ($doTrim) ? trim($sanitizedHTML) : $sanitizedHTML;
}

?>