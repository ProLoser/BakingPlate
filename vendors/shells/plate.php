<?php
/**
* BakingPlate Class
*/
class PlateShell extends Shell {

	var $tasks = array('Project', 'DbConfig');
	
	/**
	 * _load() populated list of submodules
	 *
	 * @var array
	 */
	var $submodules = array();

	/**
	 * Overridden method so the heading message stops getting spit out
	 *
	 * @return void
	 * @author Dean Sofer
	 */
	function _welcome() {
		Configure::load('BakingPlate.submodules');
		$this->submodules = Configure::read('BakingPlate');
		Configure::load('BakingPlate.version');
		$this->Dispatch->clear();
		$this->out("\nWelcome to BakingPlate v" . Configure::read('BakingPlate.version'));
		$this->hr();
		$this->_prepGroup();
	}

	/**
	 * Shows a list of available commands
	 */
	function main() {
		$this->out("\nAvailable Commands:\n");
		$this->out('bake				- Generates a new app using bakeplate');
		$this->out('browse				- List available submodules');
		$this->out('add <submodule_name|#>		- Add a specific submodule');
		$this->out('all <group|#>			- Add all available submodules');
		$this->out("\nAll commands take a -group param to narrow the list of submodules to a specific group. All <params> are optional.");
	}

	/**
	 * Generates a new project with a little bit of added fluff
	 *
	 * @return void
	 * @author Dean Sofer
	 */
	function bake() {
		if (!isset($this->params['group'])) {
			$this->params['group'] = 'core';
		}
		$this->params['skel'] = $this->_pluginPath('BakingPlate') . 'vendors' . DS . 'shells' . DS . 'skel ' . implode(' ', $this->args);
		$working = $this->params['working'];
		$this->Project->execute();
		
		$this->nl();
		$this->out('Making temp folders writeable...');
		exec('chmod -R 777 ' . $this->params['app'] . '/tmp/*');
		exec('chmod -R 777 ' . $this->params['app'] . '/webroot/cache_css');
		exec('chmod -R 777 ' . $this->params['app'] . '/webroot/cache_js');
		exec('chmod -R 777 ' . $this->params['app'] . '/webroot/uploads');

		$this->nl();
		chdir($this->params['app']);
		$this->out(passthru('git init'));
		$this->all();
		
		$this->DbConfig->path = $working . DS . $this->params['app'] . DS . 'config' . DS;
		if (!config('database')) {
			$this->out(__("\nYour database configuration was not found. Take a moment to create one.", true));
			$this->args = null;
			$this->DbConfig->execute();
		}
	}

	/**
	 * Add a specific submodule/plugin
	 *
	 * @return void
	 * @author Dean Sofer
	 */
	function add() {
		if (!isset($this->args[0])) {
			$this->browse();
			if (!isset($this->params['group'])) {
				$this->params['group'] = $this->in('Specify a group name or #');
				$this->_prepGroup();
				$this->browse();
			}
			$submodule = $this->in('Specify a submodule_name or #');
		} else {
			$this->_prepGroup();
			$submodule = (strpos($this->args[0], ',') !== false) ? explode(',', $this->args[0]) : $this->args[0];
		}
		if (is_array($submodule)) {
			foreach($submodule as $path) {
				$this->_addSubmodule($path);
			}
		} else {
			$this->_addSubmodule($submodule);
		}
	}

	/**
	 * Render a list of submodules
	 */
	function browse() {
		if (!isset($this->params['group'])) {
			$this->out("\nAvailable Groups:\n");
			$i = 0;
			$this->out('#) All');
			foreach ($this->submodules as $group => $items) {
				$i++;
				$this->out($i . ') ' . Inflector::humanize($group));
			}
		} else {
			$this->out("\nAvailable Submodules:\n");
			$i = 0;
			$submodules = $this->_getSubmodules();
			foreach ($submodules as $path => $url) {
				$i++;
				$this->out($i . ') ' . Inflector::humanize($path));
			}
		}
		$this->out();
	}

	/**
	 * Add all submodules
	 */
	function all() {
		if (isset($this->args[0])) {
			$this->params['group'] = $this->args[0];
		} else {		
			$this->browse();
			$this->params['group'] = $this->in('Specify a group name or #');
			$this->_prepGroup();
		}
		$this->out("\nAdding {$this->params['group']} git submodules...\n");
		
		$submodules = $this->_getSubmodules();
		foreach ($submodules as $path => $url) {
			$this->_addSubmodule($path);
		}
		$this->out("\n================ Finished Adding Submodules ===================");
	}
	
	/**
	 * Adds a submodule via git
	 *
	 * @param string $path 
	 * @param string $url 
	 * @return void
	 * @author Dean Sofer
	 */
	private function _addSubmodule($path) {
		$path = Inflector::underscore($path);
		$submodules = $this->_getSubmodules();
		if (is_numeric($path)) {
			$items = array_keys($submodules);
			if (!isset($submodules[$items[$path-1]]))
				$url = $submodules[$items[$path-1]];
		} elseif (isset($submodules[$path])) {
			$url = $submodules[$path];
		} 
		if (!isset($url)) {
			$this->out('Submodule not found');
			return false;
		}
		$folder = (isset($this->submodules['vendors'][$path])) ? 'vendors': 'plugins';
		$this->out("\n===============================================================");
		$this->out('Adding ' . Inflector::humanize($path));
		$this->hr();
		exec("git submodule add {$url} {$folder}/{$path}");
	}
	
	/**
	 * Method used to prep the group argument
	 * Converts -g short-param to -group and converts number to group name
	 *
	 * @return void
	 * @author Dean Sofer
	 */
	protected function _prepGroup() {
		if (isset($this->params['g']))
			$this->params['group'] = $this->params['g'];

		if (!isset($this->params['group']) || $this->params['group'] === '#')
			$this->params['group'] = 'all';		

		if (isset($this->params['group']) && is_numeric($this->params['group'])) {
			$groups = array_keys($this->submodules);
			$slot = $this->params['group'] - 1;
			$this->params['group'] = $groups[$slot];
		}
	}
	
	/**
	 * References the group param to return an array of submodules
	 *
	 * @return void
	 * @author Dean Sofer
	 */
	protected function _getSubmodules() {
		if (strtolower($this->params['group']) === 'all') {
			$submodules = array();
			foreach ($this->submodules as $items) {
				$submodules = array_merge($submodules, $items);
			}
		} else {
			$submodules = $this->submodules[$this->params['group']];
		}
		return $submodules;
	}
}
