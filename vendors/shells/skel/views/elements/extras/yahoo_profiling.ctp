
  <!-- todo: make this configurable bootstrap|db only if admin? whats the best
            it needs to use html->script and find in theme
	yui profiler and profileviewer - remove for production -->
  <?php
	  // no point in compressing this
	  echo $this->Html->script(array('profiling/yahoo-profiling.min', 'profiling/config'));
  ?>
  <!-- end profiling code -->