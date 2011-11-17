<?php
/* PaginatorPlus Test cases generated on: 2011-11-14 04:35:36 : 1321245336*/
App::uses('PaginatorPlusHelper', 'BakingPlate.View/Helper');

/**
 * PaginatorPlusHelper Test Case
 *
 */
class PaginatorPlusHelperTestCase extends CakeTestCase {
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

		$this->PaginatorPlus = new PaginatorPlusHelper();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PaginatorPlus);

		parent::tearDown();
	}

/**
 * testLimit method
 *
 * @return void
 */
	public function testLimit() {

	}

}
