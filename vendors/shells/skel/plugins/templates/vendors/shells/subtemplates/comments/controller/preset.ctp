<?php 
/**
 * Copyright 2005-2010, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2005-2010, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

if (!empty($template->templateVars['components'])) {
	$components = $template->templateVars['components'];
} else {
	$components = $template->templateVars['components'] = array();
}
$components[] = 'Comments.Comments';
$template->set('components', $components);

?>