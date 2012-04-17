<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 */
class AppController extends Controller {

	public $helpers = array(
			'BakingPlate.Plate',
			'Html' => array('className' => 'BakingPlate.HtmlPlus'),
			'Form' => array('className' => 'BakingPlate.FormPlus'),
			'Paginator' => array('className' => 'BakingPlate.PaginatorPlus'),
			'Session',
			#!# 'AssetCompress.AssetCompress'
	);

	public $components = array(
		'BakingPlate.Plate',
		'Paginator',
		'Session',
		/* AUTH CONFIG *v/
		 'Auth' => array(
			'loginRedirect' => array('controller' => 'pages', 'action' => 'display', 'home'),
			'logoutRedirect' => array('controller' => 'pages', 'action' => 'display', 'home'),
			'authorize' => array('Controller')
		) /*^*/
	);

	#!# public $uses = array('Configuration.Configuration');

/**
 * Specifies if an action should be under SSL
 *
 * @var mixed set to true for all controller actions, set to an array of action names for specific ones
 */
	 public $secureActions = false;

/**
 * $_GET keyword to force debug mode. Set to false or delete to disable.
 */
	 public $debugOverride = 'debug';

/**
 * Used to set a max for the pagination limit
 *
 * @var int
 */
	public $paginationMaxLimit = 25;

	public function __construct($request = null, $response = null) {
		if (!empty($this->debugOverride) && !empty($request->query[$this->debugOverride])) {
			Configure::write('debug', 2);
		}
		if (Configure::read('debug')) {
			$this->components[] = 'DebugKit.Toolbar';
			// @todo firebug firephp appuses
		}
		parent::__construct($request, $response);
	}

	public function beforeFilter() {
		#!# $this->_setConfiguration();
		#!# $this->_setAuth();
		#!# $this->_setMaintenance();
	}

	public function beforeRender() {
		#!# $this->_setTheme();
	}

	protected function _setConfiguration($prefix = 'Site') {
		if (isset($this->Configuration)) {
			$this->Configuration->load($prefix);
		}
	}

/**
 * Configure your Auth environment here
 */
	protected function _setAuth() {
		$this->Auth->authError = __('Sorry, but you need to login to access this location.');
		$this->Auth->loginError = __('Invalid e-mail / password combination.  Please try again');
		if (!$this->Plate->prefix('admin')) {
			$this->Auth->allow();
		}
	}

/**
 * Configure the current theme here
 */
	protected function _setTheme() {
		if ($this->viewClass !== 'Webservice.Webservice') {
			if ($this->Plate->prefix('admin')) {
				$this->viewClass = 'Theme';
				$this->theme = 'admin';
			} elseif (Configure::read('Config.language')) {
				$this->viewClass = 'Theme';
				$this->theme = Configure::read('Config.language');
			}
		}
	}

	protected function _setMaintenance() {
		if (Configure::read('WebmasterTools.Maintenance.active') === true) {
			$this->Maintenance->activate();
		}
	}
}