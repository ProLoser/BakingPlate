<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppController extends Controller {
	
	var $helpers = array('Session', 'Html', 'Form', 'Time');
	var $components = array('Session', 'Cookie', 'Scaffolding', 'RequestHandler', 'Webservice.Webservice',
		'Auth' => array(
			'fields' => array(
				'username' => 'username', 
				'password' => 'password',
			),
			'loginAction' => array('staff' => false, 'plugin' => null, 'controller' => 'users', 'action' => 'login'),
			'logoutRedirect' => array('action' => 'login'),
			'loginRedirect' => '/myaccount',	
			//'authorize' => 'actions', // TODO Install ACL component?	
		), 
		'Filter.Filter' => array(
			'actions' => array('index', 'staff_index'),
		),
	);
	var $view = 'Theme';

	function beforeFilter() {
		$this->_setupAuth();
		$this->_setLanguage();
		
		// Enables the filtering helper
		if ($this->action == 'staff_index') {
			$this->helpers[] = 'Filter.Filter';
		}
	}
	
	/**
	 * Changes the layout of the page if the prefix changes
	 *
	 * @return void
	 * @author Dean
	 */
	function beforeRender() {
		$this->__habtmValidation();
		if ($this->_prefix('staff')) {
			$this->theme = 'staff';
		} else {
			$this->theme = $this->Session->read('Config.locale');
		}
	}
	
	/**
	 * This allows the enabling of debug mode even if debug is set to off. 
	 * Simply pass ?shnizzle=1 in the url
	 *
	 * @author Dean
	 */
	public function __construct() {
		if (!empty($_GET['debug'])) {
			Configure::write('debug', 2);
		}
		if (Configure::read('debug')) {
			$this->components[] = 'DebugKit.Toolbar';
			App::import('Vendor', 'DebugKit.FireCake');
		}
		parent::__construct();
	}
	
	/**
	 * Configures the AuthComponent according to the application's settings.
	 * Override this method in individual controllers for further configuration.
	 *
	 * @return void
	 * @access private
	 */
	protected function _setupAuth() {	
		if ($this->_prefix('admin')) {
			// TODO Role levels shouldn't be hardcoded
			if ($this->Auth->user() && $this->Auth->user('role_id') < 1) {
				$this->Session->setFlash('You do not have permission to enter this section');
				$this->redirect($this->Auth->loginAction);
			}
		} else {
			$this->Auth->allow();
		}
	}
	
	/**
	 * Stores the visitors 2 letter language code to cookie AND session so that the url parameter is optional (and remembered)
	 *
	 * @return void
	 * @author Dean
	 */
	protected function _setLanguage() {
		$default = Configure::read('Config.language');
		if ($this->Cookie->read('locale') && !$this->Session->check('Config.locale')) {
			$this->Session->write('Config.locale', $this->Cookie->read('locale'));
		} elseif (isset($this->params['locale']) && ($this->params['locale'] !=  $this->Session->read('Config.locale'))) {
			$this->Session->write('Config.locale', $this->params['locale']);
			$this->Cookie->write('locale', $this->params['locale'], false, '20 days');
		} elseif (!$this->Session->check('Config.locale') && !Set::contains($this->params, array('controller' => 'locales', 'action' => 'welcome')) && !$this->_prefix('staff')) {
			$this->Session->write('Config.referer', $this->params['url']['url']);
			if ($locale = $this->__getIpCountry()) {
				$this->redirect(array('locale' => $locale));
			} else {
				$this->redirect(array('controller' => 'locales', 'action' => 'welcome'));
			}
		}
		
		Configure::write('Config.language', $this->Session->read('Config.locale'));
	}
	
	/**
	 * Checks to see what the current prefix in use is or if a specific prefix is active
	 * default if none is given.
	 *
	 * @param string $prefix optional prefix to compare
	 * @return boolean
	 * @access protected
	 **/
	function _prefix($prefix = null) {
		if (isset($this->params['prefix'])) {
			if ($prefix) {
				return $this->params['prefix'] == $prefix;
			} else {
				return $this->params['prefix'];
			}
		} else {
			return false;
		}
	}
	
	/**
	 * Generates validation error messages for HABTM fields
	 *
	 * @return void
	 * @author Dean
	 */
	private function __habtmValidation() {
		$model = $this->modelClass;
		if (isset($this->{$model}) && isset($this->{$model}->hasAndBelongsToMany)) {
			foreach($this->{$model}->hasAndBelongsToMany as $alias => $options) { 
				if(isset($this->{$model}->validationErrors[$alias])) 
				{ 
					$this->{$model}->{$alias}->validationErrors[$alias] = $this->{$model}->validationErrors[$alias]; 
				} 
			}
		}
	}
	
	private function __getIpCountry() {
		$this->loadComponent('Geoip.Geoip');
		$countryCode = $this->Geoip->countryCode($_SERVER['REMOTE_ADDR']);
		$countryCode = strtolower($countryCode);
		return $countryCode;
	}

	/**
	 * Added support for continuing localized urls
	 *
	 * @param string $url 
	 * @param string $status 
	 * @param string $exit 
	 * @return void
	 * @author Dean Sofer
	 * @access public
	 */
	public function redirect($url, $status = null, $exit = true) {
		if (is_array($url) && !isset($url['locale']) && isset($this->params['locale'])) {
			$url['locale'] = $this->params['locale'];
		}
		parent::redirect($url, $status, $exit);
	}
	
	/**
	 * Add component just in time (inside actions - only when needed)
	 * aware of plugins and config array (if passed)
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
	        if (isset($this->{$componentName})) {
	            continue;
	        }
	        App::import('Component', $component);
	
	        $componentFullName = $componentName.'Component';
	        $component = new $componentFullName($config);
	
	        if (method_exists($component, 'initialize')) {
	            $component->initialize($this);
	        }
	        if (method_exists($component, 'startup')) {
	            $component->startup($this);
	        }
	        $this->{$componentName} = $component;
	    }
	}

}