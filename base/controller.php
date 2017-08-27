<?php

namespace QMVC\base;

/**
* abstract class Controller
*
* Abstract class to define controllers.
* CANNOT BE INSTANTIATED, MUST BE EXTENDED
*/
abstract class Controller 
{
    protected $template = null; //Will be inherited by child classes
    protected $model = null;

    /**
    * 
    * Class constructor. Inherited by children unless overloaded
    *
    * Accepts a model and a template and assigns them to protected class members
    */
    function __construct($model = null, $template)
    {
        $this->template = $template;
        $this->model= $model;
    }

    /**
    * public function render()
    *
    * @return void
    *
    * Loads the template of the state
    */
    public function render()
    {
        require_once(ROOT_PATH . $this->template);
    }
}

?>