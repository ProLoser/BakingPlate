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

$slugged = false;
$useAppTestCase = true;
$parentSlugged = false;
$additionalParams = '';
$parentIncluded = false;

if (!empty($this->params['noAppTestCase'])) {
	$useAppTestCase = false;
}


if (!empty($this->params['parent'])) {
	$parentIncluded = true;
	$parentClass = Inflector::classify($this->params['parent']);
	$parentIdDbVar = Inflector::underscore($parentClass . 'Id');
	$parentIdVar = Inflector::variable($parentClass . 'Id');
	$singularParentName = Inflector::variable($parentClass);
	$singularHumanParentName = Inflector::humanize(Inflector::underscore(Inflector::singularize($parentClass))); 
	$additionalParams = ', $' . $parentIdVar;
	if (!empty($this->params['parentSlug'])) {
		$parentSlugged = true;
		$parentSlugVar = Inflector::variable($parentClass . 'Slug');
		$additionalParams = ', $' . $parentSlugVar;
	}
}

if (!empty($this->params['slug'])) {
	$slugged = true;
}
 
if (!empty($this->params['user'])) {
	$userIncluded = true;
	if (is_string($this->params['user'])) {
		$userModel = $this->params['user'];
	} else {
		$userModel = 'User';
	}
} else {
	$userIncluded = false;
}

 
?>