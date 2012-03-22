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
	
	public function getOptionParser() {
		$options = array(
			'working' => array(
				'short' => 'w',
				'help' => __('Set working directory for project to be baked in.'),
				'boolean' => false
			),
			'skel' => array(
				'short' => 's',
				'help' => __('Skel to bake from.'),
				'boolean' => false,
				'default' => $this->_pluginPath('BakingPlate') . 'Console' . DS . 'Templates' . DS . 'skel',
			),
			'config' => array(
				'short' => 'c',
				'help' => __('Config file of submodules to bake into project.'),
				'boolean' => false
			),
			'group' => array(
				'short' => 'g',
				'help' => __('Specify a group of submodules, or core will be used.'),
				'boolean' => false,
			),
		); // Hello, 24 m usa here looking for an intelligent girl with a freaky fantasy
		return ConsoleOptionParser::buildFromArray(array(
			'command' => 'plate',
			'description' => __('BakingPlate Plate Shell Help.'),
			'options' => array(
				'group' => $options['group'],
				'config' => $options['config']
			),
			'subcommands' => array(
				'init' => array(
					'help' => __('Initializes BakingPlate tweaks onto an existing project'),
					'parser' => array(
						'description' => array(__('Initializes a git repository'),__('Makes necessary folders writeable'),__('Adds core (or specified) plugins to the project')),
						'options' => array(
							'config' => $options['config'],
							'group' => $options['group'],
						),
					)
				),
				'bake' => array(
					'help' => __('Generates a new app using bakeplate.'),
					'parser' => array(
						'description' => __('The plate shell will bake a project from a skel. It will then add submodules and set permissions on folders.'),
						'options' => array(
							'working' => $options['working'],
							'skel' => $options['skel'],
							'config' => $options['config'],
							'group' => array_merge(array('default' => 'core'), $options['group']),
						),
						'arguments' => array(
							'working' => array(

							),
						),
					),
				),
				'browse' => array(
					'help' => __('List available submodules.'),
					'parser' => array(
						'description' => __('Browse listed submodules (or groups of submodules) via name or index number.'),
						'options' => array(
							'group' => $options['group'],
							'config' => $options['config'],
						),
						'arguments' => array(
							'group' => array(
								'help' => __('name or number of group.'),
								'required' => false
							),
						),
					),
				),
				'add' => array(
					'help' => __('Add specific submodule.'),
					'parser' => array(
						'description' => __('Add individual plugins as submodules to your project'),
						'options' => array(
							'group' => $options['group']
						),
						'arguments' => array(
							'submodule' => array(
								'help' => __('Submodule to be added.'),
								'required' => true
							)
						),
					),
				),
				'all' => array(
					'help' => __('All submodules in a specified batch group'),
					'parser' => array(
						'description' => __('All submodules in a specified batch group'),
						'options' => array(

						),
						'arguments' => array(

						),
					),
				),
				'search' => array(
					'help' => __('Search for a specific submodule to install from CakePackages.com'),
					'parser' => array(
						'description' => __('Search <info>cakepackages.com</info> for Vendors or Plugins to add as submodules to Application'),
						'options' => array(

						),
						'arguments' => array(
							'term' => array(
								'help' => __('Search for a Cake Package to be add.'),
								'required' => true
							),
						),
					),
				),
			),
		));
	}

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
	 * Initializes git, makes tmp folders writeable, and adds the core submodules (or specified group)
	 *
	 * @return void
	 */
	function init() {
		$this->out("\n<info>Making temp folders writeable...</info>");
		$tmp = array(
			'tmp', 'tmp'.DS.'cache', 'tmp'.DS.'cache'.DS.'models', 'tmp'.DS.'cache'.DS.'persistent', 'tmp'.DS.'cache'.DS.'views', 
			'tmp'.DS.'logs', 'tmp'.DS.'sessions', 'tmp'.DS.'tests',
			'webroot'.DS.'ccss', 'webroot'.DS.'cjs', 'webroot'.DS.'uploads',
		);
		foreach ($tmp as $dir) {
			if (is_dir($working . DS . $dir)) {
				$this->out($dir);
				chmod($working . DS . $dir, 0777);
			}
		}
		
		$this->nl();
		chdir($working);
		$this->out();
		$this->out(passthru('git init'));
		$this->all();
		
		$this->args = null;
		if (!file_exists($working . 'Config' . DS . 'database.php')) {
			$this->DbConfig->path = $working . 'Config' . DS;
			$this->out();
			$this->out(__d('baking_plate', '<warning>Your database configuration was not found. Take a moment to create one.</warning>'));
			$this->DbConfig->execute();
		}
		
	}

	/**
	 * Generates a new project with a little bit of added fluff
	 *
	 * @return void
	 */
	function bake() {
		$working = $this->Project->execute();
		if (!$working) {
			return;
		}
		$this->init();
	}

	/**
	 * Add a specific submodule/plugin
	 *
	 * @return void
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
			if($this->args[0] == 'all' && isset($this->params['group'])) {
				$submodule = array_keys($this->submodules[$this->params['group']]);
			} else {
				$submodule = (strpos($this->args[0], ',') !== false) ? explode(',', $this->args[0]) : $this->args[0];
			}
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
			$this->out("\n{$package['id']}) <warning>{$package['name']}</warning> by {$package['data']['Maintainer.name']} <comment>{$package['data']['Package.repository_url']}</comment>");
			$this->out("{$package['summary']}");
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
		if(isset($this->args[0])) {
			$this->params['group'] = $this->args[0];
		}
		if (!isset($this->params['group'])) {
			$this->out("\n<info>Available Groups:</info>\n");
			$i = 0;
			$this->out('#) All');
			foreach ($this->submodules as $group => $items) {
				$i++;
				$this->out($i . ') ' . Inflector::humanize($group));
			}
		} else {
			$this->_prepGroup();
			$this->out("\n<info>Available Submodules:"  . Inflector::humanize($this->params['group']) . "</info>\n");
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
		if (isset($this->args[0]) && !isset($this->params['group']) && array_key_exists($this->args[0], $this->submodules)) {
			$this->params['group'] = $this->args[0];
		} elseif (!isset($this->params['group'])) {		
			$this->browse();
			$this->params['group'] = $this->in('Specify a group name or #');
			$this->_prepGroup();
		}
		$this->out("\n<info>Adding {$this->params['group']} git submodules...</info>");
		
		$submodules = $this->_getSubmodules();
		foreach ($submodules as $path => $url) {
			$this->_addSubmodule($path);
		}
	}
	
	/**
	 * Loads in a custom configuration file if passed
	 *
	 * @return void
	 */
	protected function _loadCustom() {
		if (isset($this->params['config'])) {
			$config = $this->params['config'];
			$name = pluginSplit($config);
			if (!Configure::load($config)) {
				$this->out("<error>Failed to load custom configuration '{$config}'</error>\n");
				return;
			}
			$data = Configure::read('BakingPlate');
			if (isset($data['skel'])) {
				$this->params['skel'] = $data['skel'];
				unset($data['skel']);
			}
			$this->submodules = array_merge($this->submodules, $data);
			$this->out("<info>Custom configuration '{$config}' loaded</info>\n");
		}
	}
	
	/**
	 * Adds a submodule via git
	 *
	 * @param string $path 
	 * @param string $url 
	 * @return void
	 */
	protected function _addSubmodule($path) {
		$submodules = $this->_getSubmodules();
		if (is_numeric($path)) {
			$items = array_keys($submodules);
			if (isset($submodules[$items[$path-1]])) {
				$url = $submodules[$items[$path-1]];
				$path = $items[$path-1];
			}
		} elseif (isset($submodules[$path])) {
			$url = $submodules[$path];
		} 
		if (!isset($url)) {
			$this->out('<error>Submodule not found</error>');
			return false;
		}
		$folder = (isset($this->submodules['vendors'][$path])) ? 'Vendor': 'Plugin';
		$this->_install($url, $folder . DS . Inflector::camelize($path));
	}
	
	/**
	 * Method used to prep the group argument
	 * Converts -g short-param to -group and converts number to group name
	 *
	 * @return void
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
	 */
	protected function _getSubmodules() {
		if (strtolower($this->params['group']) === 'all') {
			$submodules = array();
			foreach ($this->submodules as $items) {
				$submodules = array_merge($submodules, $items);
			}
		} else {
				$this->_prepGroup();
				$submodules = $this->submodules[inflector::underscore($this->params['group'])];
		}
		return $submodules;
	}
	
	/**
	 * Installs a submodule into the project
	 *
	 * @param string $url 
	 * @param string $folder
	 * @return void
	 */
	protected function _install($url, $folder) {
		$os = env('OS');
		if (!empty ($os) && strpos($os, 'Windows') !== false) {
				$folder = str_replace("\\", "/", $folder);
		}
		$this->out("\n<info>Adding {$url} to {$folder}</info>");
		exec("git submodule add {$url} {$folder}");
	}
}
