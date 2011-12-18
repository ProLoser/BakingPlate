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
        'Paginator' ,
        'Session',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'pages', 'action' => 'display', 'home'),
            'logoutRedirect' => array('controller' => 'pages', 'action' => 'display', 'home'),
            'authorize' => array('Controller')
        )
    );
    
    #!#public $uses = array('Configuration.Configuration');
    
    public $view = 'BakingPlate.ThemedAutoHelperView';
    
    #!# public $viewClass = 'Theme';
    #!# public $theme = 'MyTheme';

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
        	$this->Auth->allow('index', 'view', 'display');
    }

    public function beforeRender() {
    		parent::beforeRender();
    }
    
    private function _setConfiguration($prefix = 'Site') {
		if(isset($this->Configuration)) {
			$this->Configuration->load($prefix);
		}
    }
    
    private function _setAuth() {
    }
    
    private function _setMaintenance() {
		if(Configure::read('WebmasterTools.Maintenance.active') === true) {
			$this->Maintenance->activate();
		}
    }
    
    public function isAuthorized($user) {
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true; //Admin can access every action
        }
        return false; // The rest don't
    }
}
