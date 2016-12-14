<?php

/**
* Abstract class to define controllers.
* CANNOT BE INSTANTIATED, MUST BE EXTENDED
**/
abstract class Controller 
{
    protected $template = null; //Will be inherited by child classes
    protected $model = null;

    /**
    * Class constructor. Constructor accepts parameter to allow state overloading
    * Multiple different states can have the same controller. 
    **/
    function __construct($model = null, $template)
    {
        $this->template = $template;
        $this->model= $model;
    }

    function render()
    {
        require_once(ROOT_PATH . $this->template);
    }
}

?>