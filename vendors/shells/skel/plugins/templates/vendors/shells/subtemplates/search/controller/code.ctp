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
?>

/**
 * <?php echo ($admin ? 'Admin find' : 'Find')?> for <?php echo strtolower($singularHumanName);?>.
 *<?php echo $controllerParentHeader;?> 
 * @access public
 */
	public function <?php echo $admin ?>find(<?php echo $controllerParentSingleParam;?>) {
		$this->Prg->commonProcess();
		$this->paginate = array('search', 'conditions' => $this-><?php echo $currentModelName; ?>->parseCriteria($this->passedArgs));
<?php if ($parentIncluded): ?>
<?php if ($parentSlugged): ?>
		$<?php echo $singularParentName;?> = $this-><?php echo $currentModelName ?>-><?php echo $parentClass;?>->find('first', array('conditions' => array('<?php echo $parentClass;?>.slug' => <?php echo $controllerParentSingleParam;?>), 'recursive' => -1));
		$this->paginate['conditions'][] = array('<?php echo $parentIdDbVar;?>' => $<?php echo $singularParentName;?>['<?php echo $parentClass;?>']['id']);
		
<?php else:?>
		$this->paginate['conditions'][] = array('<?php echo $parentIdDbVar;?>' => $<?php echo $parentIdVar;?>);
<?php endif;?>
<?php endif;?>
		$this->set('<?php echo $pluralName ?>', $this->paginate());<?php echo $controllerParentSetVars;?> 
	}
