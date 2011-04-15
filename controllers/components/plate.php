<?php
/**
 * PlateComponent
 * 
 * A collection of common controller-level fixes and functionality in baking plate
 *
 * @package BakingPlate Plugin
 * @author Dean Sofer
 * @version $Id$
 * @copyright Art Engineered
 **/

class PlateComponent extends Object {

	/**
	 * Array containing the names of components this component uses. Component names
	 * should not contain the "Component" portion of the classname.
	 *
	 * @var array
	 * @access public
	 */
	var $components = array('RequestHandler');
	
	/**
	 * Stores instance of the related controller
	 *
	 * @var object
	 */
	var $controller;

	/**
	 * Called before the Controller::beforeFilter().
	 *
	 * @param object  A reference to the controller
	 * @return void
	 * @access public
	 * @link http://book.cakephp.org/view/65/MVC-Class-Access-Within-Components
	 */
	function initialize(&$controller, $settings = array()) {
		$this->controller = $controller;
		if (!isset($this->__settings[$controller->name])) {
			$this->__settings[$controller->name] = $settings;
		}
		$this->_checkSSL();
	}

	/**
	 * Called after the Controller::beforeFilter() and before the controller action
	 *
	 * @param object  A reference to the controller
	 * @return void
	 * @access public
	 * @link http://book.cakephp.org/view/65/MVC-Class-Access-Within-Components
	 */
	function startup(&$controller) {
	}

	/**
	 * Called after the Controller::beforeRender(), after the view class is loaded, and before the
	 * Controller::render()
	 *
	 * @param object  A reference to the controller
	 * @return void
	 * @access public
	 */
	function beforeRender(&$controller) {
		// An annoying fix for asset_compress
		if (empty($this->controller))
			$this->controller = $controller;
			
		$this->_habtmValidation();
		$this->_populateView();
	}

	/**
	 * Called after Controller::render() and before the output is printed to the browser.
	 *
	 * @param object  A reference to the controller
	 * @return void
	 * @access public
	 */
	function shutdown(&$controller) {
	}

	/**
	 * Called before Controller::redirect()
	 *
	 * @param object  A reference to the controller
	 * @param mixed  A string or array containing the redirect location
	 * @access public
	 */
	function beforeRedirect(&$controller, $url, $status = null, $exit = true) {
	}
	
	/**
	 * Redirect check for SSL
	 * Works in conjunction with var $secureActions in the controller
	 *
	 */
	function _checkSSL() {
		if (!isset($this->controller->secureActions)) {
			return;
		} elseif (
			!$this->RequestHandler->isSSL() && $this->controller->secureActions === true 
			|| !$this->RequestHandler->isSSL() && is_array($this->controller->secureActions) && in_array($this->controller->action, $this->controller->secureActions)
			|| !$this->RequestHandler->isSSL() && $this->controller->secureActions === $this->controller->action
		) {
			$this->controller->redirect('https://' . env('SERVER_NAME') . $this->controller->here);
		} elseif (
			$this->RequestHandler->isSSL() && !$this->controller->secureActions 
			|| $this->RequestHandler->isSSL() && is_array($this->controller->secureActions) && !in_array($this->controller->action, $this->controller->secureActions)
			|| $this->RequestHandler->isSSL() && $this->controller->secureActions !== $this->controller->action
		) {
			$this->controller->redirect('http://' . env('SERVER_NAME') . $this->controller->here);
		}
	}
	
	
	/**
	 * Generates validation error messages for HABTM fields
	 *
	 * @return void
	 * @author Dean
	 */
	public function _habtmValidation() {
		$model = $this->controller->modelClass;
		if (isset($this->controller->{$model}) && isset($this->controller->{$model}->hasAndBelongsToMany)) {
			foreach($this->controller->{$model}->hasAndBelongsToMany as $alias => $options) { 
				if(isset($this->controller->{$model}->validationErrors[$alias])) { 
					$this->controller->{$model}->{$alias}->validationErrors[$alias] = $this->controller->{$model}->validationErrors[$alias]; 
				} 
			}
		}
	}

	/**
	 * Populates commonly used view vars from controller attributes
	 *
	 * @return void
	 * @author Dean Sofer
	 */
	function _populateView() {
		$this->setToView('attributesForLayout');
		$this->setToView('descriptionForLayout');
		$this->setToView('keywordsForLayout');
		$this->setToView('menusForLayout');
		if ($this->controller->params['url']['url'] != '/') {
			$this->controller->attributesForLayout[] = array(
				'id' => false,
				'class' => $this->controller->params['controller'] . ' ' . $this->controller->action,
			);
		}
	}

	/**
	 * Add component just in time (inside actions - only when needed)
	 * aware of plugins and config array (if passed). Doesn't load 
	 * dependent components.
	 *
	 * @param mixed $helpers (single string or multiple array)
	 */
	function loadComponent($components = array()) {
		foreach ((array)$components as $component => $config) {
			if (is_int($component)) {
				$component = $config;
				$config = null;
			}
			list($plugin, $componentName) = pluginSplit($component);
			if (isset($this->controller->{$componentName})) {
				continue;
			}
			App::import('Component', $component);

			$componentFullName = $componentName.'Component';
			$component = new $componentFullName($config);

			if (method_exists($component, 'initialize')) {
				$component->initialize($this->controller);
			}
			if (method_exists($component, 'startup')) {
				$component->startup($this->controller);
			}
			$this->controller->{$componentName} = $component;
		}
	}

	/**
	 * Checks to see what the current prefix in use is or if a specific prefix is active
	 * default if none is given.
	 *
	 * @param string $prefix optional prefix to compare
	 * @return boolean
	 * @access protected
	 **/
	function prefix($prefix = null) {
		if (isset($this->controller->params['prefix'])) {
			if ($prefix) {
				return $this->controller->params['prefix'] == $prefix;
			} else {
				return $this->controller->params['prefix'];
			}
		} else {
			return false;
		}
	}
	

	/**
	 * Populates layout variables for use
	 *
	 * @return void
	 * @author Dean Sofer
	 */
	function setToView($varName = null) {
		if (!empty($varName) && property_exists($this->controller, $varName)) {
			$this->controller->set(Inflector::underscore($varName), $this->controller->{$varName});
		}
	}

	/**
	 * if cakeError is set and not maintenance layout set layout to error
	 * http://nuts-and-bolts-of-cakephp.com/2009/04/30/give-all-of-your-error-messages-a-different-layout/
	 *
	 */
	protected function _setErrorLayout() {
		if($this->controller->name == 'CakeError' && $this->controller->layout !== 'maintenance') {
			$this->controller->layout = 'error';
		}
	}
}
?>
