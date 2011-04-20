<?php

App::import('Controller', array('Component', 'Controller'), false);
App::import('Component', array('BakingPlate.Plate', 'RequestHandler'));


class PlateComponentTestController extends Controller {

/**
 * components property
 *
 * @var array
 * @access public
 */
	var $components = array('BakingPlate.Plate');

/**
 * beforeFilter method
 *
 * @access public
 * @return void
 */
	function beforeFilter() {
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

/**
 * start
 *
 * @access public
 * @return void
 */
	function start() {
		$this->Controller = new PlateComponentTestController();
		$this->Controller->constructClasses();
		$this->Controller->Component->initialize($this->Controller);
		$this->Controller->beforeFilter();
		$this->Controller->Component->startup($this->Controller);
		//$this->Controller->Plate->destroy();
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
 * test that initialize sets settings from components array
 *
 * @return void
 */
	function testInitialize() {
		$settings = array(
		);
		$this->Controller->Plate->initialize($this->Controller, $settings);
	}
	
	//public function testStartup(&$controller) {
	//}
	//
	//function beforeRender(&$controller) {
	//}
	//
	//function shutdown(&$controller) {
	//}
	//
	//function beforeRedirect(&$controller, $url, $status = null, $exit = true) {
	//}
	
	function test_checkSSL() {
	}
	
	function test_habtmValidation() {
	}
	
	function test_paginationLimit() {
	}
	
	function test_populateView() {
	}
	
	function loadComponent($components = array()) {
	}
	
	function testPrefix() {
	}
	
	function testSetToView() {
	}
}
?>
