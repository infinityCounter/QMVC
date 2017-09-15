<?php

namespace QMVC\Base;

class TwigAutoloader
{
    public static function register()
    {
        ini_set('unserialize_callback_func', 'spl_autoload_call');
        spl_autoload_register(array(new self, 'autoload'));
    }
    
    public static function autoload($class)
    {
        if (0 !== strpos($class, 'Twig')) {
            return;
        }
        if (is_file($file = __DIR__ .'/../vendor/twig/twig/lib/'.str_replace(array('_', "\0"), array('/', ''), $class).'.php')) {
            require $file;
        }
    }
}