<?php

/**
 * FormPlus Test Cases
 * generated on: 2011-11-14 04:34:41 : 1321245281
 */
App::uses('FormPlusHelper', 'BakingPlate.View/Helper');

/**
 * FormPlusHelper Test Case
 *
 */
class FormPlusHelperTest extends CakeTestCase {

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

		$this->FormPlus = new FormPlusHelper(new View(null));
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->FormPlus);

		parent::tearDown();
	}

/**
 * testText method
 *
 * @return void
 */
	public function testText() {
	}

}
