<?php
class AppError extends ErrorHandler {
	
	function _outputMessage($template, $layout = 'error') {
		/*
		 * Use an error layout 
		 * @link http://nuts-and-bolts-of-cakephp.com/2009/04/30/give-all-of-your-error-messages-a-different-layout/
		 */
		$this->controller->layout = $layout;
		return parent::_outputMessage($template);
	}
	
/*
 * Application currently undergoing maintanence
 *#!#/
	function maintenance($params)    {
	    $this->controller->set($params); //set variables
	    $this->_outputMessage('Maintanence'); //output error element
	}
/*^*/
	
}
