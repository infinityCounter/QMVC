<?php

/**
* Abstract class to define controllers.
* CANNOT BE INSTANTIATED, MUST BE EXTENDED
**/
abstract class Controller {

    protected $template = NULL; //Will be inherited by child classes
    protected $model = NULL;

    /**
    * Class constructor. Constructor accepts parameter to allow state overloading
    * Multiple different states can have the same controller. 
    **/
    function __construct($model = NULL, $template){
        $this->template = $template;
        $this->model= $model;
    }

    function render(){
        require_once(ROOT_PATH . $this->template);
    }
}

?>