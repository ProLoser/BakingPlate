<?php
/**
* BakingPlate Plugin Task
*
* I have found that with BakingPlate installed we can no longer bake plugins
* and I suspect this task is to blame due to conflict.
*
* anyway this task is *should* IMHO be renamed GitPlugins - since it installs via git
* and another Task later will install via another method or may (investigate the first point)
* 
*/
class PluginTask extends Shell {
	
	var $plugins = array();
	
	function execute($param = null) {
		Configure::load('BakingPlate.submodules');
		$this->plugins = Configure::read('BakingPlate.plugins');
		if (!$param) {
			$this->out("\nAvailable Commands:");
			$this->out('Index	- List available plugins');
			$this->out('Add <#>	- Add a specific plugin');
			$this->out('All	- Add all available plugins');
		} elseif (method_exists($this, $param)) {
			$params = func_get_args();
			array_shift($params);
			call_user_func(arary($this, $param), $params);
		}
	}
	
	function add($plugin = null) {
		$this->plugins = $this->_load();
		$keys = array_keys($this->plugins);
		$path = $this->plugins[$keys[$plugin-1]];
		$url = $this->plugins[$path];
		$this->out("\nAdding ".Inflector::humanize($plugin['path'])." Submodule...\n");
		exec('git submodule add ' . $url . ' plugins/' . $path);
	}
	
	function index() {
		$this->out("\nAvailable Plugins:\n");
		$i = 0;
		foreach ($this->plugins as $path => $url) {
			$i++;
			$this->out($i . ') ' . Inflector::humanize($path));
		}
	}
	
	function all() {
		$this->plugins = $this->_load();
		$this->out("\nAdding All Git Submodules...\n");
		foreach ($this->plugins as $path => $url) {
			$this->out("\n".'====================================');
			$this->out('Adding ' . Inflector::humanize($path));
			$this->out('------------------------------------');
			exec('git submodule add ' . $url . ' plugins/' . $path);
		}
	}
}