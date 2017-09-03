<?php

namespace QMVC\Base;

final class AppConfig
{
    private static $onlyHTTPS = true;
    private static $onlyHTTPSSubdomains = true;
    private static $STSTime = 31536000; // 1 Year

    public static function useOnlyHTTPS(boolean $https)
    {
        self::$onlyHTTPS = $https;
        if(!$https)
        {
            self::$useOnlyHTTPSSubdomains($https);
            self::$setSTSTime(0);
        }
    }

    public static function isOnlyUsingHTTPS()
    {
        return self::$onlyHTTPS;
    }

    public static function UseOnlyHTTPSSubdomains(boolean $https)
    {
        self::$onlyHTTPSSubdomains = $https;
    }

    public static function isOnlyUsingHTTPSSubdomains()
    {
        return self::$onlyHTTPSSubdomains;
    }

    public static function setSTSTime(integer $time)
    {
        self::$STSTime = $time;
    }

    public static function getSTSTime()
    {
        return self::$STSTime;
    }
}