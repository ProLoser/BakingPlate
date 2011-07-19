<?php

App::import('Controller', array('Component', 'Controller'), false);
App::import('Component', array('Auth', 'BakingPlate.Plate', 'RequestHandler'));
Mock::generatePartial('RequestHandlerComponent', 'NoStopRequestHandler', array('_stop', '_header'));


class PlateComponentTestController extends Controller {

	var $controllerName = 'PlateCompTest';
/**
 * components property
 *
 * @var array
 * @access public
 */
	var $components = array('BakingPlate.Plate');
	var $attributesForLayout = array(
		'id' => 'home',
		'class' => 'home',
		'isGreat' => false
	);
	var $descriptionForLayout = '';
	var $keywordsForLayout = '';
	var $navsForLayout = false;
	
/**
 * Specifies if an action should be under SSL
 *
 * @var mixed set to true for all controller actions, set to an array of action names for specific ones
 */
	var $secureActions = false;
	
/**
 * $_GET keyword to force debug mode. Set to false or delete to disable.
 */
	var $debugOverride = 'debug';
	
/**
 * Used to set a max for the pagination limit
 *
 * @var int
 */
    var $paginationMaxLimit = 25;

/**
 * beforeFilter method
 *
 * @access public
 * @return void
 */
	function beforeFilter() {
	  $this->attributesForLayout['id'] = $this->controllerName;
	  $this->attributesForLayout['class'] = $this->action;
	}
	
	function index() {
	  
	}
	
	function admin_index() {
	  
	}
	
	function beforeRender() {
	  
		$this->_setTheme();
	}
	
/**
 * Configure your Auth environment here
 */
	protected function _setAuth() {
		if (isset($this->Acl))
			$this->Acl->allow($aroAlias, $acoAlias);	
		$this->Auth->authError = __('Sorry, but you need to login to access this location.', true);
		$this->Auth->loginError = __('Invalid e-mail / password combination.  Please try again', true);
		$this->Auth->allow('index', 'view', 'display');
		
		$user = $this->Auth->user();
		
		if ($this->Plate->prefix('admin')) {
			if ($user['User']['username'] == 'admin') {
				$this->Auth->allow('*');
			} else {
				$this->Session->setFlash(__('Sorry, but you need to be Admin to access this location.', true));
				$this->redirect($this->Auth->loginAction);
			}
		}
		Configure::write('Site.User', $user);
	}
	
/**
 * Place your language switching logic here (if you use it)
 */
	protected function _setLanguage() {
		if (isset($this->params['lang']) && $this->params['lang'] == Configure::read('Languages.default'))
			$this->redirect(array('lang' => false));
		$lang = isset($this->params['lang']) ? $this->params['lang'] : Configure::read('Languages.default');
		Configure::write('Config.language', $lang);
	}

/**
 * set site into Maintenance mode but not for loggeed user - allow users to login
 */
	protected function _setMaintenance() {
		$user = Configure::read('Site.User') ? Configure::read('Site.User') : false;
		$mainMode = Configure::read('WebmasterTools.Maintenance');
		if(!isset($user['User']) && $this->action !== 'login') {
			if($mainMode['active']) {
				$this->Plate->loadComponent(array('WebmasterTools.Maintenance'));
				$this->Maintenance->activate($mainMode['message']);
			}
		}
	}

/**
 * Place your theme-switching logic in here
 */
	protected function _setTheme() {
		// check if plate isset small fix for asset compress
		if (isset($this->Plate) && $this->Plate->prefix('admin')) {
			$this->theme = 'admin';
		} elseif (Configure::read('Config.language')) {
			$this->theme = Configure::read('Config.language');
		}
	}
}

class TestComponent extends Object {
	var $__settings = array();
	var $controller = null;
	public function initialize(&$controller, $settings = array()) {
		$this->controller = $controller;
		if (!isset($this->__settings[$controller->name])) {
			$this->__settings[$controller->name] = $settings;
		}
	}
	
