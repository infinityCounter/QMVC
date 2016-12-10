<?php

class Home extends Controller{
    
    public $welcome = "John hope";

    function __construct($template, $subView){
        ob_start();
        parent::__construct($template, $subView);
        $this->render();
    }

    function changeWelcome($newText = "Penny paddle waggan"){
        
        $this->welcome = $newText;
        ob_end_clean();
        ob_start();
        $this->render();
    }

    function render(){
        include($this->template);
    }
}

?>