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

$userId = "'user-1'";
if ($parentIncluded):
	$parentExistsId = '1';
	$parentNotExistsId = '99';
	if ($parentSlugged) {
		$parentExistsId = "'slug1'";
		$parentNotExistsId = "'noslug'";
	}
endif;
$existsId = $existsValue = "'" . str_replace('_', '', Inflector::underscore($modelName)) . '-1' . "'";
if ($slugged) {
	$existsValue = "'" . Inflector::underscore('First' . Inflector::singularize($modelName)) . "'";
}
?>
/**
 * test<?php echo $methodNamePrefix;?>Index
 *
 * @return void
 * @access public
 */
	public function test<?php echo $methodNamePrefix;?>Index() {
<?php if ($userIncluded): ?>
		$this-><?php echo $name ?>->Auth->setReturnValue('user', <?php echo $userId;?>, array('id'));
<?php endif;?>
		$this-><?php echo $name ?>-><?php echo $prefix;?>index(<?php if ($parentIncluded) echo $parentExistsId ;?>);
		$this->assertTrue(!empty($this-><?php echo $name ?>->viewVars['<?php echo $controllerVaribleName;?>']));
	}

/**
 * test<?php echo $methodNamePrefix;?>Add
 *
 * @return void
 * @access public
 */
	public function test<?php echo $methodNamePrefix;?>Add() {
<?php if ($userIncluded): ?>
		$this-><?php echo $name ?>->Auth->setReturnValue('user', <?php echo $userId;?>, array('id'));
<?php endif;?>
		$this-><?php echo $name ?>->data = $this->record;
		unset($this-><?php echo $name ?>->data['<?php echo $modelName ?>']['id']);
		$this-><?php echo $name ?>-><?php echo $prefix;?>add(<?php if ($parentIncluded) echo $parentExistsId;?>);
		$this-><?php echo $name ?>->expectRedirect(array('action' => 'index'<?php if ($parentIncluded) echo ', ' . $parentExistsId ?>));
		$this->assertFlash('The <?php echo strtolower($singularHumanName);?> has been saved');
		$this-><?php echo $name ?>->expectExactRedirectCount();
	}

/**
 * test<?php echo $methodNamePrefix;?>Edit
 *
 * @return void
 * @access public
 */
	public function test<?php echo $methodNamePrefix;?>Edit() {
<?php if ($userIncluded): ?>
		$this-><?php echo $name ?>->Auth->setReturnValue('user', <?php echo $userId;?>, array('id'));
<?php endif;?>
		$this-><?php echo $name ?>-><?php echo $prefix;?>edit(<?php echo $existsId;?>);
		$this->assertEqual($this-><?php echo $name ?>->data['<?php echo $modelName ?>'], $this->record['<?php echo $modelName ?>']);

		$this-><?php echo $name ?>->data = $this->record;
		$this-><?php echo $name ?>-><?php echo $prefix;?>edit(<?php echo $existsId;?>);
		$this-><?php echo $name ?>->expectRedirect(array('action' => 'view', <?php echo (!$slugged ? '1' : "'slug1'");?>));
		$this->assertFlash('<?php echo $singularHumanName;?> saved');
		$this-><?php echo $name ?>->expectExactRedirectCount();
	}

/**
 * test<?php echo $methodNamePrefix;?>View
 *
 * @return void
 * @access public
 */
	public function test<?php echo $methodNamePrefix;?>View() {
<?php if ($userIncluded): ?>
		$this-><?php echo $name ?>->Auth->setReturnValue('user', <?php echo $userId;?>, array('id'));
<?php endif;?>
		$this-><?php echo $name ?>-><?php echo $prefix;?>view(<?php echo $existsValue;?>);
		$this->assertTrue(!empty($this-><?php echo $name ?>->viewVars['<?php echo $modelVariableName;?>']));

		$this-><?php echo $name ?>-><?php echo $prefix;?>view('WRONG-ID');
<?php if ($parentIncluded):?>
		$this-><?php echo $name ?>->expectRedirect('/');

<?php else: ?>
		$this-><?php echo $name ?>->expectRedirect(array('action' => 'index'));
<?php endif; ?>
		$this->assertFlash('Invalid <?php echo $singularHumanName;?>');
		$this-><?php echo $name ?>->expectExactRedirectCount();
	}

/**
 * test<?php echo $methodNamePrefix;?>Delete
 *
 * @return void
 * @access public
 */
	public function test<?php echo $methodNamePrefix;?>Delete() {
<?php if ($userIncluded): ?>
		$this-><?php echo $name ?>->Auth->setReturnValue('user', <?php echo $userId;?>, array('id'));
<?php endif;?>
		$this-><?php echo $name ?>-><?php echo $prefix;?>delete('WRONG-ID');
<?php if ($parentIncluded):?>
		$this-><?php echo $name ?>->expectRedirect('/');
<?php else: ?>
		$this-><?php echo $name ?>->expectRedirect(array('action' => 'index'));
<?php endif; ?>
		$this->assertFlash('Invalid <?php echo $singularHumanName;?>');

		$this-><?php echo $name ?>-><?php echo $prefix;?>delete(<?php echo $existsId;?>);
		$this->assertTrue(!empty($this-><?php echo $name ?>->viewVars['<?php echo $modelVariableName;?>']));

		$this-><?php echo $name ?>->data = array('<?php echo $modelName ?>' => array('confirmed' => 1));
		$this-><?php echo $name ?>-><?php echo $prefix;?>delete(<?php echo $existsId;?>);
		$this-><?php echo $name ?>->expectRedirect(array('action' => 'index'<?php if ($parentIncluded) echo ', ' . $parentExistsId ?>));
		$this->assertFlash('<?php echo ucfirst(strtolower($singularHumanName));?> deleted');
		$this-><?php echo $name ?>->expectExactRedirectCount();
	}

