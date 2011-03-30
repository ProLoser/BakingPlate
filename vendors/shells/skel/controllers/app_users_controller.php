<?php
App::import('Controller', 'Users.Users');	
class AppUsersController extends UsersController {

	var $name = 'AppUsers';
        
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allowedActions = array('register', 'help', 'index', 'view', 'logout');
		$this->User = ClassRegistry::init('AppUser');
	}
	
	function beforeRender() {
		parent::beforeRender();
	}
	
	public function dashboard() {
		parent::dashboard();
		$this->render($this->action);
	}
	
	public function login() {
		parent::login();
		$this->render($this->action);
	}
	
	public function logout() {
		parent::logout();
		$this->render($this->action);
	}
	
	public function view($slug = null) {
		parent::view($slug);
		$this->render($this->action);
	}
	
	public function verify($type = 'email', $token = null) {
		parent::verify($type, $token);
		$this->render($this->action);
	}
	
	public function admin_dashboard() {
		parent::dashboard();
		$this->render($this->action);
	}
	
	public function admin_index() {
		parent::admin_index();
		$this->render($this->action);
	}
	
	public function admin_view($slug = null) {
		parent::admin_view($slug);
		$this->render($this->action);
	}
	
	public function admin_add() {
		parent::admin_add();
		$this->render($this->action);
	}
	
	public function admin_edit($slug = null) {
		parent::admin_edit($slug);
		$this->render($this->action);
	}
	
	public function admin_delete() {
		parent::admin_delete();
		$this->render($this->action);
	}
	
	public function admin_login() {
		parent::login();
		$this->render($this->action);
	}
	
	public function admin_logout() {
		parent::logout();
	}
	
	public function register() {
		parent::register();
		$this->render($this->action);
	}
        
	public function render($action = null, $layout = null, $file = null) {
		if (!file_exists(VIEWS . 'app_users' . DS . $this->action . '.ctp')) {
			$file = App::pluginPath('users') . 'views' . DS . 'users' . DS . $action . '.ctp';
		}
		return parent::render($action, $layout, $file);
	}

}
?>