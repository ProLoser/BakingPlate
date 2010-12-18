<?php
class InteractiveController extends InteractiveAppController {
	var $name = 'Interactive';
  var $uses = array('Interactive.Interactive');
	var $components = array('RequestHandler');
	
	var $helpers = array('DebugKit.Toolbar' => array('output' => 'DebugKit.HtmlToolbar'));
	
	function beforeFilter() {
		if(!empty($this->Security)) {
			$this->Security->validatePost = false;
		}
	}
	
  function cmd() {
		//the debug_kit toolbar component, which is probably included in AppController
		//forces the output to be FirePHP, which means we can't use makeNeatArray
		$this->helpers['DebugKit.Toolbar']['output'] = 'DebugKit.HtmlToolbar';
		
		if (Configure::read('debug') == 0) {
			return $this->redirect($this->referer());
		}
    
    Configure::write('debug', 0);
    
    if(empty($this->data['Interactive']['cmd'])) {
      return;
    }
    
		$results = $this->Interactive->process($this->data['Interactive']['cmd']);
    $this->set('results', $results);
  }
}
?>