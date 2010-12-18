<table>
  <?php
    foreach($results as $result) {
      echo '<strong>' . $result['cmd'] . '</strong><br />';
      if(is_array($result['output'])) {
				if(empty($result['output'])) {
					__('No results found.');
				} else {
					echo $toolbar->makeNeatArray($result['output']);
				}
      } else {
        if(is_bool($result['output'])) {
          $result['output'] = ife($result['output'], 'true', 'false');
        }

				if($result['raw']) {
					echo htmlentities($result['output']) . '<br />';
				}
				
        echo $result['output'] . '<br /><br />';
      }
    }
  ?>
</table>