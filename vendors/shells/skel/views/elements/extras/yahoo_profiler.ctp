<?php 
/* TODO: make this configurable bootstrap|db only if admin? whats the best
            it needs to use html->script and find in theme
			yui profiler and profileviewer - remove for production */
if (Configure::read('Site.profiler')) {
	echo $this->Html->script(array(
		'profiling/yahoo-profiling.min', 
		'profiling/config',
	));
}
?>