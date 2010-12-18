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

include(dirname(dirname(__FILE__)) . DS .  'common_params.php'); 
extract($template->templateVars);

$userId = 'user-1';
if ($parentIncluded):
	$parentExistsId = '1';
	$parentNotExistsId = '99';
endif;
$existsId = $existsValue = "'" . str_replace('_', '', Inflector::underscore($name)) . '-1' . "'";
$sluggedValue = "'" . Inflector::underscore('First' . Inflector::singularize($name)) . "'";

?> 
/**
 * testPaginateCount
 *
 * @return void
 * @access public
 */
	public function testPaginateCount() {
		$result = $this-><?php echo $name ?>->paginateCount(array(), 0, array('type' => 'search', 'limit' => 1));
		$this->assertTrue(is_numeric($result));
		$result = $this-><?php echo $name ?>->paginateCount();
		$this->assertTrue(is_numeric($result));
	}
	
/**
 * testSearch
 *
 * @return void
 * @access public
 */
	public function testSearch() {
		$result = $this-><?php echo $name ?>->find('search', array('limit' => 1, 'conditions' => array('id' => <?php echo $existsValue;?>)));
		$this->assertEqual(count($result), 1);
		$this->assertEqual($result[0]['<?php echo $name ?>']['id'], <?php echo $existsValue;?>);
		
		$data = array(
			//add condition based on search filterArgs and fix asserts in next lines if necesery
		);
		$conditions = $this-><?php echo $name ?>->parseCriteria($data);
		$result = $this-><?php echo $name ?>->find('search', array('conditions' => $conditions));
		//$this->assertEqual(count($result), 1);
		//$this->assertEqual($result[0]['<?php echo $name ?>']['id'], <?php echo $existsValue;?>);
	}
