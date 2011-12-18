<?php
/**
 * Controller bake template file
 *
 * Allows templating of Controllers generated from bake.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.classes
 * @since         CakePHP(tm) v 1.3
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

echo "<?php\n";
echo "App::uses('{$plugin}AppController', '{$pluginPath}Controller');\n";
?>
/**
 * <?php echo $controllerName; ?> Controller
 *
<?php
if (!$isScaffold) {
	$defaultModel = Inflector::singularize($controllerName);
	echo " * @property {$defaultModel} \${$defaultModel}\n";
	if (!empty($components)) {
		foreach ($components as $component) {
			echo " * @property {$component}Component \${$component}\n";
		}
	}
}
?>
 */
class <?php echo $controllerName; ?>Controller extends <?php echo $plugin; ?>AppController {

<?php if ($isScaffold): ?>
/**
 * Scaffold
 *
 * @var mixed
 */
	public $scaffold;
<?php else: 
if (count($helpers)):
	echo "/**\n * Helpers\n *\n * @var array\n */\n";
	echo "\tpublic \$helpers = array(";
	for ($i = 0, $len = count($helpers); $i < $len; $i++):
		$hlpr[0] = $helpers[$i];
		$hlpr[1] = (in_array($helpers[$i], array('Html', 'Form', 'Paginator'))) ? ' => array(\'className\' => \'BakingPlate.'.$helpers[$i].'Plus\')' : false;
		if ($i != $len - 1):
			echo "'" . Inflector::camelize($hlpr) . "'".$hlpr[1].", ";
		else:
			echo "'" . Inflector::camelize($hlpr) . "'".$hlpr[1];
		endif;
	endfor;
	echo ");\n";
endif;

if (count($components)):
	echo "/**\n * Components\n *\n * @var array\n */\n";
	echo "\tpublic \$components = array(";
	for ($i = 0, $len = count($components); $i < $len; $i++):
		if ($i != $len - 1):
			echo "'" . Inflector::camelize($components[$i]) . "', ";
		else:
			echo "'" . Inflector::camelize($components[$i]) . "'";
		endif;
	endfor;
	echo ");\n";
endif;

?>
	public function beforeFilter() {
		parent::beforeFilter();
	}
<?php

echo $actions;

endif; ?>

}
