<?php
class AppError extends ErrorHandler {
	
	function _outputMessage($template) {
		/*
		 * Use an error layout 
		 * @link http://nuts-and-bolts-of-cakephp.com/2009/04/30/give-all-of-your-error-messages-a-different-layout/
		 */
		$this->controller->layout = 'error';
		return parent::_outputMessage($template);
	}
	
/*
 * set maintenance with layout - set different layout within view if desired
 *#!#/
	function maintenance($params)    {
	    $this->controller->set($params); //set variables
	    $this->_outputMessage("Maintenance"); //output error element
	}/*^*/
	
}
