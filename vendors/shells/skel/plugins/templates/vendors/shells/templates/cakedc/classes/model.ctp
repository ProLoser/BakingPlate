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
 * Model template file.
 *
 * Used by bake to create new Model files.
 *
 */

include(dirname(dirname(__FILE__)) . DS .  'common_params.php');

$singularName = Inflector::variable($name);
$singularHumanName = Inflector::humanize(Inflector::underscore(Inflector::singularize($name))); 

$modelHeaderId = $modelHeader = ' * @param string $id, ' . strtolower($singularHumanName) . " id";
$modelSingleParamId = $modelSingleParam = '$id = null';
$modelMainConditionId = $modelMainCondition = '"{$this->alias}.{$this->primaryKey}" => $id';
$controllerSingleParamName = '$id';
$controllerSingleParamDbField = "'id'";

if ($slugged) {
	$modelHeader = ' * @param string $slug, ' . strtolower($singularHumanName) . " slug";
	$modelSingleParam = '$slug = null';
	$modelMainCondition = "'$name.slug' => \$slug";
	$controllerSingleParamName = '$slug';
	$controllerSingleParamDbField = "'slug'";
}

App::import('Vendor', 'Templates.Subtemplate');
$Subtemplate = new Subtemplate($this);


echo $Subtemplate->generate('model', 'preset');
extract($this->templateVars);

echo "<?php\n"; ?>
class <?php echo $name ?> extends <?php echo $plugin; ?>AppModel {
/**
 * Name
 *
 * @var string $name
 * @access public
 */
	public $name = '<?php echo $name; ?>';

<?php if ($useDbConfig != 'default'): ?>
/**
 * Table datasource config name
 *
 * @var string
 * @access public
 */
	public $useDbConfig = '<?php echo $useDbConfig; ?>';
<?php endif;?>
<?php if ($useTable && $useTable !== Inflector::tableize($name)):
	$table = "'$useTable'";
	echo "\tpublic \$useTable = $table;\n";
endif;
if ($primaryKey !== 'id'): ?>
/**
 * Primary key field name
 *
 * @var string
 * @access public
 */
	public $primaryKey = '<?php echo $primaryKey; ?>';
<?php endif;
if ($displayField): ?>
/**
 * Display field name
 *
 * @var string
 * @access public
 */
	public $displayField = '<?php echo $displayField; ?>';
<?php endif;

if (!empty($behaviors) && count($behaviors)):
?>

/**
 * Behaviors
 *
 * @var array
 * @access public
 */
<?php
	echo "\tpublic \$actsAs = array(";
	for ($i = 0, $len = count($behaviors); $i < $len; $i++):
		if ($i != $len - 1):
			echo "'" . Inflector::camelize($behaviors[$i]) . "', ";
		else:
			echo "'" . Inflector::camelize($behaviors[$i]) . "'";
		endif;
	endfor;
	echo ");\n";
endif;
 
if (!empty($validate)):
?>
/**
 * Validation parameters - initialized in constructor
 *
 * @var array
 * @access public
 */
<?php
	echo "\tpublic \$validate = array();\n";
endif;

?>

<?php

foreach (array('hasOne', 'belongsTo') as $assocType):
	if (!empty($associations[$assocType])):
		$typeCount = count($associations[$assocType]);
?>/**
 * <?php echo $assocType;?> association
 *
 * @var array $<?php echo $assocType;?> 
 * @access public
 */<?php
		echo "\n\tpublic \$$assocType = array(";

