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

$userId = "'user-1'";
if ($parentIncluded):
	$parentExistsId = '1';
	$parentNotExistsId = '99';
	if ($parentSlugged) {
		$parentExistsId = "'slug1'";
		$parentNotExistsId = "'noslug'";
	}
endif; 

?> 
/**
 * test<?php echo $methodNamePrefix;?>Find
 *
 * @return void
 * @access public
 */
	public function test<?php echo $methodNamePrefix;?>Find() {
		$this-><?php echo $name ?>->Prg->initialize($this-><?php echo $name ?>);
<?php if ($userIncluded): ?>
		$this-><?php echo $name ?>->Auth->setReturnValue('user', 'user-1', array('id'));
<?php endif;?>
		$this-><?php echo $name ?>-><?php echo $prefix;?>find(<?php if ($parentIncluded) echo $parentExistsId ;?>);
		$this->assertTrue(!empty($this-><?php echo $name ?>->viewVars['<?php echo $controllerVaribleName;?>']));
	}
<?php
	if (!empty($template->templateVars['implementedMethods'])) {
		$implementedMethods = $template->templateVars['implementedMethods'];
	} else {
		$implementedMethods = $template->templateVars['implementedMethods'] = array();
	}
	$components[] = 'test' . $methodNamePrefix . 'Find';
	$template->set('implementedMethods', $implementedMethods);
?>