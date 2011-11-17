<?php
/**
* BakingPlate Class
*/
class PlateShell extends AppShell {

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
		$this->clear();
		$this->out("\nWelcome to BakingPlate");
		$this->hr();
		$this->_loadCustom();
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
		$this->out('search <term>			- Search CakePackages.com');
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
		if (!isset($this->params['skel'])) {
			$this->params['skel'] = $this->_pluginPath('BakingPlate') . 'vendors' . DS . 'shells' . DS . 'skel ' . implode(' ', $this->args);
		}
		$working = $this->params['working'];
		if (!$this->Project->execute()) {
			return;
		}
		$this->nl();
		$this->out('Making temp folders writeable...');
		$tmp = array(
			'tmp', 'tmp'.DS.'cache', 'tmp'.DS.'cache'.DS.'models', 'tmp'.DS.'cache'.DS.'persistent', 'tmp'.DS.'cache'.DS.'views', 
			'tmp'.DS.'logs', 'tmp'.DS.'sessions', 'tmp'.DS.'tests',
			'webroot'.DS.'ccss', 'webroot'.DS.'cjs', 'webroot'.DS.'uploads',
		);
		foreach ($tmp as $dir) {
			$this->out($this->params['app'] . DS . $dir);
			$this->nl();
			chmod($this->params['app'] . DS . $dir, 0777);
		}

		$this->nl();
		chdir($this->params['app']);
		$this->out(passthru('git init'));
		$this->all();
		
		$this->DbConfig->path = $working . DS . $this->params['app'] . DS . 'config' . DS;
		if (!config('database')) {
			$this->out(__("\nYour database configuration was not found. Take a moment to create one."));
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
	 * Search CakePackages.com for a package. Extra functionality to come later
	 *
	 */
	function search() {
		$install = false;

		if (!isset($this->args[0])) {
			$this->args[0] = $this->in("\nSearch Packages for:");
			if (empty($this->args[0])) {
				return;
			}
		}
		App::uses('HttpSocket', 'Network/Http');

		$Http = new HttpSocket();

		$Response = $Http->request('http://cakepackages.com/1/search/' . urlencode($this->args[0]));

		if (!$Response->isOk()) {
			$this->out("\n<error>Search requires an active internet connection</error>");
			return;
		}
		$data = json_decode($Response->body, true);
		
		$this->out("\n<info>Found ({$data['count']}) Search Results:</info>");
		$i = 0;
		$packages = array();
		foreach ($data['results'] as $package) {
			$i++;
			$this->out("\n{$package['id']}) <warning>{$package['name']}</warning> by {$package['data']['Maintainer.name']}: <comment>{$package['summary']}</comment>");
			$packages[$package['id']] = $package['data']['Package.repository_url'];
		}
		if ($data['count'] == 1) {
			$install = $data['results'][0]['id'];
		} elseif ($data['count'] > 1) {
			$install = $this->in("\nWhich package ID# would you like to install?");
		}
		if ($install) {
			$folder = $this->in("\nPlease enter the plugin folder name");
			if (!empty($folder)) {
				$this->_install($packages[trim($install)], 'Plugin' . DS . $folder);
			}
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
		} elseif (!isset($this->params['group'])) {		
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
	 * Loads in a custom configuration file if passed
	 *
	 * @return void
	 * @author Dean Sofer
	 */
	protected function _loadCustom() {
		if (isset($this->params['c'])) {
			$this->params['custom'] = $this->params['c'];
		}
		if (isset($this->params['custom'])) {
			$custom = $this->params['custom'];
			$name = pluginSplit($custom);
			if (!Configure::load($custom)) {
				$this->out("ERROR: Failed to load custom configuration '{$custom}'\n");
				return;
			}
			$data = Configure::read('BakingPlate');
			if (isset($data['skel'])) {
				$this->params['skel'] = $data['skel'];
				unset($data['skel']);
			}
			$this->submodules = array_merge($this->submodules, $data);
			$this->out("Custom configuration '{$custom}' loaded\n");
		}
	}
	
	/**
	 * Adds a submodule via git
	 *
	 * @param string $path 
	 * @param string $url 
	 * @return void
	 * @author Dean Sofer
	 */
	protected function _addSubmodule($path) {
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
		$this->_install($url, $folder . DS . $path);
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
	
	protected function _install($url, $folder) {
		$this->out("\n===============================================================");
		$this->out("Adding {$url} to {$folder}");
		$this->hr();
		exec("git submodule add {$url} {$folder}");
	}
}