		foreach ($associations[$assocType] as $i => $relation):
			$out = "\n\t\t'{$relation['alias']}' => array(\n";
			$out .= "\t\t\t'className' => '{$relation['className']}',\n";
			$out .= "\t\t\t'foreignKey' => '{$relation['foreignKey']}',\n";
			$out .= "\t\t\t'conditions' => '',\n";
			$out .= "\t\t\t'fields' => '',\n";
			$out .= "\t\t\t'order' => ''\n";
			$out .= "\t\t)";
			if ($i + 1 < $typeCount) {
				$out .= ",";
			}
			echo $out;
		endforeach;
		echo "\n\t);\n";
	endif;
endforeach;

if (!empty($associations['hasMany'])):
	$belongsToCount = count($associations['hasMany']);
?>
/**
 * hasMany association
 *
 * @var array $hasMany
 * @access public
 */
<?php
	echo "\n\tpublic \$hasMany = array(";
	foreach ($associations['hasMany'] as $i => $relation):
		$out = "\n\t\t'{$relation['alias']}' => array(\n";
		$out .= "\t\t\t'className' => '{$relation['className']}',\n";
		$out .= "\t\t\t'foreignKey' => '{$relation['foreignKey']}',\n";
		$out .= "\t\t\t'dependent' => false,\n";
		$out .= "\t\t\t'conditions' => '',\n";
		$out .= "\t\t\t'fields' => '',\n";
		$out .= "\t\t\t'order' => '',\n";
		$out .= "\t\t\t'limit' => '',\n";
		$out .= "\t\t\t'offset' => '',\n";
		$out .= "\t\t\t'exclusive' => '',\n";
		$out .= "\t\t\t'finderQuery' => '',\n";
		$out .= "\t\t\t'counterQuery' => ''\n";
		$out .= "\t\t)";
		if ($i + 1 < $belongsToCount) {
			$out .= ",";
		}
		echo $out;
	endforeach;
	echo "\n\t);\n\n";
endif;

if (!empty($associations['hasAndBelongsToMany'])):
	$habtmCount = count($associations['hasAndBelongsToMany']);
?>
/**
 * HABTM association
 *
 * @var array $hasAndBelongsToMany
 * @access public
 */
<?php
	echo "\n\tpublic \$hasAndBelongsToMany = array(";
	foreach ($associations['hasAndBelongsToMany'] as $i => $relation):
		$out = "\n\t\t'{$relation['alias']}' => array(\n";
		$out .= "\t\t\t'className' => '{$relation['className']}',\n";
		$out .= "\t\t\t'joinTable' => '{$relation['joinTable']}',\n";
		$out .= "\t\t\t'foreignKey' => '{$relation['foreignKey']}',\n";
		$out .= "\t\t\t'associationForeignKey' => '{$relation['associationForeignKey']}',\n";
		$out .= "\t\t\t'unique' => true,\n";
		$out .= "\t\t\t'conditions' => '',\n";
		$out .= "\t\t\t'fields' => '',\n";
		$out .= "\t\t\t'order' => '',\n";
		$out .= "\t\t\t'limit' => '',\n";
		$out .= "\t\t\t'offset' => '',\n";
		$out .= "\t\t\t'finderQuery' => '',\n";
		$out .= "\t\t\t'deleteQuery' => '',\n";
		$out .= "\t\t\t'insertQuery' => ''\n";
		$out .= "\t\t)";
		if ($i + 1 < $habtmCount) {
			$out .= ",";
		}
		echo $out;
	endforeach;
	echo "\n\t);\n\n";
endif;
?>


/**
 * Constructor
 *
 * @param mixed $id Model ID
 * @param string $table Table name
 * @param string $ds Datasource
 * @access public
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->validate = array(
<?php 
	if (!empty($validate)):
	foreach ($validate as $field => $validations):
		$fieldName = Inflector::humanize(r('_id', '', $field));
		echo "\t\t\t'$field' => array(\n";
		foreach ($validations as $key => $validator):
			echo "\t\t\t\t'$key' => array('rule' => array('$validator'), 'required' => true, 'allowEmpty' => false, 'message' => __('Please enter a $fieldName', true))),\n";
		endforeach;
	endforeach;
	endif;
?>
		);
	}



<?php echo $Subtemplate->generate('model', 'var'); ?>	

/**
 * Adds a new record to the database
 *
<?php if ($parentIncluded): ?>
 * @param string $<?php echo $parentIdVar;?>, <?php echo $singularHumanParentName;?> id
<?php endif;?>
<?php if ($userIncluded): ?>
 * @param string $userId, user id
<?php endif;?>
 * @param array post data, should be Contoller->data
 * @return array
 * @access public
 */
	public function add(<?php if ($parentIncluded) echo '$' . $parentIdVar . ' = null, ';?><?php if ($userIncluded) echo '$userId = null, ';?>$data = null) {
		if (!empty($data)) {
<?php if ($parentIncluded): ?>
			$data['<?php echo $name;?>']['<?php echo $parentIdDbVar;?>'] = $<?php echo $parentIdVar;?>;
<?php endif;?>
<?php if ($userIncluded): ?>
			$data['<?php echo $name;?>']['user_id'] = $userId;
<?php endif;?>
			$this->create();
			$result = $this->save($data);
			if ($result !== false) {
				$this->data = array_merge($data, $result);
				return true;
			} else {
				throw new OutOfBoundsException(__('Could not save the <?php echo $singularName;?>, please check your inputs.', true));
			}
			return $return;
		}
	}

/**
 * Edits an existing <?php echo $singularHumanName;?>.
 *
<?php echo $modelHeaderId; ?> 
<?php if ($userIncluded): ?>
 * @param string $userId, user id
<?php endif;?>
 * @param array $data, controller post data usually $this->data
 * @return mixed True on successfully save else post data as array
 * @throws OutOfBoundsException If the element does not exists
 * @access public
 */
	public function edit(<?php echo $modelSingleParamId;?>, <?php if ($userIncluded) echo '$userId = null, ';?>$data = null) {
		$<?php echo $singularName;?> = $this->find('first', array(
<?php if ($userIncluded): ?>
			'contain' => array('<?php echo $userModel;?>'),
<?php endif;?>
			'conditions' => array(
				<?php echo $modelMainConditionId;?>,
<?php if ($userIncluded): ?>
				"{$this->alias}.user_id" => $userId
<?php endif;?>
				)));

		if (empty($<?php echo $singularName;?>)) {
			throw new OutOfBoundsException(__('Invalid <?php echo $singularHumanName;?>', true));
		}
		$this->set($<?php echo $singularName;?>);

		if (!empty($data)) {
			$this->set($data);
			$result = $this->save(null, true);
			if ($result) {
				$this->data = $result;
				return true;
			} else {
				return $data;
			}
		} else {
			return $<?php echo $singularName;?>;
		}
	}

/**
 * Returns the record of a <?php echo $singularHumanName;?>.
 *
<?php echo $modelHeader; ?>.
 * @return array
 * @throws OutOfBoundsException If the element does not exists
 * @access public
 */
	public function view(<?php echo $modelSingleParam;?>) {
		$<?php echo $singularName;?> = $this->find('first', array(
			'conditions' => array(
				<?php echo $modelMainCondition;?>)));

		if (empty($<?php echo $singularName;?>)) {
			throw new OutOfBoundsException(__('Invalid <?php echo $singularHumanName;?>', true));
		}

		return $<?php echo $singularName;?>;
	}

/**
 * Validates the deletion
 *
<?php echo $modelHeaderId; ?> 
<?php if ($userIncluded): ?>
 * @param string $userId, user id
<?php endif;?>
 * @param array $data, controller post data usually $this->data
 * @return boolean True on success
 * @throws OutOfBoundsException If the element does not exists
 * @access public
 */
	public function validateAndDelete(<?php echo $modelSingleParamId;?>, <?php if ($userIncluded) echo '$userId = null, ';?>$data = array()) {
		$<?php echo $singularName;?> = $this->find('first', array(
			'conditions' => array(
				<?php echo $modelMainConditionId;?>,
<?php if ($userIncluded): ?>
				"{$this->alias}.user_id" => $userId
<?php endif;?>
				)));

		if (empty($<?php echo $singularName;?>)) {
			throw new OutOfBoundsException(__('Invalid <?php echo $singularHumanName;?>', true));
		}

		$this->data['<?php echo $singularName;?>'] = $<?php echo $singularName;?>;
		if (!empty($data)) {
			$data['<?php echo $name;?>']['id'] = $id;
			$tmp = $this->validate;
			$this->validate = array(
				'id' => array('rule' => 'notEmpty'),
				'confirm' => array('rule' => '[1]'));

			$this->set($data);
			if ($this->validates()) {
				if ($this->delete($data['<?php echo $name;?>']['id'])) {
					return true;
				}
			}
			$this->validate = $tmp;
			throw new Exception(__('You need to confirm to delete this <?php echo $singularHumanName;?>', true));
		}
	}

<?php echo $Subtemplate->generate('model', 'code'); ?>

}
<?php echo '?>'; ?>