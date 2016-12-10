<?php

/**
* Home class extends the Controller
* which is abstract and cannot be instantiated itself.
**/
class Home extends Controller{
    
    public $welcome = "John hope"; //Default welcome message to John hope

    /**
    * Constructor accepts $template and $subview
    * Calls super constructor of parent to operate on $template and $subView
    * Enables the output buffer so no output is sent from script
    * Allows clearing of webpage.
    **/
    function __construct($template, $subView){
        parent::__construct($template, $subView); //call parent constructor
        ob_start();
        $this->render(); //Call render method of THIS instance of object
    }

    /**
    * Chang the welcome value, but default new value
    * Ends output buffer, clears it and starts again, clears webpage.
    **/
    function changeWelcome($newText = "Penny paddle waggan"){
        
        $this->welcome = $newText;
        ob_end_clean(); //Close output buffer and clean the buffer
        ob_start();
        $this->render();
    }

    function render(){
        include($this->template); //import the template into the controller which will render it
    }
}

?>