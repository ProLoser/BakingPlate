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
class AppModel extends LazyModel {

	var $recursive = -1;
	
	var $actsAs = array(
		'Linkable.Linkable', // TODO Possibly causing behavior errors when trying to bake
		'Containable',
		'Cacheable.Cacheable',
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
