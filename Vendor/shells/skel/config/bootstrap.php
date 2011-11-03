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
 */


/**
 * Translation and Localization
 *#!#/
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
/*^*/


/**
 * debug() + die() goodness
 */
function diebug($var = false, $showHtml = true, $showFrom = true, $die = true) {
	if (Configure::read() > 0) {
		$file = '';
		$line = '';
		if ($showFrom) {
			$calledFrom = debug_backtrace();
			$file = substr(str_replace(ROOT, '', $calledFrom[0]['file']), 1);
			$line = $calledFrom[0]['line'];
		}
		$html = <<<HTML
<strong>%s</strong> (line <strong>%s</strong>)
<pre class="cake-debug">
%s
</pre>
HTML;
		$text = <<<TEXT

%s (line %s)
########## DEBUG ##########
%s
###########################

TEXT;
		$template = $html;
		if (php_sapi_name() == 'cli') {
			$template = $text;
		}
		if ($showHtml === null && $template !== $text) {
			$showHtml = true;
		}
		$var = print_r($var, true);
		if ($showHtml && php_sapi_name() != 'cli') {
			$var = str_replace(array('<', '>'), array('&lt;', '&gt;'), $var);
		}
		printf($template, $file, $line, $var);
		if ($die) die;
	}
}