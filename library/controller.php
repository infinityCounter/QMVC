<?php
/**
* Abstract class to define controllers.
* CANNOT BE INSTANTIATED, MUST BE EXTENDED
**/
abstract class Controller {

    protected $template; //Will be inherited by child classes
    protected $subView;

    /**
    * Class constructor. Constructor accepts parameter to allow state overloading
    * Multiple different states can have the same controller. 
    **/
    function __construct($template, $subView){
        $this->template = $template;
        $this->subView = $subView;
    }

    abstract function render();
}

?>