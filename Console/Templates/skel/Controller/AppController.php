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
        'BakingPlate.Html' => array('className' => 'Html'),
        'BakingPlate.FormPlus' => array('className' => 'Form'),
        'BakingPlate.PaginatorPlus' => array('className' => 'Paginator'),
        'Session',
        'AssetCompress.AssetCompress'
    );
    
    public $components = array(
        'DebugKit.Toolbar',
        'Session',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'pages', 'action' => 'display', 'home'),
            'logoutRedirect' => array('controller' => 'pages', 'action' => 'display', 'home'),
            'authorize' => array('Controller') // Added this line
        )
    );
    
    public function beforeFilter() {
        $this->Auth->allow('index', 'view', 'display');
    }
    
    public function isAuthorized($user) {
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true; //Admin can access every action
        }
        return false; // The rest don't
    }
}
