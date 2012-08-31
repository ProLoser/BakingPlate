<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

	public $recursive = -1;

	public $actsAs = array(
		'Containable',
	);

	/**
	 * Adds translation to all validation messages
	 * Repairs a glitch in aliases used with virtual fields
	 *
	 * @param string $id 
	 * @param string $table 
	 * @param string $ds 
	 */
	public function __construct($id = false, $table = null, $ds = null) {
		foreach ($this->validate as $field => $rules) {
			if (isset($this->validate[$field]['message'])) {
				$this->validate[$field]['message'] = __($this->validate[$field]['message']);
			} elseif (is_array($rules) && !isset($rules['rule'])) {
				foreach ($rules as $slot => $rule) {
					if (isset($rule['message'])) {
						$this->validate[$field][$slot]['message'] = __($rule['message']);
					}
				}
			}
		}
		parent::__construct($id, $table, $ds);
		foreach ($this->virtualFields as $field => $value) {
			$this->virtualFields[$field] = str_replace($this->name, $this->alias, $value);
		}
	}
	
	/**
	 * Before Validate
	 *
	 * @return void
	 * @author Dean
	 */
	public function beforeValidate($options = array()) {
		// Makes the HABTM fields validateable
		foreach($this->hasAndBelongsToMany as $alias => $options) { 
			if (isset($this->data[$alias][$alias])) { 
				$this->data[$this->alias][$alias] = $this->data[$alias][$alias]; 
			} 
		} 
	}
	
	/**
	 * Custom Model::paginateCount() method to support custom model find pagination
	 *
	 * @param array $conditions
	 * @param int $recursive
	 * @param array $extra
	 * @return array
	 */
	public function paginateCount($conditions = array(), $recursive = 0, $extra = array()) {
		$parameters = compact('conditions');

		if ($recursive != $this->recursive) {
			$parameters['recursive'] = $recursive;
		}

		if (isset($extra['type'])) {
			$extra['operation'] = 'count';
			return $this->find($extra['type'], array_merge($parameters, $extra));
		} else {
			return $this->find('count', array_merge($parameters, $extra));
		}
	}

	/**
	 * Removes 'fields' key and 'contain' from count query on custom finds when it is an array,
	 * as it will completely break the Model::_findCount() call
	 *
	 * @param string $state Either "before" or "after"
	 * @param array $query
	 * @param array $data
	 * @return int The number of records found, or false
	 * @access protected
	 * @see Model::find()
	 */
	function _findCount($state, $query, $results = array()) {
		if ($state == 'before' && isset($query['operation'])) {
			$this->findQueryType = 'count';
			if (!empty($query['fields']) && is_array($query['fields'])) {
				if (!preg_match('/^count/i', $query['fields'][0])) {
					unset($query['fields']);
				}
			}
			if (isset($query['contain'])) {
				unset($query['contain']);
			}
		}
		return parent::_findCount($state, $query, $results);
	}
	
	/**
	 * Utility method to smoothly switch dbconfigs without woes
	 *
	 * @param string $source 
	 * @param string $useTable 
	 * @return void
	 * @author Ceeram
	 */
	public function setDbConfig($source = null, $useTable = null) {
		$datasource = $this->getDataSource();
		if (method_exists($datasource, 'flushMethodCache')) {
	        $datasource->flushMethodCache();
		}
        if ($source) {
            $this->oldSource = array('useTable' => $this->useTable, 'useDbConfig' => $this->useDbConfig);
            $this->setDataSource($source);
            if ($useTable !== null) {
                $this->setSource($useTable);
            }
        } else {
            if ($this->oldSource) {
                $this->setDataSource($this->oldSource['useDbConfig']);
                $this->setSource($this->oldSource['useTable']);
                $this->oldSource = array();
            }
        }
    }
}
