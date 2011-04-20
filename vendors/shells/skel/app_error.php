<?php
class AppError extends ErrorHandler {
	
	function _outputMessage($template) {
		/*
		 * Use an error layout 
		 * @link http://nuts-and-bolts-of-cakephp.com/2009/04/30/give-all-of-your-error-messages-a-different-layout/
		 *#!#/
		if ($this->controller->layout != 'maintenance') {
			$this->controller->layout = 'error';
		}/*^*/
		return parent::_outputMessage($template);
	}
	
	// TODO: add main method as the above is not enough
	
}
