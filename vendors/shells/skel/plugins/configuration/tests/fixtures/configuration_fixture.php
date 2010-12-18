<?php 
/* SVN FILE: $Id$ */
/* Category Fixture generated on: 2009-01-13 11:01:56 : 1231872656*/

class ConfigurationFixture extends CakeTestFixture {
	var $name = 'Configuration';
	var $table = 'configurations';
	var $fields = array(
	  'id' => array('type' => 'integer', 'key' => 'primary'),
	  'name' => array('type' => 'string', 'length' => 255, 'null' => false), 
	  'value' => array('type' => 'text', 'null' => false)
	);
	//var $import = array('table' => 'configurations', 'import' => true);
	var $records = array(array(
    'id'  => 1,
    'name'  => 'latest_news_limit',
    'value' => '10'
  ));
}
?>