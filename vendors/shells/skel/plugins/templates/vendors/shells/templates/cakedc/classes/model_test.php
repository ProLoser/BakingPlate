<?php 
/**
 * Copyright 2005-2010, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2005-2010, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
/**
 * Test adding a <?php echo $singularHumanName;?> 
 *
 * @return void
 * @access public
 */
	public function testAdd() {
<?php 
	$userId = 'user-1';
	if ($parentIncluded):
		$parentExistsId = '1';
		$parentNotExistsId = '99';
	endif;
	$existsId = $existsValue = "'" . str_replace('_', '', Inflector::underscore($modelName)) . '-1' . "'";
	$sluggedValue = "'" . Inflector::underscore('First' . Inflector::singularize($modelName)) . "'";
?>
<?php if ($userIncluded): ?>
		$userId = '<?php echo $userId; ?>';
<?php endif;?>
		$data = $this->record;
		unset($data['<?php echo $name;?>']['id']);
		$result = $this-><?php echo $name;?>->add(<?php if ($parentIncluded) echo $parentNotExistsId . ', ';?><?php if ($userIncluded) echo '$userId, ';?>$data);
		$this->assertTrue($result);
		
		try {
			$data = $this->record;
			unset($data['<?php echo $name;?>']['id']);
			//unset($data['<?php echo $name;?>']['title']);
			$result = $this-><?php echo $name;?>->add(<?php if ($parentIncluded) echo $parentNotExistsId . ', ';?><?php if ($userIncluded) echo '$userId, ';?>$data);
			$this->fail('No exception');
		} catch (OutOfBoundsException $e) {
			$this->pass('Correct exception thrown');
		}
		
	}

/**
 * Test editing a <?php echo $singularHumanName;?> 
 *
 * @return void
 * @access public
 */
	public function testEdit() {
<?php if ($userIncluded): ?>
		$userId = '<?php echo $userId; ?>';
<?php endif;?>
		$result = $this-><?php echo $name;?>->edit(<?php echo $existsId;?>, <?php if ($userIncluded) echo '$userId, ';?>null);

		$expected = $this-><?php echo $name;?>->read(null, <?php echo $existsId;?>);
		$this->assertEqual($result['<?php echo $name;?>'], $expected['<?php echo $name;?>']);

		// put invalidated data here
		$data = $this->record;
		//$data['<?php echo $name;?>']['title'] = null;

		$result = $this-><?php echo $name;?>->edit(<?php echo $existsId;?>, <?php if ($userIncluded) echo '$userId, ';?>$data);
		$this->assertEqual($result, $data);

		$data = $this->record;

		$result = $this-><?php echo $name;?>->edit(<?php echo $existsId;?>, <?php if ($userIncluded) echo '$userId, ';?>$data);
		$this->assertTrue($result);

		$result = $this-><?php echo $name;?>->read(null, <?php echo $existsId;?>);

		// put record specific asserts here for example
		// $this->assertEqual($result['<?php echo $name;?>']['title'], $data['<?php echo $name;?>']['title']);

		try {
			$this-><?php echo $name;?>->edit('wrong_id', <?php if ($userIncluded) echo '$userId, ';?>$data);
			$this->fail('No exception');
		} catch (OutOfBoundsException $e) {
			$this->pass('Correct exception thrown');
		}
	}

/**
 * Test viewing a single <?php echo $singularHumanName;?> 
 *
 * @return void
 * @access public
 */
	public function testView() {
		$result = $this-><?php echo $name;?>->view(<?php echo (!$slugged ? $existsId : $sluggedValue);?>);
		$this->assertTrue(isset($result['<?php echo $name;?>']));
		$this->assertEqual($result['<?php echo $name;?>']['id'], <?php echo $existsId;?>);

		try {
			$result = $this-><?php echo $name;?>->view('wrong_id');
			$this->fail('No exception on wrong id');
		} catch (OutOfBoundsException $e) {
			$this->pass('Correct exception thrown');
		}
	}

/**
 * Test ValidateAndDelete method for a <?php echo $singularHumanName;?> 
 *
 * @return void
 * @access public
 */
	public function testValidateAndDelete() {
<?php if ($userIncluded): ?>
		$userId = '<?php echo $userId; ?>';
<?php endif;?>
		try {
			$postData = array();
			$this-><?php echo $name;?>->validateAndDelete('invalid<?php echo $name;?>Id', <?php if ($userIncluded) echo '$userId, ';?>$postData);
		} catch (OutOfBoundsException $e) {
			$this->assertEqual($e->getMessage(), 'Invalid <?php echo $singularHumanName;?>');
		}
		try {
			$postData = array(
				'<?php echo $name;?>' => array(
					'confirm' => 0));
			$result = $this-><?php echo $name;?>->validateAndDelete(<?php echo $existsId;?>, <?php if ($userIncluded) echo '$userId, ';?>$postData);
		} catch (Exception $e) {
			$this->assertEqual($e->getMessage(), 'You need to confirm to delete this <?php echo $singularHumanName;?>');
		}

		$postData = array(
			'<?php echo $name;?>' => array(
				'confirm' => 1));
		$result = $this-><?php echo $name;?>->validateAndDelete(<?php echo $existsId;?>, <?php if ($userIncluded) echo '$userId, ';?>$postData);
		$this->assertTrue($result);
	}