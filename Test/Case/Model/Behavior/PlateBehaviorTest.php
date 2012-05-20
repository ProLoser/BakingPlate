<?php
App::uses('Plate', 'BakingPlate.Model/Behavior');

/**
 * Plate Test Case
 *
 */
class PlateTestCase extends CakeTestCase {
/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Plate = new Plate();
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

}
