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
 * Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

Configure::write('Languages.default', 'us');
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
 * Using site (lowercase for bootstrap set cfg)
 * and Site for configured db settings
 * by default using either Cofiguration by WebTechNick
 * or Settings by Jose G
 */

Configure::write('site.Name', 'samsherlock.com');
Configure::write('site.Title', 'SamSherlock.com');
Configure::write('site.subTitle', 'served by BakingPlate');
Configure::write('site.Domain', 'samsherlock.ss33');
Configure::read('site.Author', 'Sam Sherlock & Dean Sofer');

/**
 * Theme
 * default theme gets swtiched to; later you can add a mobile theme also for use
 * with mobile detection plugin - which may have a helper to assist in manking
 * themes mobile friendly - mobile detection will use multiple domains
 * this will enable caching of distinct mark up and means that other concepts such as
 * l10n/i18n will still function
 * 
*/
//Configure::write('site.DefaultTheme', 'h5bp');

/**
 * StaticCache
 * a plugin based upon Matt Curry's html_cache that is minor reworked to handle
 * non html files (his plugin now does this might go back to that if it works with mobile dection plugin)
*/
Configure::write('site.StaticCache', false);

/**
 * Cdn Fallback
 * defaults to jquery and the latest stable version is used
 * uncomment the lib cfg and change to WTFYL - make sure that the version
 * is correct for the lib you change to no magic handles this - unless you are
*/
// Configure::write('site.JsLib.lib', 'jquery');
Configure::write('site.JsLib.version', '1.5');

/**
 * YahooProfiler
 * an in browser profiling tool - your better of using something more adept
 * to the task - external to browser IMHO; or browser plugin
*/ 
Configure::write('site.YahooProfiler', false);

/**
 * Google Analytics
 * leave as false to not use GA but your mad set to site id to use boilerplate hotness eg: UA-XXXXX-X
 * debug turns it off anyway
 */ 
Configure::write('site.GoogleAnalytics', false);

/**
 * Chrome Frame
 * use or not chromeframe meta (you may have a corresponding setting in Apaceh Conf or htaccess)
 *
 * either the meta or the htaccess/conf directive renders chrome within IE; if the machine is able to
 */
Configure::write('site.ChromeFrame', false);

/**
 * Favions etc
 * favicon and apple icon - uncomment and change the urls to what you want 
*/
// Configure::write('site.FavIconUrl', '/img/myicon.ico');
// Configure::write('site.AppleIconUrl', '/img/myapple-image.png');

/**
 * Drew Diller
 * awesome fixes for IEs crappiness (M$ employed him I hope); he is worth it for humourlet alone skill
 * roundies currently notimplemented
*/
// Configure::write('site.DrewDillerPng', 'img, .png');
// Configure::write('site.DrewDillerRoundies', true);

/**
 * Additional Plugins Setup
 * here is where you can add additional config for no core plugins
 * core to BakingPlate that is
 */

/* contact plugin settings */
Configure::write('Contact.email', 'hello@example.org');


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