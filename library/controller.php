<?php
/**
* Abstract class to define controllers.
* CANNOT BE INSTANTIATED, MUST BE EXTENDED
**/
abstract class Controller {

    abstract private $template;
    abstract private $subView;

    /**
    * Class constructor. Constructor accepts parameter to allow state overloading
    * Multiple different states can have the same controller. 
    **/
    _constructor($template, $subView){
        $this->$template = $template;
        $this->$subView = $subView;
    }

    function render(){

        String $templateFile;
        if($this->subView === true && $templateFile.strpos('<>')){

        }
    }
}

?>