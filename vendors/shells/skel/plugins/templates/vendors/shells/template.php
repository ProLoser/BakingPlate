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
 * Template Shell
 *
 * @package templates
 * @subpackage templates.subtemplates
 */
class TemplateShell extends Shell {

/**
 * main
 *
 * @return void
 */
	public function main() {
		$model = $this->in('Model name:');
		$controller = Inflector::pluralize($model);
		$modelSlugged = $this->in("Do you want to bake model '$model' using a slug or id: slug/id", 's/i', 'i');
		$hasParent = $this->in("Is the model '$model' dependent on a parent model: yes/no", 'y/n', 'n');
		if ($hasParent == 'y') {
			$parent = $this->in('Parent model name');
			$parentSlugged = $this->in('Do you have parent model accessed using slug or id: slug/id', 's/i', 'i');
		}
		$userDependent = $this->in("Is the model '$model' dependent on the user model: yes/no", 'y/n', 'n');
		if ($userDependent == 'y') {
			$user = $this->in('Name of your user model:', null, 'User');
		}
		$controllerActions = $this->in('Do you want to bake the controller with all methods: yes/public/admin', 'y/p/a', 'y');
		$appTestCase = $this->in('Do you want to inherit test cases from AppTestCase: yes/no', 'y/n', 'n');
		
		if ($controllerActions == 'y') {
			$controllerActions = 'public admin';
		} elseif ($controllerActions == 'p') {
			$controllerActions = 'public';
		} elseif ($controllerActions == 'a') {
			$controllerActions = 'admin';
		}
		
		$theme = 'cakedc';
		
		$modelCommand = "cake bake model $model";
		$modelCommand = "cake bake model $model";
		$controllerCommand = "cake bake controller $controller $controllerActions";
		$viewCommand = "cake bake view $controller";
		$postfix = " -theme $theme";
		if ($modelSlugged == 's') {
			$postfix .= " -slug";
		}
		if ($hasParent == 'y') {
			$postfix .= " -parent $parent";
			if ($parentSlugged == 'y') {
				$postfix .= " -parentSlug";
			}
		}
		if ($userDependent == 'y') {
			$postfix .= " -user $user";
		}
		if ($appTestCase == 'y') {
			$postfix .= " -appTestCase";
		}
		$postfix .= $this->_possibleSubthemes($this->_getSubtemplates());
		
		$this->out('Use the following commands to bake your code:');
		$this->out($modelCommand . $postfix);
		$this->out($controllerCommand . $postfix);
		$this->out($viewCommand . $postfix);
		$this->out($viewCommand . ' delete delete' . $postfix);
	}

/**
 * Get Sub Template
 *
 * @return array
 */
	protected function _getSubtemplates() {
		App::import('Vendor', 'Templates.Subtemplate');
		$Subtemplate = new Subtemplate($this);
		$Subtemplate->initialize();
		return array_keys($Subtemplate->subTemplatePaths);
	}

/**
 * Possible Subthemes
 *
 * @param array $list 
 * @return string
 */
	protected function _possibleSubthemes($list) {
		$i = 0;
		$this->out('Possible subthemes to include:');
		foreach ($list as $subtheme) {
			$this->out(++$i . '. ' . $subtheme);
		}
		$response = $this->in('Do you want to include any subthemes?');
		if (is_numeric($response)) {
			return " -subthemes " . $list[$response - 1];
		}
		return '';
	}

/**
 * Help
 *
 * @return void
 */
	public function help() {
		$this->out('Template assistant');
	}
} 
