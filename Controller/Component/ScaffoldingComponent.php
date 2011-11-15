<?php
/**
 * ScaffoldingComponent
 * 
 * Allows access to scaffold action controller code without having to create abstracted methods in the app_controller
 *
 * @package scaffolding
 * @author Dean Sofer
 * @version 1.0
 * @copyright ProLoser
 **/

class ScaffoldingComponent extends Object {

/**
 * Array containing the names of components this component uses. Component names
 * should not contain the "Component" portion of the classname.
 *
 * @var array
 * @access public
 */
	var $components = array();
	
	var $__settings;

/**
 * Called before the Controller::beforeFilter().
 *
 * @param object  A reference to the controller
 * @return void
 * @access public
 * @link http://book.cakephp.org/view/65/MVC-Class-Access-Within-Components
 */
	function initialize($controller, $settings = array()) {
		if (!isset($this->__settings[$controller->name])) {
			$settings = $this->__settings[$controller->name];
		}
	}

/**
 * Called after the Controller::beforeFilter() and before the controller action
 *
 * @param object  A reference to the controller
 * @return void
 * @access public
 * @link http://book.cakephp.org/view/65/MVC-Class-Access-Within-Components
 */
	function startup($controller) {
	}

/**
 * Called after the Controller::beforeRender(), after the view class is loaded, and before the
 * Controller::render()
 *
 * @param object  A reference to the controller
 * @return void
 * @access public
 */
	function beforeRender($controller) {
	}

/**
 * Called after Controller::render() and before the output is printed to the browser.
 *
 * @param object  A reference to the controller
 * @return void
 * @access public
 */
	function shutdown($controller) {
	}

/**
 * Called before Controller::redirect()
 *
 * @param object  A reference to the controller
 * @param mixed  A string or array containing the redirect location
 * @access public
 */
	function beforeRedirect($controller, $url, $status = null, $exit = true) {
	}
	
	public function add($controller, $params = array()) {
		$params = array_merge(array(
			'redirect' => array('action' => 'index'),
		), $params);
		if (!empty($this->data)) {
			if ($this->{$controller->modelClass}->save($this->data)) {
				$this->Session->setFlash(__('The ' . Inflector::humanize($controller->modelClass) . ' has been saved'));
				if ($params['redirect']) 
					$this->redirect($params['redirect']);
			} else {
				$this->Session->setFlash(__('The ' . Inflector::humanize($controller->modelClass) . ' could not be saved. Please, try again.'));
			}
		}
		$this->populateRelated($controller);
	}
	
	public function edit($controller, $id = null, $params = array()) {
		$params = array_merge(array(
			'redirect' => array('action' => 'index'),
		), $params);
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ' . Inflector::humanize($controller->modelClass)));
			if ($params['redirect']) 
				$this->redirect($params['redirect']);
		}
		$this->add($id, $params);
		if ($id) {
			$controller->{$controller->modelClass}->recursive = 1;
			$this->data = $controller->{$controller->modelClass}->read(null, $id);
		}
	}
	
	public function delete($controller, $id = null, $params = array()) {
		$params = array_merge(array(
			'redirect' => array('action' => 'index'),
		), $params);
		if (!$id) {
			$this->Session->setFlash(__('Invalid ' . Inflector::humanize($controller->modelClass)));
			if ($params['redirect']) 
				$this->redirect($params['redirect']);
		}
		
		
		if (!empty($this->data)) {
			if ($this->{$controller->modelClass}->save($this->data)) {
				$this->Session->setFlash(__('The ' . Inflector::humanize($controller->modelClass) . ' has been saved'));
				if ($params['redirect']) 
					$this->redirect($params['redirect']);
			} else {
				$this->Session->setFlash(__('The ' . Inflector::humanize($controller->modelClass) . ' could not be saved. Please, try again.'));
			}
		}
	}
	
	public function view($controller, $id = null, $params = array()) {
		$params = array_merge(array(
			'redirect' => array('action' => 'index'),
		), $params);
		
	}
	
	public function populateRelated($controller, $params) {
		$relationships = array('belongsTo', 'hasMany', 'hasOne', 'hasAndBelongsToMany');
		foreach ($relationships as $relationship) {
			foreach ($controller->{$relationship} as $key => $value) {
				if (is_int($key)) {
					$key = $value;
				}
				$this->set($data[Inflector::pluralize(Inflector::variable($key))], $controller->{$controller->modelClass}->{$key}->find('list'));
			}
		}
	}
}
?>