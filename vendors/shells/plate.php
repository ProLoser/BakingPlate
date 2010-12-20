<?php
/**
* BakingPlate Class
*/
class PlateShell extends Shell {
	
	/**
	 * Loads the list of submodules from config
	 *
	 * @return array submodules
	 * @author Dean Sofer
	 */
	function _load() {
		Configure::load('BakingPlate.submodules');
		return Configure::read('BakingPlate.plugins');
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
		$this->out('plugins	- List available plugins');
		$this->out('add <#>	- Add a specific plugin');
		$this->out('all	- Add all available plugins');
	}
	
	/**
	 * Add a specific submodule/plugin
	 *
	 * @return void
	 * @author Dean Sofer
	 */
	function add() {
		$plugins = $this->_load();
		$keys = array_keys($plugins);
		if (!isset($this->args[0])) {
			$this->plugins();
			$this->out($this->nl());
			$plugin = $this->in('Specify a plugin #');
		} else {
			$plugin = $this->args[0];
		}
		
		$path = $keys[$plugin-1];
		$url = $plugins[$path];
		$this->out("\nAdding ".Inflector::humanize($path)." Submodule...\n");
		exec('git submodule add ' . $url . ' plugins/' . $path);
	}
	
	/**
	 * Render a list of submodules
	 */
	function plugins() {
		$plugins = $this->_load();
		$this->out("\nAvailable Plugins:\n");
		$i = 0;
		foreach ($plugins as $path => $url) {
			$i++;
			$this->out($i . ') ' . Inflector::humanize($path));
		}
	}
	
	/**
	 * Add all plugins
	 */
	function all() {
		$plugins = $this->_load();
		$this->out("\nAdding All Plugins...\n");
		foreach ($plugins as $path => $url) {
			$this->out($this->nl());
			$this->out('Adding ' . Inflector::humanize($path));
			$this->hr();
			exec('git submodule add ' . $url . ' plugins/' . $path);
		}
	}
}