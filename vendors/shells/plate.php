<?php
/**
* BakingPlate Class
*/
class PlateShell extends Shell {
	var $tasks = array('Project', 'DbConfig', 'Plugin');
	function main() {
		$this->out('Testing'."\n");
	}
}
