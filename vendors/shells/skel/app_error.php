<?php
class AppError extends ErrorHandler {
	
	function _outputMessage($template) {
		$this->controller->layout = "error";
		return parent::_outputMessage($template);
	}
/*
 * set maintenance with layout
 *#!#/
	function maintenance($params)    {
	    #!#$this->controller->layout = "maintenance"; //if u want to change layout
	    $this->controller->set($params); //set variables
	    $this->_outputMessage("Maintenance"); //output error element
	}/*^*/
	
}
