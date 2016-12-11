<?php
/**
* URL class, contains mutable operations for URL
* abstracts URL manipulation functions from Router
**/

class URL{


    private static $requestedState = null;
    private static $actionMethod = null;
    private static $args = null;
    private static $urlArray = null;


    public static function getActionMethod(){
        return self::$actionMethod;
    }

    public static function getArgs(){
        return self::$args;
    }

    public static function getNumArgs(){
        return count(self::getArgs());
    }

    public static function getRequestedState(){
        return self::$requestedState;
    }

    public static function getURLArray(){
        return self::$urlArray;
    }

    public static function spliceURL($url){

        self::$urlArray = explode('/', $url);
        $urlArray = self::getURLArray();
        $numUrlArgs = count($urlArray);
        self::$requestedState = isset($urlArray[0])? $urlArray[0] : null;
        self::$actionMethod = isset($urlArray[1])? $urlArray[1] : null;
        if (count($urlArray) > 2)
            unset($urlArray[0], $urlArray[1]);
        else if (count($urlArray) === 1)
            unset($urlArray[0]);
        
        $args = isset($urlArray)? array_values($urlArray) : null;
    }
}
?>