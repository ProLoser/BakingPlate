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
class PlateComponent extends Component {

/**
 * Array containing the names of components this component uses. Component names
 * should not contain the "Component" portion of the classname.
 *
 * @var array
 * @access public
 */
	public $components = array('RequestHandler');

/**
 * Stores instance of the related controller
 *
 * @var object
 */
	protected $_Controller;

	protected $_Settings = array();

/**
 * Called before the Controller::beforeFilter().
 *
 * @param object  A reference to the controller
 * @return void
 * @access public
 * @link http://book.cakephp.org/view/65/MVC-Class-Access-Within-Components
 */
	public function initialize($controller, $settings = array()) {
		$this->_Controller = $controller;
		if (!isset($this->_Settings[$controller->name])) {
			$this->_Settings[$controller->name] = $settings;
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
	public function startup($controller) {
		$this->_paginationLimit();
	}

/**
 * Called after the Controller::beforeRender(), after the view class is loaded, and before the
 * Controller::render()
 *
 * @param object  A reference to the controller
 * @return void
 * @access public
 */
	public function beforeRender($controller) {
		// An annoying fix for asset_compress
		if (empty($this->_Controller)) {
			$this->_Controller = $controller;
		}

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
	public function shutdown($controller) {
	}

/**
 * Called before Controller::redirect()
 *
 * @param object  A reference to the controller
 * @param mixed  A string or array containing the redirect location
 * @access public
 */
	public function beforeRedirect($controller, $url, $status = null, $exit = true) {
	}

/**
 * Redirect check for SSL
 * Works in conjunction with public $secureActions in the controller
 *
 */
	protected function _checkSSL() {
		if (!isset($this->_Controller->secureActions)) {
			return;
		} elseif (
			!$this->_Controller->request->is('ssl') && $this->_Controller->secureActions === true
			 || !$this->_Controller->request->is('ssl') && is_array($this->_Controller->secureActions) && in_array($this->_Controller->action, $this->_Controller->secureActions)
			 || !$this->_Controller->request->is('ssl') && $this->_Controller->secureActions === $this->_Controller->action
		) {
			$this->_Controller->redirect('https://' . env('SERVER_NAME') . $this->_Controller->here);
		} elseif (
			$this->_Controller->request->is('ssl') && !$this->_Controller->secureActions
			 || $this->_Controller->request->is('ssl') && is_array($this->_Controller->secureActions) && !in_array($this->_Controller->action, $this->_Controller->secureActions)
			 || $this->_Controller->request->is('ssl') && $this->_Controller->secureActions !== $this->_Controller->action
		) {
			$this->_Controller->redirect('http://' . env('SERVER_NAME') . $this->_Controller->here);
		}
	}

/**
 * Generates validation error messages for HABTM fields
 *
 * @return void
 * @author Dean
 */
	protected function _habtmValidation() {
		$model = $this->_Controller->modelClass;
		if (isset($this->_Controller->{$model}) && isset($this->_Controller->{$model}->hasAndBelongsToMany)) {

			foreach ($this->_Controller->{$model}->hasAndBelongsToMany as $alias => $options) {
				if (isset($this->_Controller->{$model}->validationErrors[$alias])) {
					$this->_Controller->{$model}->{$alias}->validationErrors[$alias] = $this->_Controller->{$model}->validationErrors[$alias];
				}
			}
		}
	}

/**
 * Checks to see if there is a limit set for pagination results
 * to prevent overloading the database
 *
 * @param string $value 
 * @return void
 * @author Jose Gonzalez (savant)
 */
	protected function _paginationLimit() {
		if (isset($this->passedArgs['limit']) && isset($this->_Controller->paginationMaxLimit) && is_numeric($this->_Controller->paginationMaxLimit)) {
			$this->passedArgs['limit'] = min(
					$this->paginationMaxLimit,
					$this->passedArgs['limit']
			);
		}
	}

/**
 * Populates commonly used view vars from controller attributes
 *
 * @return void
 * @author Dean Sofer
 */
	protected function _populateView() {
		if (!isset($this->_Controller->forLayout)) {
			return;
		}

		foreach ($this->_Controller->forLayout as $name => $value) {
			$this->_Controller->set($name . '_for_layout', $value);
		}
	}

/**
 * Add component just in time (inside actions - only when needed)
 * aware of plugins and config array (if passed). Doesn't load 
 * dependent components.
 *
 * @param mixed $components (single string or multiple array)
 */
	public function loadComponent($components = array()) {
		foreach ((array)$components as $component => $config) {
			if (is_int($component)) {
				$component = $config;
				$config = null;
			}
			list($plugin, $componentName) = pluginSplit($component);
			if (isset($this->_Controller->{$componentName})) {
				continue;
			}
			App::uses($component, 'Component');

			$componentFullName = $componentName . 'Component';
			$component = new $componentFullName($config);

			if (method_exists($component, 'initialize')) {
				$component->initialize($this->_Controller);
			}
			if (method_exists($component, 'startup')) {
				$component->startup($this->_Controller);
			}
			$this->_Controller->{$componentName} = $component;
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
	public function prefix($prefix = null) {
		if (isset($this->_Controller->params['prefix'])) {
			if ($prefix) {
				return ($this->_Controller->params['prefix'] == $prefix);
			} else {
				return $this->_Controller->params['prefix'];
			}
		} else {
			return false;
		}
	}

/**
 * Convenience method to perform both a flash and a redirect in one call
 *
 * Works with Controller::redirect = array('action' => 'index') or whatever you choose as the default
 *
 * @param string $message Message to display on redirect
 * @param mixed $url A string or array-based URL pointing to another location within the app,
 *     or an absolute URL
 * @return void
 * @access protected
 */
	public function flash($message = null, $redirect = array(), $options = array()) {
		$options = array_merge(array(
			'status'	=> null,
			'exit'		=> true,
			'element'	=> 'default',
			'key'		=> 'flash',
		), $options);

		if ($message === null) {
				$message = __('Access Error');
		} elseif ($message !== false) {
				// TODO: add session component to plate helper?
				$this->_Controller->Session->setFlash($message, $options['element']);
		}
		if (is_array($redirect)) {
			if (!isset($this->_Controller->redirect)) {
				$this->_Controller->redirect = array('action' => 'index');
			}
			$redirect = array_merge($this->_Controller->redirect, $redirect);
		}

		$this->_Controller->redirect($redirect, $options['status'], $options['exit'], $options['key']);
	}

/**
 * Redirect to some url if a given piece of information evaluates to false
 *
 * @param mixed $data Data to evaluate
 * @param mixed $message Message to use when redirecting
 * @return void
 * @access protected
 */
	public function redirectUnless($data = null, $message = null) {
		if (empty($data)) {
			$redirect = (isset($message['redirect'])) ? $message['redirect'] : array();
			$this->flash($message, $redirect);
		}
	}

}