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

/**
 * Bake Template for Controller action generation.
 *
 */
include(dirname(dirname(__FILE__)) . DS .  'common_params.php');

if ($parentIncluded) {
	$controllerRoutePostfix = ', $' . $parentIdVar;
	$controllerParentSetVars = "\n\t\t\$this->set(compact('". $parentIdVar . "'));";
	$controllerParentHeader = "\n" . ' * @param string $' . $parentIdVar . ', ' . $singularHumanParentName . " id";
	$controllerParentSingleParam =  '$' . $parentIdVar;
	if ($parentSlugged) {
		//$controllerParentSingleParamDbField = "'{$parentSlugVar}'";
		
		$controllerRoutePostfix = ', $' . $parentSlugVar;
		$controllerParentSetVars = "\n\t\t\$this->set(compact('". $parentSlugVar . "'));";
		$controllerParentHeader = "\n" . ' * @param string $' . $parentSlugVar . ', ' . $singularHumanParentName . " id";
		$controllerParentSingleParam =  '$' . $parentSlugVar;
		$controllerParentSingleParamName = "'\${$parentSlugVar}'";
		
	}
	
} else {
	$controllerParentHeader = $controllerRoutePostfix = $controllerParentSetVars = '';
	$controllerParentSingleParam = '';
}

$controllerHeaderId = $controllerHeader = ' * @param string $id, ' . strtolower($singularHumanName) . " id";
$controllerSingleParamId = $controllerSingleParam = '$id = null';
$controllerSingleParamNameId = $controllerSingleParamName = '$id';
$controllerSingleParamDbField = "'id'";

if ($slugged) {
	$controllerHeader = ' * @param string $slug, ' . strtolower($singularHumanName) . " slug";
	$controllerSingleParam = '$slug = null';
	$controllerSingleParamName = '$slug';
	$controllerSingleParamDbField = "'slug'";
}

App::import('Vendor', 'Templates.Subtemplate');
$Subtemplate = new Subtemplate($this);
echo $Subtemplate->generate('controller', 'code', $this->templateVars);
?>

/**
 * <?php echo ($admin ? 'Admin index' : 'Index')?> for <?php echo strtolower($singularHumanName);?>.
 *<?php echo $controllerParentHeader;?> 
 * @access public
 */
	public function <?php echo $admin ?>index(<?php echo $controllerParentSingleParam;?>) {
		$this-><?php echo $currentModelName ?>->recursive = 0;
<?php if ($parentIncluded): ?>
<?php if ($parentSlugged): ?>
		$<?php echo $singularParentName;?> = $this-><?php echo $currentModelName ?>-><?php echo $parentClass;?>->find('first', array('conditions' => array('<?php echo $parentClass;?>.slug' => <?php echo $controllerParentSingleParam;?>), 'recursive' => -1));
		if (empty($<?php echo $singularParentName;?>)) {
			$this->Session->setFlash(__('Wrong id',true));
			$this->redirect('/');
		}
		$this->paginate['conditions'] = array('<?php echo $parentIdDbVar;?>' => $<?php echo $singularParentName;?>['<?php echo $parentClass;?>']['id']);
<?php else:?>
		$this->paginate['conditions'] = array('<?php echo $parentIdDbVar;?>' => $<?php echo $parentIdVar;?>);
<?php endif;?>
<?php endif;?>
		$this->set('<?php echo $pluralName ?>', $this->paginate());<?php echo $controllerParentSetVars;?> 
	}

/**
 * <?php echo ($admin ? 'Admin view' : 'View')?> for <?php echo strtolower($singularHumanName);?>.
 *
<?php echo $controllerHeader; ?> 
 * @access public
 */
	public function <?php echo $admin ?>view(<?php echo $controllerSingleParam;?>) {
		try {
			$<?php echo $singularName; ?> = $this-><?php echo $currentModelName; ?>->view(<?php echo $controllerSingleParamName; ?>);
<?php if ($parentIncluded):?>
			$<?php echo $parentIdVar;?> = $<?php echo $singularName; ?>['<?php echo $currentModelName; ?>']['<?php echo $parentIdDbVar;?>'];
<?php if ($parentSlugged): ?>
			$<?php echo $singularParentName;?> = $this-><?php echo $currentModelName ?>-><?php echo $parentClass;?>->find('first', array('conditions' => array('<?php echo $parentClass;?>.id' => $<?php echo $parentIdVar;?>), 'recursive' => -1));
			$<?php echo $parentSlugVar;?> = $<?php echo $singularParentName;?>['<?php echo $parentClass;?>']['slug'];
<?php endif;?>
<?php endif; ?>
		} catch (OutOfBoundsException $e) {
<?php if ($wannaUseSession): ?>
			$this->Session->setFlash($e->getMessage());
<?php if ($parentIncluded):?>		
			$this->redirect('/');
<?php else: ?>
			$this->redirect(array('action' => 'index'));
<?php endif; ?>
<?php else: ?>
<?php if ($parentIncluded):?>		
			$this->flash($e->getMessage(), '/');
<?php else: ?>
			$this->flash($e->getMessage(), array('action' => 'index'));
<?php endif; ?>
<?php endif; ?>
		}
		$this->set(compact('<?php echo $singularName; ?>'));<?php echo $controllerParentSetVars;?> 
	}

