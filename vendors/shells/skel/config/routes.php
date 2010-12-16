<?php
/**
 * Routes Configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
Router::parseExtensions('json', 'xml');
 
$routes = array(
	array('/', array('controller' => 'pages', 'action' => 'display', 'home')),
	array('/admin', array('admin' => true, 'controller' => 'pages', 'action' => 'display', 'admin_home')),
);

// Maps a locale route to each individual route
$default = Configure::read('Config.language');
$locale = '(?!js|css|img)[a-zA-Z]{2,3}(?<!js|css|img)';

foreach ($routes as $route) {
	// $route[1]['locale'] = $default; // Sets the default to use if no locale
	if (!isset($route[1])) $route[1] = array(); // only used because above is commented out
	$route[2]['locale'] = $locale;
	Router::connect('/:locale' . $route[0], $route[1], $route[2]);
	Router::connect($route[0], $route[1], $route[2]);
}

Router::connect('/:locale/:controller', array('action' => 'index'), array('locale' => $locale));
Router::connect('/:locale/:controller/:action/*', array(), array('locale' => $locale));