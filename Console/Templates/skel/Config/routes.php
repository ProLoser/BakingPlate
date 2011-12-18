<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Parse common extensions...
 */
Router::parseExtensions('json', 'xml', 'rss', 'ajax');
 
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
Router::connect('/login', array('admin' => false, 'controller' => 'users', 'action' => 'login'));
Router::connect('/logout', array('admin' => false, 'controller' => 'users', 'action' => 'logout'));

/*
 * Localization
 *#!#/
App::import('Lib', 'LocalizedRouter');
LocalizedRouter::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
LocalizedRouter::localize();
/*^*/

/*
 * Asset Compress
 *#!#*/
Router::connect('/ccss/*', array(
        'plugin' => 'asset_compress',
        'controller' => 'assets',
        'action' => 'get'));
Router::connect('/cjs/*', array(
        'plugin' => 'asset_compress',
        'controller' => 'assets',
        'action' => 'get'));
/*^*/

/**
 * Load all plugin routes.  See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';


/*
 * PageRoute
 *#!#/        
App::uses('PageRoute', 'PageRoute.Lib');
Router::connect('/:page', array('controller' => 'pages', 'action' => 'display'),
    array('routeClass' => 'PageRoute')
);
/*^*/
