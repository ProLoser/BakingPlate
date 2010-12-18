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
 * Test Case bake template
 *
 */
include(dirname(dirname(__FILE__)) . DS .  'common_params.php');

$implementedMethods = array();

App::import('Vendor', 'Templates.Subtemplate');
$Subtemplate = new Subtemplate($this);
if ($type == 'Model'):
	$modelName = $name = $fullClassName;
	$singularName = Inflector::variable($fullClassName);
	$singularHumanName = Inflector::humanize(Inflector::underscore(Inflector::singularize($fullClassName))); 
	if ($useAppTestCase) {
		$localConstruction = "AppMock::getTestModel('$fullClassName');\n";
	} else {
		$localConstruction = "ClassRegistry::init('$fullClassName');\n";
	}
	$Subtemplate->set(compact('name', 'singularName', 'singularHumanName', 'localConstruction'));
elseif ($type == 'Controller'):
	$name = $className;
	$controllerVaribleName = Inflector::variable($name);
	$modelName = Inflector::singularize($name);
	$modelVariableName = Inflector::variable($modelName);
	$singularHumanName = Inflector::humanize(Inflector::underscore(Inflector::singularize($modelName))); 
	$_className = substr($fullClassName, 0, strlen($fullClassName) - 10);
	if ($useAppTestCase) {
		$localConstruction = "AppMock::getTestController('$fullClassName');\n\t\t\$this->{$_className}->constructClasses();\n";
	} else {
		$localConstruction = "new Test$fullClassName();\n\t\t\$this->{$_className}->constructClasses();\n";
	}
	$Subtemplate->set(compact('name', 'controllerVaribleName', 'modelName', 'modelVariableName', 'singularHumanName', 'localConstruction'));
else:
endif;


echo "<?php\n";
echo "/* ". $className ." Test cases generated on: " . date('Y-m-d H:m:s') . " : ". time() . "*/\n";
?>
App::import('<?php echo $type; ?>', '<?php echo $plugin . $className;?>');

<?php if ($mock and strtolower($type) == 'controller'): ?>
<?php if ($userIncluded): ?>
App::import('Component', array('Auth'));

Mock::generate('AuthComponent', '<?php echo $fullClassName; ?>TestAuthComponent');

<?php endif;?>
<?php endif; ?>
<?php if (!empty($useAppTestCase)): ?>
App::import('Lib', 'Templates.AppTestCase');
class <?php echo $fullClassName; ?>TestCase extends AppTestCase {
/**
 * Autoload entrypoint for fixtures dependecy solver
 *
 * @var string
 * @access public
 */
	public $plugin = 'app';

/**
 * Test to run for the test case (e.g array('testFind', 'testView'))
 * If this attribute is not empty only the tests from the list will be executed
 *
 * @var array
 * @access protected
 */
	protected $_testsToRun = array();

<?php else: ?>
class <?php echo $fullClassName; ?>TestCase extends CakeTestCase {
<?php if (!empty($fixtures)): ?>
/**
 * Fixtures
 *
 * @var array
 * @access public
 */
	public $fixtures = array('<?php echo join("', '", $fixtures); ?>');

<?php endif; ?>
<?php endif; ?>
/**
 * Start Test callback
 *
 * @param string $method
 * @return void
 * @access public
 */
	public function startTest($method) {
		parent::startTest($method);
		$this-><?php echo $className . ' = ' . $localConstruction; ?>
<?php if ($mock and strtolower($type) == 'controller'): ?>
<?php if ($userIncluded): ?>
		$this-><?php echo $className ?>->Auth = new <?php echo $fullClassName; ?>TestAuthComponent();
<?php endif;?>
		$this-><?php echo $className ?>->params = array(
			'named' => array(),
			'pass' => array(),
			'url' => array());
<?php endif;?>
		$fixture = new <?php echo $modelName ?>Fixture();
		$this->record = array('<?php echo $modelName ?>' => $fixture->records[0]);
	}

/**
 * End Test callback
 *
 * @param string $method
 * @return void
 * @access public
 */
	public function endTest($method) {
		parent::endTest($method);
		unset($this-><?php echo $className;?>);
		ClassRegistry::flush();
	}

<?php if ($type == 'Model'):
	$implementedMethods = array('add', 'edit', 'view', 'validateAndDelete');
	include(dirname(__FILE__) . DS . 'model_test.php');
	echo $Subtemplate->generate('model', 'tests');
?>
<?php elseif ($type == 'Controller'): ?>
/**
 * Convenience method to assert Flash messages
 *
 * @return void
 * @access public
 */
	public function assertFlash($message) {
		$flash = $this-><?php echo $className ?>->Session->read('Message.flash');
		$this->assertEqual($flash['message'], $message);
		$this-><?php echo $className ?>->Session->delete('Message.flash');
	}

/**
 * Test object instances
 *
 * @return void
 * @access public
 */
	public function testInstance() {
		$this->assertIsA($this-><?php echo $className ?>, '<?php echo $fullClassName; ?>');
		//$this->assertIsA($this-><?php echo $className ?>-><?php echo $currentModelName ?>, '<?php echo $currentModelName ?>');
	}


<?php
	$implementedMethods = array();
	$publicImplementedMethods = array('add', 'edit', 'view', 'delete', 'index'); 
	if (count(array_diff($publicImplementedMethods, $methods)) == 0) {
		$prefix = '';
		$methodNamePrefix = '';
		include(dirname(__FILE__) . DS . 'controller_test.php'); 
		$Subtemplate->set(compact('prefix', 'methodNamePrefix'));
		echo $Subtemplate->generate('controller', 'tests');
	} else {
		$publicImplementedMethods = array(); 
	}
	$adminImplementedMethods = array('admin_add', 'admin_edit', 'admin_view', 'admin_delete', 'admin_index'); 
	if (count(array_diff($adminImplementedMethods, $methods)) == 0) {
		$prefix = 'admin_';
		$methodNamePrefix = 'Admin';
		include(dirname(__FILE__) . DS . 'controller_test.php'); 
		$Subtemplate->set(compact('prefix', 'methodNamePrefix'));
		echo $Subtemplate->generate('controller', 'tests');
	} else {
		$adminImplementedMethods = array(); 
	}
	$implementedMethods = array_merge($implementedMethods, $adminImplementedMethods, $publicImplementedMethods);
endif; ?>

	
<?php foreach (array_diff($methods, $implementedMethods) as $method): ?>
	//public function test<?php echo Inflector::classify($method); ?>() {

	//}
	

<?php endforeach;?>
}
<?php echo '?>'; ?>