<?php $compact = array(); ?>
/**
 * <?php echo ($admin ? 'Admin add' : 'Add')?> for <?php echo strtolower($singularHumanName);?>.
 *<?php echo $controllerParentHeader;?> 
 * @access public
 */
	public function <?php echo $admin ?>add(<?php echo $controllerParentSingleParam;?>) {
		try {
<?php if ($parentSlugged): ?>
			$<?php echo $singularParentName;?> = $this-><?php echo $currentModelName ?>-><?php echo $parentClass;?>->find('first', array('conditions' => array('<?php echo $parentClass;?>.slug' => $<?php echo $parentSlugVar;?>), 'recursive' => -1));
			if (empty($<?php echo $singularParentName;?>)) {
				$this->Session->setFlash(__('Wrong id',true));
				$this->redirect('/');
			}
			$<?php echo $parentIdVar;?> = $<?php echo $singularParentName;?>['<?php echo $parentClass;?>']['id'];
<?php endif; ?>
			$result = $this-><?php echo $currentModelName; ?>->add(<?php if ($parentIncluded) echo '$' . $parentIdVar . ', ' ?><?php if ($userIncluded) echo '$this->Auth->user(\'id\'), ';?>$this->data);
			if ($result === true) {
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__('The <?php echo strtolower($singularHumanName); ?> has been saved', true));
				$this->redirect(array('action' => 'index'<?php echo $controllerRoutePostfix; ?>));
<?php else: ?>
				$this->flash(__('<?php echo ucfirst(strtolower($currentModelName)); ?> saved.', true), array('action' => 'index'<?php echo $controllerRoutePostfix; ?>));
<?php endif; ?>
			}
		} catch (OutOfBoundsException $e) {
<?php if ($wannaUseSession): ?>
			$this->Session->setFlash($e->getMessage());
<?php endif; ?>
		} catch (Exception $e) {
<?php if ($wannaUseSession): ?>
			$this->Session->setFlash($e->getMessage());
			$this->redirect(array('action' => 'index'<?php echo $controllerRoutePostfix; ?>));
<?php else: ?>
			$this->flash($e->getMessage(), array('action' => 'index'<?php echo $controllerRoutePostfix; ?>));
<?php endif; ?>
		}
<?php
	foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
		foreach ($modelObj->{$assoc} as $associationName => $relation):
			if (!empty($associationName)):
				$otherModelName = $this->_modelName($associationName);
				$otherPluralName = $this->_pluralName($associationName);
				echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list');\n";
				$compact[] = "'{$otherPluralName}'";
			endif;
		endforeach;
	endforeach;
	if (!empty($compact)):
		echo "\t\t\$this->set(compact(".join(', ', $compact)."));\n";
	endif;
?><?php echo r("\n", '', $controllerParentSetVars);?> 
	}

<?php $compact = array(); ?>
/**
 * <?php echo ($admin ? 'Admin edit' : 'Edit')?> for <?php echo strtolower($singularHumanName);?>.
 *
<?php echo $controllerHeaderId; ?> 
 * @access public
 */
	public function <?php echo $admin; ?>edit(<?php echo $controllerSingleParamId;?>) {
		try {
			$result = $this-><?php echo $currentModelName; ?>->edit(<?php echo $controllerSingleParamNameId; ?>, <?php if ($userIncluded) echo '$this->Auth->user(\'id\'), ';?>$this->data);
			if ($result === true) {
<?php if ($parentIncluded):?>		
				$<?php echo $parentIdVar;?> = $this-><?php echo $currentModelName; ?>->data['<?php echo $currentModelName; ?>']['<?php echo $parentIdDbVar;?>'];
<?php endif; ?>
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__('<?php echo $singularHumanName;?> saved', true));
				$this->redirect(array('action' => 'view', $this-><?php echo $currentModelName; ?>->data['<?php echo $currentModelName; ?>'][<?php echo $controllerSingleParamDbField;?>]));
<?php else: ?>
			$this->flash(__('Invalid <?php echo strtolower($singularHumanName); ?>', true), array('action' => 'view', $this-><?php echo $currentModelName; ?>->data['<?php echo $currentModelName; ?>'][<?php echo $controllerSingleParamDbField;?>]));
<?php endif; ?>				
			} else {
				$this->data = $result;
<?php if ($parentIncluded):?>		
				$<?php echo $parentIdVar;?> = $this->data['<?php echo $currentModelName; ?>']['<?php echo $parentIdDbVar;?>'];
<?php endif; ?>
			}
<?php if ($parentSlugged): ?>
			$<?php echo $singularParentName;?> = $this-><?php echo $currentModelName ?>-><?php echo $parentClass;?>->find('first', array('conditions' => array('<?php echo $parentClass;?>.id' => $<?php echo $parentIdVar;?>), 'recursive' => -1));
			$<?php echo $parentSlugVar;?> = $<?php echo $singularParentName;?>['<?php echo $parentClass;?>']['slug'];
<?php endif;?>
		} catch (OutOfBoundsException $e) {
<?php if ($wannaUseSession): ?>
			$this->Session->setFlash($e->getMessage());
			$this->redirect('/');
<?php else: ?>
			$this->flash($e->getMessage(), '/');
<?php endif; ?>
		}
