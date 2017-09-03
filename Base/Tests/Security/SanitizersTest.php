<?php

use PHPUnit\Framework\TestCase;
use QMVC\Base\Security\Sanitizers;

class SanitizersTest extends TestCase
{
    /**
    *@dataProvider dataProviderCleanInputStr
    */
    public function testCleanInputSTr($input, $excpectedOuput)
    {

    }

    public function dataProviderCleanInputStr()
    {
        return [
            [
                '\\test\<php? $url = "http://server.com/path";'.
                '$options = ["http" => ["header"  => "Content-type: application/"'.
                '"x-www-form-urlencoded\r\n","method"  => "POST",'.
                '"content" => http_build_query($_SESSION)' .
                '$context  = stream_context_create($options);'.
                '$result = file_get_contents($url, false, $context);'.
                '?>\\',
                "\\test\\"
            ]
        ];
    }
}

?>