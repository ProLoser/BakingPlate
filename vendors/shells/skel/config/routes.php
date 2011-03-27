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
Router::parseExtensions('json', 'xml', 'rss', 'ajax');
 
Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));

/*
 * Want localization instead?
 *
App::import('Lib', 'LocalizedRouter');

LocalizedRouter::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));

LocalizedRouter::localize();
 */


/**
 * Users Plugin routes not all are required the first set are to route to the app native user model & controller
 *
 * the next set is temp set up for shortened route to connect to the plugin
 *
 * neither sets are currenly working
 */
Router::connect('/users/:action/*', array('controller' => 'app_users'));

Router::connect('/admin/users/:action/*', array('prefix' => 'admin', 'admin' => true, 'controller' => 'app_users'));

/**
 * Asset Compress
 */
Router::connect('/ccss/*', array('plugin' => 'asset_compress', 'controller' => 'css_files', 'action' => 'get'));
Router::connect('/cjs/*', array('plugin' => 'asset_compress', 'controller' => 'js_files', 'action' => 'get'));


/**
 * Webmaster Tools
 */
require APP . 'plugins/webmaster_tools/config/routes.php';
