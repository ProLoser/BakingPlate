<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after the core bootstrap.php
 *
 * This is an application wide file to load any function that is not used within a class
 * define. You can also use this to include or require any files in your application.
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
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

Configure::write('Languages.default', 'en');
$languages = array(
	'en',
	'sp',
	'fr',
	'de',
	'jp',
	'ch',
);
Configure::write('Languages.all', $languages);


/**
 * BakingPlate: Settings 
 */
//Configure::write('Site.Themes.Default', 'h5bp');
//Configure::write('Site.Themes.Mobile', 'h5bp');

Configure::write('Site.Name', 'Example');
Configure::write('Site.Title', 'An Example');
Configure::write('Site.subTitle', 'served by BakingPlate');
//Configure::write('Site.Domains.Default', 'example.com');
//Configure::write('Site.Domains.Mobile', 'm.example.com');
//Configure::write('Site.Domains.Cdn', 'static.example.com');
Configure::read('Site.Author', 'Sam Sherlock & Dean Sofer');


/**
 * Cdn Fallback
 * defaults to jquery and the latest stable version is used
 * uncomment the lib cfg and change to WTFYL - make sure that the version
 * is correct for the lib you change to no magic handles this - unless you are
*/
$defaultJsLib = array(
        'cdn' => 'Google',
        'name' => 'jQuery',
        'version' => '1.5.1',
        'compressed' => true
);
Configure::write('Site.JsLib.Default', $defaultJsLib);

/**
 * Google Analytics
 * leave as false to not use GA but your mad set to site id to use boilerplate hotness eg: UA-XXXXX-X
 * debug turns it off anyway
 */ 
//Configure::write('Site.GoogleAnalytics', 'UA-8765-192');

// Configure::write('Site.FavIconUrl', '/img/myicon.ico');
// Configure::write('Site.AppleIconUrl', '/img/myapple-image.png');

/**
 * Additional Plugins Setup
 * here is where you can add additional config for no core plugins
 * core to BakingPlate that is
 */

/* contact plugin settings */
Configure::write('App.UserClass', 'AppUser');
Configure::write('Contact.email', 'hello@example.com');
Configure::write('WebmasterTools.maintenanceMode', false);

/**
 *
 *  Webmaster Tools
 *
 */
//require APP . 'plugins/webmaster_tools/config/core.php';


/**
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 * App::build(array(
 *     'plugins' => array('/full/path/to/plugins/', '/next/full/path/to/plugins/'),
 *     'models' =>  array('/full/path/to/models/', '/next/full/path/to/models/'),
 *     'views' => array('/full/path/to/views/', '/next/full/path/to/views/'),
 *     'controllers' => array(/full/path/to/controllers/', '/next/full/path/to/controllers/'),
 *     'datasources' => array('/full/path/to/datasources/', '/next/full/path/to/datasources/'),
 *     'behaviors' => array('/full/path/to/behaviors/', '/next/full/path/to/behaviors/'),
 *     'components' => array('/full/path/to/components/', '/next/full/path/to/components/'),
 *     'helpers' => array('/full/path/to/helpers/', '/next/full/path/to/helpers/'),
 *     'vendors' => array('/full/path/to/vendors/', '/next/full/path/to/vendors/'),
 *     'shells' => array('/full/path/to/shells/', '/next/full/path/to/shells/'),
 *     'locales' => array('/full/path/to/locale/', '/next/full/path/to/locale/')
 * ));
 *
 */

/**
 * As of 1.3, additional rules for the inflector are added below
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */