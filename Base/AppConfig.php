<?php

namespace QMVC\Base;

require_once('TwigAutoloader.php');
TwigAutoloader::register();

final class AppConfig
{
    private static $onlyHTTPS = false;
    private static $onlyHTTPSSubdomains = false;
    private static $STSTime = 0;
    private static $twigLoader = null;
    private static $twigEnvironment = null;
    private static $contentSecurityPolicy = "default-src 'self'; img-src *; media-src youtube+////////////////////////////.com media2.com; script-src userscripts.example.com";

    public static function useOnlyHTTPS(bool $https)
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

    public static function UseOnlyHTTPSSubdomains(bool $https)
    {
        self::$onlyHTTPSSubdomains = $https;
    }

    public static function isOnlyUsingHTTPSSubdomains()
    {
        return self::$onlyHTTPSSubdomains;
    }

    public static function setSTSTime(int $time)
    {
        if($time < 0)
            throw new InvalidArgumentException("Time cannot be less than 0");
        self::$STSTime = $time;
    }

    public static function getSTSTime()
    {
        return (self::$onlyHTTPS) ? self::$STSTime : 0;
    }

    public static function setTwigLoader($loader)
    {
        if(!is_a($loader, \Twig_Loader_Array::class) && 
           !is_a($loader, \Twig_Loader_Filesystem::class))
        {
            $type = gettype($loader);
            throw new InvalidArgumentException("Argument passed to AppConfig::setTwigLoader".
            " must either be a Twig_Loader_Array or Twig_Loader_Filesystem, {$loader} given.");
        }
        self::$twigLoader = $loader;
    }

    public static function getTwigLoader()
    {
        return self::$twigLoader;
    }

    public static function setTwigEnvironment(\Twig_Environment $environment)
    {
        self::$twigEnvironment = $environment;
        self::setTwigLoader($environment->getLoader());
    }

    public static function getTwigEnvironment()
    {
        return self::$twigEnvironment;
    }
}