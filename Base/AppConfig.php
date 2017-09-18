<?php

namespace QMVC\Base;

require_once(__DIR__ . '/Security/Sanitizers.php');
require_once('TwigAutoloader.php');

use QMVC\Base\Security\Sanitizers;

TwigAutoloader::register();

final class AppConfig
{
    private static $onlyHTTPS = false;
    private static $onlyHTTPSSubdomains = false;
    private static $STSTime = 0;
    private static $contentSecurityPolicy = null;
    private static $twigLoader = null;
    private static $twigEnvironment = null;
    private static $uploadMIMEWhitelist = [];
    private static $uploadDirectory = null;
    private static $devMode = false;

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
            throw new \InvalidArgumentException("Time cannot be less than 0");
        self::$STSTime = $time;
    }

    public static function getSTSTime()
    {
        return (self::$onlyHTTPS) ? self::$STSTime : 0;
    }

    public static function setContentSecurityPolicy(string $policy)
    {
        $cleanedPolicy = Sanitizers::stripAllTags($policy);
        self::$contentSecurityPolicy = $cleanedPolicy;
    }

    public static function getContentSecurityPolicy()
    {
        return self::$contentSecurityPolicy;
    }

    public static function setTwigLoader($loader)
    {
        if(!is_a($loader, \Twig_Loader_Array::class) && 
           !is_a($loader, \Twig_Loader_Filesystem::class))
        {
            $type = gettype($loader);
            throw new \InvalidArgumentException("Argument passed to AppConfig::setTwigLoader".
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

    public static function whitelistUploadMIMEList(array $whitelist)
    {
        foreach($whitelist as $extension => $mimeType)
        {
            array_push(self::$uploadMIMEWhitelist, sanitizers::stripAllTags($mimeType));
        }
    }

    public static function getUploadMIMEWhitelist()
    {
       return self::$uploadMIMEWhitelist;
    }

    public static function setUploadDirectory(string $path)
    {
        $cleanedPath = filter_var(sanitizers::stripAllTags($path), FILTER_SANITIZE_STRING);
        $realPath = realpath($cleanedPath);
        if(($realPath !== false && is_dir($realPath)) || 
           (!$realPath && !mkdir($cleanedPath, 0644))
        )
        {
            throw new \InvalidArgumentException("{$realPath} is not a directory and cannot create directory.");
        }
        else 
        {
            $this->uploadDirectory = $realPath;
        }
    }

    public static function setDevMode(bool $mode)
    {
        self::$devMode = $mode;
    }

    public static function isDevMode()
    {
        return self::$devMode;
    }
}