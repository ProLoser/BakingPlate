<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright	  Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link		  http://cakephp.org CakePHP(tm) Project
 * @package		  cake
 * @subpackage	  cake.app
 * @since		  CakePHP(tm) v 0.2.9
 * @license		  MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package		  cake
 * @subpackage	  cake.app
 */
App::import('Lib', 'LazyModel.LazyModel');
class AppModel extends LazyModel {

	var $recursive = -1;
	
	var $actsAs = array(
		'Linkable.Linkable',
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
	function __construct($id = false, $table = null, $ds = null) {
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
		$this->_findMethods['paginatecount'] = true;
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
	public function beforeValidate() {
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
 * @author Jose Gonzalez (savant)
 */
	public function paginateCount($conditions = array(), $recursive = 0, $extra = array()) {
		$parameters = compact('conditions');

		if ($recursive != $this->recursive) {
			$parameters['recursive'] = $recursive;
		}

		if (isset($extra['type']) && isset($this->_findMethods[$extra['type']])) {
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
	protected function _findCount($state, $query, $results = array()) {
		if ($state == 'before' && isset($query['operation'])) {
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
}
