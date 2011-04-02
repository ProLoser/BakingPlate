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


	public $uses = array();

	/**
	 * beforeFilter
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
}