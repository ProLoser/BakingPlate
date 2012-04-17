<?php

App::import('Controller', array('Component', 'Controller'), false);
App::import('Component', array('Auth', 'BakingPlate.Plate', 'RequestHandler'));
Mock::generatePartial('RequestHandlerComponent', 'NoStopRequestHandler', array('_stop', '_header'));


class PlateComponentTestController extends Controller {

	public $controllerName = 'PlateCompTest';

/**
 * components property
 *
 * @var array
 * @access public
 */
	public $components = array('BakingPlate.Plate');

	public $attributesForLayout = array(
		'id' => 'home',
		'class' => 'home',
		'isGreat' => false
	);

	public $descriptionForLayout = '';

	public $keywordsForLayout = '';

	public $navsForLayout = false;

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

/**
 * beforeFilter method
 *
 * @access public
 * @return void
 */
	public function beforeFilter() {
		$this->attributesForLayout['id'] = $this->controllerName;
		$this->attributesForLayout['class'] = $this->action;
	}

	public function index() {
	}

	public function admin_index() {
	}

	public function beforeRender() {
		$this->_setTheme();
	}

/**
 * Configure your Auth environment here
 */
	protected function _setAuth() {
		if (isset($this->Acl)) {
			$this->Acl->allow($aroAlias, $acoAlias);
		}
		$this->Auth->authError = __('Sorry, but you need to login to access this location.');
		$this->Auth->loginError = __('Invalid e-mail / password combination.  Please try again');
		$this->Auth->allow('index', 'view', 'display');

		$user = $this->Auth->user();

		if ($this->Plate->prefix('admin')) {
			if ($user['User']['username'] == 'admin') {
				$this->Auth->allow('*');
			} else {
				$this->Session->setFlash(__('Sorry, but you need to be Admin to access this location.'));
				$this->redirect($this->Auth->loginAction);
			}
		}
		Configure::write('Site.User', $user);
	}

/**
 * Place your language switching logic here (if you use it)
 */
	protected function _setLanguage() {
		if (isset($this->params['lang']) && $this->params['lang'] == Configure::read('Languages.default')) {
			$this->redirect(array('lang' => false));
		}
		$lang = isset($this->params['lang']) ? $this->params['lang'] : Configure::read('Languages.default');
		Configure::write('Config.language', $lang);
	}

/**
 * set site into Maintenance mode but not for loggeed user - allow users to login
 */
	protected function _setMaintenance() {
		$user = Configure::read('Site.User') ? Configure::read('Site.User') : false;
		$mainMode = Configure::read('WebmasterTools.Maintenance');
		if (!isset($user['User']) && $this->action !== 'login') {
			if ($mainMode['active']) {
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

/**
 * Test Component
 */
class TestComponent extends Component {

	protected $_Settings = array();

	protected $_Controller = null;

	public function initialize($controller, $settings = array()) {
		$this->_Controller = $controller;
		if (!isset($this->__settings[$controller->name])) {
			$this->_Settings[$controller->name] = $settings;
		}
	}

	public function aMethod($a, $b) {
		return $a * $b;
	}
}

/**
 * PlateComponentTest
 */
class PlateComponentTest extends CakeTestCase {

/**
 * Controller property
 *
 * @var CookieComponentTestController
 * @access public
 */
	protected $_Controller;

	public $RequestHandler;

	public $Plate;

	public $Auth;

/**
 * start
 *
 * @access public
 * @return void
 */
	public function start() {
		$this->_init();
		//$this->Controller->Plate->destroy();
	}

	public function initialize() {
	}

/**
 * end
 *
 * @access public
 * @return void
 */
	public function end() {
		//$this->Controller->Plate->destroy();
	}

/**
 * init method
 *
 * @access protected
 * @return void
 */
	protected function _init() {
		$this->_Controller = new PlateComponentTestController(array('components' => array('Auth', 'Plate', 'Plate')));
		$this->_Controller->constructClasses();
		//$this->RequestHandler = $this->_Controller->RequestHandler;
		//$this->RequestHandler->initialize($this->_Controller);
		$this->_Controller->Plate->initialize($this->_Controller);
		$this->_Controller->beforeFilter();
		$this->_Controller->Plate->startup($this->_Controller);
	}

/**
 * test that initialize sets settings from components array
 *
 * @return void
 */
	public function testInitialize() {
		$settings = array();
		$this->_Controller->Plate->initialize($this->Controller, $settings);
	}

	public function beforeRender($controller) {
		$this->Plate->beforeRender($controller);
	}

	public function shutdown($controller) {
	}

	public function testLoadComponent() {
		$this->_Controller->params['prefix'] = null;
		$this->_Controller->action = 'index';
		$this->_Controller->params['controller'] = 'widgets';
		$this->_Controller->params = array('url' => array('url' => '/widgets/index'));
		$this->_init();
		$expected = 20;
		$this->_Controller->Plate->loadComponent('Test');
		$result = $this->Controller->Test->aMethod(5, 4);
		$this->assertEqual($result, $expected);
	}

	public function testPrefix() {
		$this->_Controller->params['prefix'] = 'admin';
		$this->_Controller->params['controller'] = 'widgets';
		$this->_Controller->action = 'index';
		$this->_Controller->params = array('url' => array('url' => '/admin/widgets/index'));
		$this->_init();
		$expected = 'admin';
		$result = $this->_Controller->Plate->prefix('admin');
		$this->assertEqual($result, $expected);

		$this->_Controller->params['prefix'] = null;
		$this->_Controller->params['controller'] = 'widgets';
		$this->_Controller->action = 'index';
		$this->_Controller->params = array('url' => array('url' => '/admin/widgets/index'));
		$this->_init();
		$result = $this->_Controller->Plate->prefix('admin');
		$this->assertfalse($result);

		$this->_Controller->params['prefix'] = 'members';
		$this->_Controller->params['controller'] = 'profiles';
		$this->_Controller->action = 'index';
		$this->_Controller->params = array('url' => array('url' => '/members/profiles/index'));
		$this->_init();
		$result = $this->_Controller->Plate->prefix('members');
		$this->assertEqual($result, 'members');
	}

	public function testSetTheme() {
		$this->_Controller->params['prefix'] = 'admin';
		$this->_Controller->params['controller'] = 'widgets';
		$this->_Controller->params = array('url' => array('url' => '/admin/widgets/index'));
		$this->_Controller->action = 'index';
		$this->_init();
		$this->_Controller->layout = false;
		$this->_Controller->render(false);
		$expected = 'admin';
		$result = $this->Controller->theme;
		$this->assertEqual($result, $expected);

		$this->_Controller->params['prefix'] = null;
		$this->_Controller->params['controller'] = 'widgets';
		$this->_Controller->params = array('url' => array('url' => '/widgets/index'));
		$this->_Controller->action = 'index';
		$this->_init();
		$this->_Controller->index();
		$this->_Controller->layout = false;
		$this->_Controller->render(false);
		$expected = 'en-gb';
		$result = $this->_Controller->theme;
		$this->assertEqual($result, $expected);
	}
}