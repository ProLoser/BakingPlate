<?php
/**
* BakingPlate Class
*/
class PlateShell extends Shell {

	var $tasks = array('Project');
	
	/**
	 * _load() populated list of submodules
	 *
	 * @var string
	 */
	var $submodules = array();

	/**
	 * Loads the list of submodules from config
	 *
	 * @return array submodules
	 * @author Dean Sofer
	 */
	function _load() {
		if (Configure::read('BakingPlate'))
			return;
		Configure::load('BakingPlate.submodules');
		
		if (isset($this->params['group'])) {
			$this->submodules = Configure::read('BakingPlate.'. $this->params['group']);
		} else {
			$submodules = Configure::read('BakingPlate');
			foreach ($submodules as $group => $modules) {
				$this->submodules = array_merge($this->submodules, $modules);
			}
		}
	}

	/**
	 * Overridden method so the heading message stops getting spit out
	 *
	 * @return void
	 * @author Dean Sofer
	 */
	function _welcome() {}

	/**
	 * Shows a list of available commands
	 */
	function main() {
		$this->out("\nAvailable Commands:\n");
		$this->out('bake	- Generates a new app using bakeplate');
		$this->out('browse	- List available submodules');
		$this->out('add <#|submodule_name>	- Add a specific submodule');
		$this->out('all	- Add all available submodules');
	}

	function bake() {
		$this->params['skel'] = $this->_pluginPath('BakingPlate') . 'vendors' . DS . 'shells' . DS . 'skel ' . implode(' ', $this->args);
		if (!$this->Project->execute()) {
			return false;
		}
		$this->out(passthru('git init ' . $this->params['app']));
		chdir($this->params['app']);
		$this->all();
		
	}

	/**
	 * Add a specific submodule/plugin
	 *
	 * @return void
	 * @author Dean Sofer
	 */
	function add() {
		$this->_load();
		$keys = array_keys($this->submodules);
		if (!isset($this->args[0])) {
			$this->browse();
			$this->out($this->nl());
			$plugin = $this->in('Specify a # or submodule_name');
		} else {
			$plugin = $this->args[0];
		}
		if (is_numeric($plugin)) {
			$path = $keys[$plugin-1];
		} else {
			$path = Inflector::underscore($plugin);
		}
		$url = $this->submodules[$path];
		$this->out("\nAdding ".Inflector::humanize($path)." Submodule...\n");
		exec('git submodule add ' . $url . ' plugins/' . $path);
	}

	/**
	 * Render a list of submodules
	 */
	function browse() {
		$this->_load();
		$this->out("\nAvailable Plugins:\n");
		$i = 0;
		foreach ($this->submodules as $path => $url) {
			$i++;
			$this->out($i . ') ' . Inflector::humanize($path));
		}
	}

	/**
	 * Add all submodules
	 */
	function all() {
		if (isset($this->args[0])) {
			$this->params['group'] = $this->args[0];
		}
		$this->_load();
		$this->out("\nAdding All Git Submodules...\n");
		foreach ($this->submodules as $path => $url) {
			$this->out($this->nl().'====================================');
			$this->out('Adding ' . Inflector::humanize($path));
			$this->out($this->hr());
			exec('git submodule add ' . $url . ' plugins/' . $path);
		}
	}
}