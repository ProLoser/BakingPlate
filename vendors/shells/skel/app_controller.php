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
	
	var $helpers = array(
			'Session',
			'PlatePlus.Plate',
			'Analogue.Analogue' => array(
			   array(
			    'helper' => 'PlatePlus.HtmlPlus',
			    'rename' => 'Html'
			   ),
			   array(
			    'helper' => 'PlatePlus.FormPlus',
			    'rename' => 'Form'
			   )
		    ),
			'Time',
			'AssetCompress.AssetCompress',
			//'Navigation.Navigation'
	);
	var $components = array(
			'Session',
			'Cookie',
			//'Scaffolding',
			'RequestHandler',
			//'Wapl.Wapl', tobe checked out
			'Webservice.Webservice',
			'WebmasterTools.Maintenance',
			'Auth' => array(
			    'loginAction' => array(
				    'controller' => 'users',
				    'action' => 'login',
				    'plugin' => 'users',
				    'admin' => false
			    ),
			    'logoutAction' => array(
				    'controller' => 'users',
				    'action' => 'login',
				    'plugin' => 'users',
				    'admin' => false
			    ),
			),
			//'Referee.Whistle' => array(
			//    'listeners' => array(
			//	'DbLog',
			//	'SysLog'
			//    )
			//)
	);
	var $view = 'Theme';

	function beforeFilter() {
		$this->_setupAuth();
		$this->_setLanguage();
		//$this->_setStaticCache();
	}
	
	/**
	 * Changes the layout of the page if the prefix changes
	 *
	 * @return void
	 * @author Dean
	 */
	function beforeRender() {
		$this->__habtmValidation();
		$this->_setTheme();
	}
/**
 * function _setStaticCache
*/
    function _setStaticCache() {
	    //if(is should be cached?) {
	    	$this->helpers[] = 'StaticCache.StaticCache'; 
	    //}
	}
	
	/**
	 * This allows the enabling of debug mode even if debug is set to off. 
	 * Simply pass ?debug=1 in the url
	 *
	 * @author Dean
	 */
	public function __construct() {
		if (!empty($_GET['debug'])) {
			Configure::write('debug', 2);
		}
		if (Configure::read('debug')) {
			// todo: add interactive for debugkit or not
			$this->components[] = 'DebugKit.Toolbar';
			App::import('Vendor', 'DebugKit.FireCake');
		}
		parent::__construct();
	}
	
	/**
	 * Set site theme
	 *
	 * todo: Set Site.Themes.Default to specifiy main theme
	 *
	 * @param string $theme
	 * @return void
	 * @author Sam
	 */
	function _setTheme($theme = null) {
		if ($this->_prefix('admin')) {
			$this->theme = 'admin';
		} else {
			// what about locale
			$themes = Configure::read('Site.Themes');
			//$this->theme = $this->Session->read('Config.locale');
			if($themes) {
				$this->theme = array_key_exists($theme, $themes) ? $theme : $themes['Default'];
			}
		}
	}
	
	/**
	 * Configures the AuthComponent according to the application's settings.
	 * Override this method in individual controllers for further configuration.
	 *
	 * @return void
	 * @access private
	 */
	protected function _setupAuth() {
		$this->Auth->fields = array('username' => 'email', 'password' => 'passwd');
		$this->Auth->loginError = "This message shows up when the wrong credentials are used";
		$this->Auth->authError = "This error shows up with the user tries to access a part of the website that is protected.";
		$this->Auth->allow('index','view', 'display');
		
		if ($this->_prefix('admin')) {
			// TODO Role levels shouldn't be hardcoded
			if ($this->Auth->user() && !$this->Auth->user('is_admin')) {
				$this->Session->setFlash('You do not have permission to enter this section');
				$this->redirect($this->Auth->loginAction);
			}
		}
		Configure::write('Site.User', $this->Auth->user());
	}
	
	/**
	 * Stores the visitors 2 letter language code to cookie AND session so that the url parameter is optional (and remembered)
	 *
	 * @return void
	 * @author Dean
	 */
	protected function _setLanguage() {
		if (isset($this->params['lang']) && $this->params['lang'] == Configure::read('Languages.default'))
			$this->redirect(array('lang' => false));
		$lang = isset($this->params['lang']) ? $this->params['lang'] : Configure::read('Languages.default');
		Configure::write('Config.language', $lang);
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
	
	/**
	 * Returns a 2 letter locale code for the current ip address
	 *
	 * @return string $countryCode
	 */
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