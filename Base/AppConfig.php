<?php

namespace QMVC\Base;

final class AppConfig
{
    private static $onlyHTTPS = true;
    private static $onlyHTTPSSubdomains = true;
    private static $STSTime = 0;
    private static $twigLoader = null;
    private static $twigLocations = [];
    private static $twigEnvironment = null;

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
        return self::$STSTime;
    }

    public static function addTemplateDirs(array $templateDirs)
    {
        foreach ($templateDirs as $key => $dir) {
            self::addTemplateDir($dir);
        }
    }

    public static function addTemplateDir(string $templateDir)
    {
        if(!is_dir($templateDir))
            throw new InvalidArgumentException("Argument provided must be directory path. {$templateDir} is not a valid directory");
        $fullPath = realpath($templateDir);
        if(!in_array($fullPath, self::$twigLocations)) array_push(self::$twigLocations, $fullPath);
        if(self::$twigLoader == null) self::bootstrapTwig();
    }

    private static function bootstrapTwig()
    {
        
    }
}