<?php
		foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
			foreach ($modelObj->{$assoc} as $associationName => $relation):
				if (!empty($associationName)):
					$otherModelName = $this->_modelName($associationName);
					$otherPluralName = $this->_pluralName($associationName);
					echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list');\n";
					$compact[] = "'{$otherPluralName}'";
				endif;
			endforeach;
		endforeach;
		if (!empty($compact)):
			echo "\t\t\$this->set(compact(".join(', ', $compact)."));\n";
		endif;
	?><?php echo r("\n", '', $controllerParentSetVars);?> 
	}

/**
 * <?php echo ($admin ? 'Admin delete' : 'Delete')?> for <?php echo strtolower($singularHumanName);?>.
 *
<?php echo $controllerHeaderId; ?> 
 * @access public
 */
	public function <?php echo $admin; ?>delete(<?php echo $controllerSingleParamId;?>) {
		try {
<?php if ($parentIncluded):?>
<?php if ($parentSlugged): ?>
			$<?php echo $singularName; ?> = $this-><?php echo $currentModelName; ?>->read(null, $id);
<?php else: ?>
			$<?php echo $singularName; ?> = $this-><?php echo $currentModelName; ?>->view($id);
<?php endif; ?>
			$<?php echo $parentIdVar;?> = $<?php echo $singularName; ?>['<?php echo $currentModelName; ?>']['<?php echo $parentIdDbVar;?>'];			
<?php if ($parentSlugged): ?>
			$<?php echo $singularParentName;?> = $this-><?php echo $currentModelName ?>-><?php echo $parentClass;?>->find('first', array('conditions' => array('<?php echo $parentClass;?>.id' => $<?php echo $parentIdVar;?>), 'recursive' => -1));
			$<?php echo $parentSlugVar;?> = $<?php echo $singularParentName;?>['<?php echo $parentClass;?>']['slug'];
			<?php echo "\$this->set(compact('". $parentSlugVar . "'));";?> 
<?php else:?>
			<?php echo "\$this->set(compact('". $parentIdVar . "'));";?> 
<?php endif;?>
<?php endif; ?>
			$result = $this-><?php echo $currentModelName; ?>->validateAndDelete(<?php echo $controllerSingleParamNameId; ?>, <?php if ($userIncluded) echo '$this->Auth->user(\'id\'), ';?>$this->data);
			if ($result === true) {
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> deleted', true));
				$this->redirect(array('action' => 'index'<?php echo $controllerRoutePostfix; ?>));
<?php else: ?>
				$this->flash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> deleted', true), array('action' => 'index'<?php echo $controllerRoutePostfix; ?>));
<?php endif; ?>
			}
		} catch (Exception $e) {
<?php if ($wannaUseSession): ?>
			$this->Session->setFlash($e->getMessage());
<?php if ($parentIncluded):?>
			$this->redirect('/');
<?php else: ?>
			$this->redirect(array('action' => 'index'));
<?php endif; ?>
<?php else: ?>
<?php if ($parentIncluded):?>
			$this->flash($e->getMessage(), '/');
<?php else: ?>
			$this->flash($e->getMessage(), array('action' => 'index'));
<?php endif; ?>
<?php endif; ?>
		}
		if (!empty($this-><?php echo $currentModelName; ?>->data['<?php echo $singularName; ?>'])) {
			$this->set('<?php echo $singularName; ?>', $this-><?php echo $currentModelName; ?>->data['<?php echo $singularName; ?>']);
		}
	}