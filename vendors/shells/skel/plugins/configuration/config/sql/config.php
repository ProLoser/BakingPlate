<?php
class configSchema extends CakeSchema {
  var $name = 'config';
  
  function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}
  
  var $configurations = array(
			'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
			'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'key' => 'unique'),
			'value' => array('type' => 'text', 'null' => false, 'default' => NULL),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'name' => array('column' => 'name', 'unique' => 1))
		);
}
?>