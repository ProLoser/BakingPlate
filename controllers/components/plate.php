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
	var $components = array();
	
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
		if (!isset($this->__settings[$controller->name])) {
			$settings = $this->__settings[$controller->name];
		}
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
		$this->controller = $controller;
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
				'class' => $this->params['controller'] . ' ' . $this->action,
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
}
?>