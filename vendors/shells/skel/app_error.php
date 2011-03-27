<?php
class AppError extends ErrorHandler {
    
    function error401($params)    {
        $this->controller->layout = "error"; //if u want to change layout
        $this->controller->set($params); //set variables
        $this->_outputMessage("401"); //output error element
    }
    
    function error404($params)    {
        $this->controller->layout = "error"; //if u want to change layout
        $this->controller->set($params); //set variables
        $this->_outputMessage("404"); //output error element
    }
    
    function error405($params)    {
        $this->controller->layout = "error"; //if u want to change layout
        $this->controller->set($params); //set variables
        $this->_outputMessage("405"); //output error element
    }
    
    function error503($params)    {
        $this->controller->layout = "error"; //if u want to change layout
        $this->controller->set($params); //set variables
        $this->_outputMessage("503"); //output error element
    }
}