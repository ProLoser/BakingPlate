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
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
App::import('Lib', 'LazyModel.LazyModel');
class AppModel extends LazyModel { // TODO Make sure lazymodel is enabled when publishing
//class AppModel extends Model { // Lazymodel seems to interfere with baking

	var $recursive = -1;
	
	var $actsAs = array(
		'Joinable.Joinable',
		'Linkable.Linkable', // TODO Possibly causing behavior errors when trying to bake
		'Containable',
		'Mi.OneQuery',
		'Cacheable.Cacheable',
		//'Filter.Filter', // TODO something's wrong with the behavior
	);
	
	/**
	 * Repairs a glitch in aliases used with virtual fields
	 *
	 * @param string $id 
	 * @param string $table 
	 * @param string $ds 
	 */
	function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		foreach ($this->virtualFields as $field => $value) {
			$this->virtualFields[$field] = str_replace($this->name, $this->alias, $value);
		}
	}
	
	/**
	 * Allows for custom find types
	 *
	 * @param string $type 
	 * @param string $options 
	 * @return void
	 * @author Dean
	 */
	function find($type, $options = array()) {
		$method = null;
		if(is_string($type)) {
			$method = sprintf('__find%s', Inflector::camelize($type));
		}
		if($method && method_exists($this, $method)) {
			$return = $this->{$method}($options);
		
			if($return === null && !empty($this->query['paginate'])) {
				unset($this->query['paginate']);
				$query = $this->query;
				$this->query = null;
				return $query;
			}
			
			return $return;
		} else {
			$args = func_get_args();
			return call_user_func_array(array('parent', 'find'), $args);
		}
	}
	
	/**
	 * Supplement to the custom find type
	 *
	 * @param string $query 
	 * @return void
	 * @author Dean
	 */
	function beforeFind($query) {
		if(!empty($query['paginate'])) {
			$keys = array('fields', 'order', 'limit', 'page');
			foreach($keys as $key) {
				if($query[$key] === null || (is_array($query[$key]) && $query[$key][0] === null) ) {
					unset($query[$key]);
				}
			}
		
			$this->query = $query;
			return false;
		}
		
		return true;
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
}
