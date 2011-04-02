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
 * Users Plugin routes
 */
Router::connect('/users/:action/*', array('controller' => 'app_users'));

Router::connect('/admin', array('controller' => 'pages', 'action' => 'index', 'admin' => true));
Router::connect('/admin/users/', array('prefix' => 'admin', 'controller' => 'app_users', 'action' => 'index'));
Router::connect('/admin/users/index', array('prefix' => 'admin', 'controller' => 'app_users', 'action' => 'index'));
Router::connect('/admin/users/:action/*', array('prefix' => 'admin', 'controller' => 'app_users'));

/**
 * Asset Compress
 */
Router::connect('/cache_css/*', array('plugin' => 'asset_compress', 'controller' => 'css_files', 'action' => 'get'));
Router::connect('/cache_js/*', array('plugin' => 'asset_compress', 'controller' => 'js_files', 'action' => 'get'));

//App::import('Lib', 'routes/PageRoute');
//Router::connect('/:slug', array('controller' => 'pages', 'action' => 'view'), array('routeClass' => 'PageRoute'));
//Router::connect('/', array('controller' => 'pages', 'action' => 'view'));

/**
 * Webmaster Tools
 */
//require APP . 'plugins/webmaster_tools/config/routes.php';