	function aMethod($a, $b) {
	  return $a * $b;
	}
}

class PlateComponentTest extends CakeTestCase {

/**
 * Controller property
 *
 * @var CookieComponentTestController
 * @access public
 */
	var $Controller;
	var $RequestHandler;
	var $Plate;
	var $Auth;

/**
 * start
 *
 * @access public
 * @return void
 */
	function start() {
		$this->_init();
		//$this->Controller->Plate->destroy();
	}
	
	function initialize() {
	  
	}

/**
 * end
 *
 * @access public
 * @return void
 */
	function end() {
		//$this->Controller->Plate->destroy();
	}

/**
 * init method
 *
 * @access protected
 * @return void
 */
	function _init() {
		$this->Controller = new PlateComponentTestController(array('components' => array('Auth', 'Plate', 'Plate')));
		$this->Controller->constructClasses();
		//$this->RequestHandler =& $this->Controller->RequestHandler;
		//$this->RequestHandler->initialize($this->Controller);
		$this->Controller->Plate->initialize($this->Controller);
		$this->Controller->beforeFilter();
		$this->Controller->Plate->startup($this->Controller);
	}

/**
 * test that initialize sets settings from components array
 *
 * @return void
 */
	function testInitialize() {
		$settings = array(
		);
		$this->Controller->Plate->initialize($this->Controller, $settings);
	}
	
	function beforeRender(&$controller) {
		$this->Plate->beforeRender($controller);
	}
	
	function shutdown(&$controller) {
	}
	
	function testLoadComponent() {
		$this->Controller->params['prefix'] = null;
		$this->Controller->action = 'index';
		$this->Controller->params['controller'] = 'widgets';
		$this->Controller->params = array('url' => array('url' => '/widgets/index'));
		$this->_init();
		$expected = 20;
		$this->Controller->Plate->loadComponent('Test');
		$result = $this->Controller->Test->aMethod(5, 4);
		$this->assertEqual($result, $expected);
	}
	
	function testPrefix() {
		$this->Controller->params['prefix'] = 'admin';
		$this->Controller->params['controller'] = 'widgets';
		$this->Controller->action = 'index';
		$this->Controller->params = array('url' => array('url' => '/admin/widgets/index'));
		$this->_init();
		$expected = 'admin';
		$result = $this->Controller->Plate->prefix('admin');
		$this->assertEqual($result, $expected);
		
		$this->Controller->params['prefix'] = null;
		$this->Controller->params['controller'] = 'widgets';
		$this->Controller->action = 'index';
		$this->Controller->params = array('url' => array('url' => '/admin/widgets/index'));
		$this->_init();
		$result = $this->Controller->Plate->prefix('admin');
		$this->assertfalse($result);
		
		$this->Controller->params['prefix'] = 'members';
		$this->Controller->params['controller'] = 'profiles';
		$this->Controller->action = 'index';
		$this->Controller->params = array('url' => array('url' => '/members/profiles/index'));
		$this->_init();
		$result = $this->Controller->Plate->prefix('members');
		$this->assertEqual($result, 'members');
	}
	
	function testSetTheme() {
		$this->Controller->params['prefix'] = 'admin';
		$this->Controller->params['controller'] = 'widgets';
		$this->controller->params = array('url' => array('url' => '/admin/widgets/index'));
		$this->Controller->action = 'index';
		$this->_init();
		$this->Controller->layout = false;
		$this->Controller->render(false);
		$expected = 'admin';
		$result = $this->Controller->theme;
		$this->assertEqual($result, $expected);
		
		$this->Controller->params['prefix'] = null;
		$this->Controller->params['controller'] = 'widgets';
		$this->Controller->params = array('url' => array('url' => '/widgets/index'));
		$this->Controller->action = 'index';
		$this->_init();
		$this->Controller->index();
		$this->Controller->layout = false;
		$this->Controller->render(false);
		$expected = 'en-gb';
		$result = $this->Controller->theme;
		$this->assertEqual($result, $expected);
	}
}