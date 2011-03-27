<?php
App::import('Model', 'Users.User');
class AppUser extends User {
	public $useTable = 'users';
	public $name = 'AppUser';
	public $displayField = 'username';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Detail' => array(
			'className' => 'Detail',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
}
?>