<?php
/* Plate Test cases generated on: 2011-11-14 04:36:16 : 1321245376*/
App::uses('PlateComponent', 'BakingPlate.Controller/Component');

/**
 * PlateComponent Test Case
 *
 */
class PlateComponentTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.post');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Plate = new PlateComponent();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Plate);

		parent::tearDown();
	}

/**
 * testInitialize method
 *
 * @return void
 */
	public function testInitialize() {

	}

/**
 * testStartup method
 *
 * @return void
 */
	public function testStartup() {

	}

/**
 * testBeforeRender method
 *
 * @return void
 */
	public function testBeforeRender() {

	}

/**
 * testShutdown method
 *
 * @return void
 */
	public function testShutdown() {

	}

/**
 * testBeforeRedirect method
 *
 * @return void
 */
	public function testBeforeRedirect() {

	}

/**
 * testLoadComponent method
 *
 * @return void
 */
	public function testLoadComponent() {

	}

/**
 * testPrefix method
 *
 * @return void
 */
	public function testPrefix() {

	}

/**
 * testFlash method
 *
 * @return void
 */
	public function testFlash() {

	}

/**
 * testRedirectUnless method
 *
 * @return void
 */
	public function testRedirectUnless() {

	}

}
