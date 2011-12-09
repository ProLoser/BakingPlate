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
        'AssetCompress.AssetCompress'
    );
    
    public $components = array(
        'DebugKit.Toolbar',
        'Session',
        'Auth',
		'BakingPlate.Plate',
    );

/**
 * Used to set a max for the pagination limit
 *
 * @var int
 */
    var $paginationMaxLimit = 25;

/**
 * $_GET keyword to force debug mode. Set to false or delete to disable.
 *
 * @var string
 */
	var $debugOverride = 'debug';

/**
 * This allows the enabling of debug mode even if debug is set to off. 
 * Simply pass ?debug=1 in the url
 */
	public function __construct($request = null, $response = null) {
		if (!empty($this->debugOverride) && !empty($_GET[$this->debugOverride])) {
			Configure::write('debug', 2);
		}
		if (Configure::read('debug')) {
			// TODO: add interactive for debugkit or not
			$this->components[] = 'DebugKit.Toolbar';
			App::uses('FireCake', 'DebugKit.Lib');
		}
		parent::__construct($request, $response);
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
}
