<?php
/**
* BakingPlate Class
*/
class PlateShell extends Shell {
	
	function _load() {
		Configure::load('BakingPlate.submodules');
		return Configure::read('BakingPlate.plugins');
	}
	
	function main() {
		$this->out("\nAvailable Commands:");
		$this->out('Index	- List available plugins');
		$this->out('Add <#>	- Add a specific plugin');
		$this->out('All	- Add all available plugins');
	}
	
	function add($plugin = null) {
		$plugins = $this->_load();
		$keys = array_keys($plugins);
		if (!isset($keys[$plugin-1])) {
			$this->out("\nPlease specify a valid plugin");
			$this->plugins();
			return;
		}
		$path = $plugins[$keys[$plugin-1]];
		$url = $plugins[$path];
		$this->out("\nAdding ".Inflector::humanize($plugin['path'])." Submodule...\n");
		exec('git submodule add ' . $url . ' plugins/' . $path);
	}
	
	function plugins() {
		$plugins = $this->_load();
		$this->out("\nAvailable Plugins:\n");
		$i = 0;
		foreach ($plugins as $path => $url) {
			$i++;
			$this->out($i . ') ' . Inflector::humanize($path));
		}
	}
	
	function all() {
		$plugins = $this->_load();
		$this->out("\nAdding All Git Submodules...\n");
		foreach ($plugins as $path => $url) {
			$this->out("\n".'====================================');
			$this->out('Adding ' . Inflector::humanize($path));
			$this->out('------------------------------------');
			exec('git submodule add ' . $url . ' plugins/' . $path);
		}
	}
}