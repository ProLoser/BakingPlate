<?php
class PagesController extends AppController {

/**
 * Controller name
 *
 * @var string
 * @access public
 */
	public $name = 'Pages';

/**
 * Default helper
 *
 * @var array
 * @access public
 */
	public $helpers = array('Html', 'Form');


	/**
	 * display
	 */
	function beforeFilter() {
		parent::beforeFilter();
	}

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @access public
 */
	function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));
		$this->render(implode('/', $path));
	}

/**
 * View for page.
 *
 * @param string $id, page id 
 * @access public
 */
	public function view($slug = null) {
		try {
			$page = (strpos($this->params['url']['url'], '/') === false && isset($slug)) ? $this->Page->view($slug) : $this->Page->findUrl($this->params['url']['url']);
		} catch (OutOfBoundsException $e) {
			//$this->Session->setFlash($e->getMessage());
			//$this->redirect(array('action' => 'index'));			
			
			$this->cakeError('error404', array(
				'code' => 404,
				'base' => $this->base,
				'url' => $this->here,
				'message' => $this->here . $e->getMessage(),
				'name' => __('404 File Not Found', true)
			));
		}
		$this->set(compact('page')); 
	}
	
/**
 * Admin index for page.
 * 
 * @access public
 */
	public function admin_index() {
		$this->Page->recursive = 0;
		$this->set('pagesList', $this->Page->getList()); 
		$this->set('pages', $this->paginate()); 
	}

/**
 * Admin view for page.
 *
 * @param string $id, page id 
 * @access public
 */
	public function admin_view($id = null) {
		try {
			$page = $this->Page->view($id);
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect(array('action' => 'index'));
		}
		$this->set(compact('page')); 
	}

/**
 * Admin add for page.
 * 
 * @access public
 */
	public function admin_add() {
		try {
			$result = $this->Page->add($this->data);
			if ($result === true) {
				$this->Session->setFlash(__('The page has been saved', true));
				$this->redirect(array('action' => 'index'));
			}
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage());
		} catch (Exception $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect(array('action' => 'index'));
		}
		$rootPages = $this->Page->RootPage->find('list');
		$parentPages = $this->Page->ParentPage->find('list');
		$users = $this->Page->User->find('list');
		$this->helpers[] = 'TinyMce.TinyMce';
		$this->set(compact('rootPages', 'parentPages', 'users'));
 
	}

/**
 * Admin edit for page.
 *
 * @param string $id, page id 
 * @access public
 */
	public function admin_edit($id = null) {
		try {
			$result = $this->Page->edit($id, $this->data);
			if ($result === true) {
				$this->Session->setFlash(__('Page saved', true));
				$this->redirect(array('action' => 'view', $this->Page->data['Page']['id']));
				
			} else {
				$this->data = $result;
			}
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect('/');
		}
		$this->helpers[] = 'TinyMce.TinyMce';
		$rootPages = $this->Page->RootPage->find('list');
		$parentPages = $this->Page->ParentPage->find('list');
		$users = $this->Page->User->find('list');
		$this->set(compact('rootPages', 'parentPages', 'users'));
 
	}

/**
 * Admin delete for page.
 *
 * @param string $id, page id 
 * @access public
 */
	public function admin_delete($id = null) {
		try {
			$result = $this->Page->validateAndDelete($id, $this->data);
			if ($result === true) {
				$this->Session->setFlash(__('Page deleted', true));
				$this->redirect(array('action' => 'index'));
			}
		} catch (Exception $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->Page->data['page'])) {
			$this->set('page', $this->Page->data['page']);
		}
	}

}