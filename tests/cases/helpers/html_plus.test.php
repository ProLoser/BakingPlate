<?php
/* HtmlPlus Test cases generated on: 2011-01-11 02:01:20 : 1294713320 ~ altered test of core test for html helper */
/**
 * HtmlPlusHelperTest file
 *
 * @author	  Sam Sherlock <hell@samsherlock.com>
 * @package       plate_plus
 * @subpackage    plate_plus.tests.cases.libs.view.helpers
 * @since         v 0.0.1a
 * @license       http://www.opensource.org/licenses/opengroup.php The Open Group Test Suite License
 *
 * based on helper test by Cake Software Foundation
 * PHP versions 4 and 5
 *
 * CakePHP(tm) Tests <http://book.cakephp.org/view/1196/Testing>
 * Copyright 2006-2010, Cake Software Foundation, Inc.
 *
 *  Licensed under The Open Group Test Suite License
 *  Redistributions of files must retain the above copyright notice.
 */
App::import('Core', array('Helper', 'AppHelper', 'ClassRegistry', 'Controller', 'Model', 'Folder'));
App::import('Helper', array('PlatePlus.HtmlPlus', 'PlatePlus.FormPlus'));

if (!defined('FULL_BASE_URL')) {
	define('FULL_BASE_URL', 'http://cakephp.org');
}

if (!defined('TEST_APP')) {
	define('TEST_APP', APP . 'tests' . DS . 'test_app' . DS);
	//die(TEST_APP);
}

if (!defined('JS')) {
	define('JS', TEST_APP . 'webroot' . DS . 'js' . DS);
}

if (!defined('CSS')) {
	define('CSS', TEST_APP . 'webroot' . DS . 'css' . DS);
}

if (!defined('THEME')) {
	define('THEME', TEST_APP . 'webroot' . DS . 'theme' . DS);
}

//die(TEST_APP);

/**
 * TheHtmlTestController class
 *
 * @package       plate_plus
 * @subpackage    plate_plus.tests.cases.libs.view.helpers
 */
if(!class_exists('TheHtmlTestController')) {
	class TheHtmlTestController extends Controller {
		/**
		 * name property
		 *
		 * @var string 'TheTest'
		 * @access public
		 */
		var $name = 'TheTest';
	
		/**
		 * uses property
		 *
		 * @var mixed null
		 * @access public
		 */
		var $uses = null;
	}
}

Mock::generate('View', 'HtmlHelperMockView');

/**
 * HtmlHelperTest class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.view.helpers
 */

class HtmlPlusHelperTestCase extends CakeTestCase {
/**
 * Regexp for CDATA start block
 *
 * @var string
 */
	var $cDataStart = 'preg:/^\/\/<!\[CDATA\[[\n\r]*/';
/**
 * Regexp for CDATA end block
 *
 * @var string
 */
	var $cDataEnd = 'preg:/[^\]]*\]\]\>[\s\r\n]*/';
/**
 * html property
 *
 * @var object
 * @access public
 */
	var $Html = null;

/**
 * Backup of app encoding configuration setting
 *
 * @var string
 * @access protected
 */
	var $_appEncoding;

/**
 * Backup of asset configuration settings
 *
 * @var string
 * @access protected
 */
	var $_asset;

/**
 * Backup of debug configuration setting
 *
 * @var integer
 * @access protected
 */
	var $_debug;

/**
 * setUp method
 *
 * @access public
 * @return void
 */
	function startTest() {
		$this->Html =& new HtmlPlusHelper();
		$view =& new View(new TheHtmlTestController());
		ClassRegistry::addObject('view', $view);
		$this->_appEncoding = Configure::read('App.encoding');
		$this->_asset = Configure::read('Asset');
		$this->_debug = Configure::read('debug');
		App::import('Core', 'Folder');
		$Folder = new Folder();
		$Folder->create(JS);
		
		$Folder = new Folder();
		$Folder->create(CSS);
		
		$Folder = new Folder();
		$Folder->create(THEME);
	}

/**
 * endTest method
 *
 * @access public
 * @return void
 */
	function endTest() {
		Configure::write('App.encoding', $this->_appEncoding);
		Configure::write('Asset', $this->_asset);
		Configure::write('debug', $this->_debug);
		ClassRegistry::flush();
		App::import('Core', 'Folder');
		unset($this->Html);
	}

/**
 * testDocType method
 *
 * @access public
 * @return void
 */
	function testDocType() {
		$result = $this->Html->docType();
		$expected = '<!doctype html>';
		$this->assertEqual($result, trim($expected), 'default doctype');

		$result = $this->Html->docType('html4-strict');
		$expected = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
		$this->assertEqual($result, $expected);

		$result = $this->Html->docType('html5');
		$expected = '<!doctype html>';
		$this->assertEqual($result, $expected, 'html5 doctype');
		$this->assertNull($this->Html->docType('non-existing-doctype'));
	}
/**
 * testStart method
*/
	function testStart() {
		$resultEn = $expectedEn = '';
		$settings = array();
		$result = $this->Html->start($settings);
		$expected = '<!doctype html><html><head><meta charset="utf-8">';
		$result = str_replace(array("\n", "\r"), '', $result);
		echo "<pre>".htmlspecialchars($expected)."</pre>";
		echo "<pre>".htmlspecialchars($result)."</pre>";
		$this->assertEqual($result, $expected, 'no settings passed');
/**
 * html5
*/
		
		$settings = array();
		$settings['docType'] = 'html5';
		$settings['lang'] = false;
		$result = $this->Html->start($settings);
		$result = str_replace(array("\n", "\r"), '', $result);
		$expected = '<!doctype html><html><head><meta charset="utf-8">';
		$this->assertEqual($result, $expected, 'html5 lang false');
		
		$settings = array();
		$settings['docType'] = 'html5';
		$settings['manifest'] = 'example';
		$settings['lang'] = 'en-gb';
		$result = $this->Html->start($settings);
		$result = str_replace(array("\n", "\r"), '', $result);
		$expected = '<!doctype html><html manifest="/manifests/example.manifest" lang="en-gb"><head><meta charset="utf-8">';
		echo "<pre>".htmlspecialchars($expected)."</pre>";
		echo "<pre>".htmlspecialchars($result)."</pre>";
		$this->assertEqual($result, $expected, 'html5 with extras');
		
		$settings = array();
		$settings['docType'] = 'html5';
		$settings['multihtml'] = true;
		$settings['lang'] = 'en-gb';
		$result = $this->Html->start($settings);
		$result = str_replace(array("\n", "\r"), '', $result);
		$expected = '<!doctype html><!--[if lt IE 7 ]> <html lang="en-gb" class="no-js ie6"> <![endif]--><!--[if IE 7 ]> <html lang="en-gb" class="no-js ie7"> <![endif]--><!--[if IE 8 ]> <html lang="en-gb" class="no-js ie8"> <![endif]--><!--[if (gte IE 9)|!(IE) ]><!--> <html lang="en-gb" class="no-js"> <!--<![endif]--><head><meta charset="utf-8">';
		echo "<pre>".htmlspecialchars($expected)."</pre>";
		echo "<pre>".htmlspecialchars($result)."</pre>";
		$this->assertEqual($result, $expected, 'html5 boilerplate and a false manifest');

/**
 * html4
*/
		
		$settings = array();
		$settings['docType'] = 'html4-strict';
		$result = $this->Html->start($settings);
		$result = str_replace(array("\n", "\r"), '', $result);
		$expected = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"><html><head><meta charset="utf-8">';
		echo "<pre>".htmlspecialchars($expected)."</pre>";
		echo "<pre>".htmlspecialchars($result)."</pre>";
		$this->assertEqual($result, $expected, 'html4 strict');
	}

/**
 * testLink method
 *
 * @access public
 * @return void
 */
	function testLink() {
		$result = $this->Html->link('/home');
		$expected = array('a' => array('href' => '/home'), 'preg:/\/home/', '/a');
		$this->assertTags($result, $expected);

		$result = $this->Html->link('Posts', array('controller' => 'posts', 'action' => 'index', 'full_base' => true));
		$expected = array('a' => array('href' => FULL_BASE_URL . '/posts'), 'Posts', '/a');
		$this->assertTags($result, $expected);

		$result = $this->Html->link('Home', '/home', array('confirm' => 'Are you sure you want to do this?'));
		$expected = array(
			'a' => array('href' => '/home', 'onclick' => 'return confirm(&#039;Are you sure you want to do this?&#039;);'),
			'Home',
			'/a'
		);
		$this->assertTags($result, $expected, true);

		$result = $this->Html->link('Home', '/home', array('default' => false));
		$expected = array(
			'a' => array('href' => '/home', 'onclick' => 'event.returnValue = false; return false;'),
			'Home',
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->link('Next >', '#');
		$expected = array(
			'a' => array('href' => '#'),
			'Next &gt;',
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->link('Next >', '#', array('escape' => true));
		$expected = array(
			'a' => array('href' => '#'),
			'Next &gt;',
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->link('Next >', '#', array('escape' => 'utf-8'));
		$expected = array(
			'a' => array('href' => '#'),
			'Next &gt;',
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->link('Next >', '#', array('escape' => false));
		$expected = array(
			'a' => array('href' => '#'),
			'Next >',
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->link('Next >', '#', array(
			'title' => 'to escape &#8230; or not escape?',
			'escape' => false
		));
		$expected = array(
			'a' => array('href' => '#', 'title' => 'to escape &#8230; or not escape?'),
			'Next >',
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->link('Next >', '#', array(
			'title' => 'to escape &#8230; or not escape?',
			'escape' => true
		));
		$expected = array(
			'a' => array('href' => '#', 'title' => 'to escape &amp;#8230; or not escape?'),
			'Next &gt;',
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->link('Original size', array(
			'controller' => 'images', 'action' => 'view', 3, '?' => array('height' => 100, 'width' => 200)
		));
		$expected = array(
			'a' => array('href' => '/images/view/3?height=100&amp;width=200'),
			'Original size',
			'/a'
		);
		$this->assertTags($result, $expected);

		Configure::write('Asset.timestamp', false);

		$result = $this->Html->link($this->Html->image('test.gif'), '#', array('escape' => false));
		$expected = array(
			'a' => array('href' => '#'),
			'img' => array('src' => 'img/test.gif', 'alt' => ''),
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->image('test.gif', array('url' => '#'));
		$expected = array(
			'a' => array('href' => '#'),
			'img' => array('src' => 'img/test.gif', 'alt' => ''),
			'/a'
		);
		$this->assertTags($result, $expected);

		Configure::write('Asset.timestamp', 'force');

 		$result = $this->Html->link($this->Html->image('test.gif'), '#', array('escape' => false));
 		$expected = array(
 			'a' => array('href' => '#'),
			'img' => array('src' => 'preg:/img\/test\.gif\?\d*/', 'alt' => ''),
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->image('test.gif', array('url' => '#'));
		$expected = array(
			'a' => array('href' => '#'),
			'img' => array('src' => 'preg:/img\/test\.gif\?\d*/', 'alt' => ''),
			'/a'
		);
		$this->assertTags($result, $expected);
	}

/**
 * testImageTag method
 *
 * @access public
 * @return void
 */
	function testImageTag() {
		Configure::write('Asset.timestamp', false);

		$result = $this->Html->image('test.gif');
		$this->assertTags($result, array('img' => array('src' => 'img/test.gif', 'alt' => '')));

		$result = $this->Html->image('http://google.com/logo.gif');
		$this->assertTags($result, array('img' => array('src' => 'http://google.com/logo.gif', 'alt' => '')));

		$result = $this->Html->image(array('controller' => 'test', 'action' => 'view', 1, 'ext' => 'gif'));
		$this->assertTags($result, array('img' => array('src' => '/test/view/1.gif', 'alt' => '')));

		$result = $this->Html->image('/test/view/1.gif');
		$this->assertTags($result, array('img' => array('src' => '/test/view/1.gif', 'alt' => '')));
	}

/**
 * test image() with Asset.timestamp
 *
 * @return void
 */
	function testImageWithTimestampping() {
		Configure::write('Asset.timestamp', 'force');

		$this->Html->__type = 'html5';
		$this->Html->_setTypes();
		$this->Html->webroot = '/';
		$result = $this->Html->image('cake.icon.png');
		$this->assertTags($result, array('img' => array('src' => 'preg:/\/img\/cake\.icon\.png\?\d+/', 'alt' => '')));

		Configure::write('debug', 0);
		Configure::write('Asset.timestamp', 'force');

		$result = $this->Html->image('cake.icon.png');
		$this->assertTags($result, array('img' => array('src' => 'preg:/\/img\/cake\.icon\.png\?\d+/', 'alt' => '')));

		$webroot = $this->Html->webroot;
		$this->Html->webroot = '/testing/longer/';
		$result = $this->Html->image('cake.icon.png');
		$expected = array(
			'img' => array('src' => 'preg:/\/testing\/longer\/img\/cake\.icon\.png\?[0-9]+/', 'alt' => '')
		);
		$this->assertTags($result, $expected);
		$this->Html->webroot = $webroot;
	}

/**
 * Tests creation of an image tag using a theme and asset timestamping
 *
 * @access public
 * @return void
 * @link https://trac.cakephp.org/ticket/6490
 */
	function testImageTagWithTheme() {
		if ($this->skipIf(!is_writable(TEST_APP .  'webroot' . DS . 'theme'), 'Cannot write to webroot/theme')) {
			return;
		}
		App::import('Core', 'File');

		$testfile = TEST_APP . 'webroot' . DS . 'theme' . DS . 'test_theme' . DS . 'img' . DS . '__cake_test_image.gif';
		$file =& new File($testfile, true);

		App::build(array(
			'views' => array(TEST_APP . 'views'. DS)
		));
		Configure::write('Asset.timestamp', true);
		Configure::write('debug', 1);

		$this->Html->webroot = '/';
		$this->Html->theme = 'test_theme';
		$result = $this->Html->image('__cake_test_image.gif');
		
		/**
		 * todo: Item #3 / regex #1 failed: Attribute "src" matches "\/theme\/test_theme\/img\/__cake_test_image\.gif\?\d+", Attribute "alt" == ""
		*/
		
		$this->Html->log(array(
			'img' => array(
				'src' => 'preg:/\/theme\/test_theme\/img\/__cake_test_image\.gif\?\d+/',
				'alt' => ''
		)), 'html_plus');
		$this->Html->log($result, 'html_plus');
		echo "<pre>".htmlspecialchars($result)."</pre>";
		$this->assertTags($result, array(
			'img' => array(
				'src' => 'preg:/\/theme\/test_theme\/img\/__cake_test_image\.gif\?\d+/',
				'alt' => ''
		)));

		$webroot = $this->Html->webroot;
		$this->Html->webroot = '/testing/';
		$result = $this->Html->image('__cake_test_image.gif');
		
		/**
		 * todo: Item #3 / regex #1 failed: Attribute "src" matches "\/testing\/theme\/test_theme\/img\/__cake_test_image\.gif\?\d+", Attribute "alt" == ""
		*/

		$this->assertTags($result, array(
			'img' => array(
				'src' => 'preg:/\/testing\/theme\/test_theme\/img\/__cake_test_image\.gif\?\d+/',
				'alt' => ''
		)));
		$this->Html->log(array(
			'img' => array(
				'src' => 'preg:/\/testing\/theme\/test_theme\/img\/__cake_test_image\.gif\?\d+/',
				'alt' => ''
		)), 'html_plus');
		$this->Html->log($result, 'html_plus');
		echo "<pre>".htmlspecialchars($result)."</pre>";
		$this->Html->webroot = $webroot;

		$dir =& new Folder(WWW_ROOT . 'theme' . DS . 'test_theme');
		$dir->delete();
	}

/**
 * test theme assets in main webroot path
 *
 * @access public
 * @return void
 */
	function testThemeAssetsInMainWebrootPath() {
		/**
		 * todo: make this create tests folders in app/tmp/tests
		*/
		Configure::write('Asset.timestamp', false);
		App::build(array(
			'views' => array(TEST_CAKE_CORE_INCLUDE_PATH . 'tests' . DS . 'test_app' . DS . 'views'. DS)
		));
		$webRoot = Configure::read('App.www_root');
		Configure::write('App.www_root', TEST_CAKE_CORE_INCLUDE_PATH . 'tests' . DS . 'test_app' . DS . 'webroot' . DS);
/**
 * html5
*/
		$this->Html->__type = 'html5';
		$this->Html->_setTypes();
		$webroot = $this->Html->webroot;
		$this->Html->theme = 'test_theme';
		$result = $this->Html->css('webroot_test');
		$expected = array(
			'link' => array('rel' => 'stylesheet', 'href' => 'preg:/.*theme\/test_theme\/css\/webroot_test\.css/')
		);
		$this->assertTags($result, $expected, 'html5 theme 1');

		$webroot = $this->Html->webroot;
		$this->Html->theme = 'test_theme';
		$result = $this->Html->css('theme_webroot');
		$expected = array(
			'link' => array('rel' => 'stylesheet', 'href' => 'preg:/.*theme\/test_theme\/css\/theme_webroot\.css/')
		);
		$this->assertTags($result, $expected, 'html5 theme 2');
/**
 * html4
*/
		$this->Html->__type = 'html4';
		$this->Html->_setTypes();
		$webroot = $this->Html->webroot;
		$this->Html->theme = 'test_theme';
		$result = $this->Html->css('webroot_test');
		$expected = array(
			'link' => array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => 'preg:/.*theme\/test_theme\/css\/webroot_test\.css/')
		);
		$resultEn = htmlentities($result);
		$this->assertTags($result, $expected, 'html4 theme 1');

		$webroot = $this->Html->webroot;
		$this->Html->theme = 'test_theme';
		$result = $this->Html->css('theme_webroot');
		$expected = array(
			'link' => array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => 'preg:/.*theme\/test_theme\/css\/theme_webroot\.css/')
		);
		$this->assertTags($result, $expected, 'html4 theme 2');

		Configure::write('App.www_root', $webRoot);
	}

/**
 * testStyle method
 *
 * @access public
 * @return void
 */
	function testStyle() {
		$result = $this->Html->style(array('display'=> 'none', 'margin'=>'10px'));
		$expected = 'display:none; margin:10px;';
		$this->assertPattern('/^display\s*:\s*none\s*;\s*margin\s*:\s*10px\s*;?$/', $expected);

		$result = $this->Html->style(array('display'=> 'none', 'margin'=>'10px'), false);
		$lines = explode("\n", $result);
		$this->assertPattern('/^\s*display\s*:\s*none\s*;\s*$/', $lines[0]);
		$this->assertPattern('/^\s*margin\s*:\s*10px\s*;?$/', $lines[1]);
	}

/**
 * testCssLink method
 *
 * @access public
 * @return void
 */
	function testCssLink() {
		Configure::write('Asset.timestamp', false);
		Configure::write('Asset.filter.css', false);
/**
 * html5
*/
		$this->Html->__type = 'html5';
		$this->Html->_setTypes();
		$result = $this->Html->css('screen');
		$expected = array(
			'link' => array('rel' => 'stylesheet', 'href' => 'preg:/.*css\/screen\.css/')
		);
		$this->assertTags($result, $expected, 'html4 screen css');

		$result = $this->Html->css('screen');
		$expected = array(
			'link' => array('rel' => 'stylesheet', 'href' => 'preg:/.*css\/screen\.css/')
		);
		$this->assertTags($result, $expected, 'html5 css');

		$result = $this->Html->css('screen.css');
		$this->assertTags($result, $expected, 'hmtl5 withsuffix added');

		$result = $this->Html->css('my.css.library');
		$expected['link']['href'] = 'preg:/.*css\/my\.css\.library\.css/';
		$this->assertTags($result, $expected, 'html5 css lib');

		$result = $this->Html->css('screen.css?1234');
		$expected['link']['href'] = 'preg:/.*css\/screen\.css\?1234/';
		$this->assertTags($result, $expected, 'html5 with cache bust url');

		$result = $this->Html->css('http://whatever.com/screen.css?1234');
		$expected['link']['href'] = 'preg:/http:\/\/.*\/screen\.css\?1234/';
		$this->assertTags($result, $expected, 'full http url');

		Configure::write('Asset.filter.css', 'css.php');
		$result = $this->Html->css('cake.generic');
		$expected['link']['href'] = 'preg:/.*ccss\/cake\.generic\.css/';
		$this->assertTags($result, $expected, 'html5 asset filter');

		Configure::write('Asset.filter.css', false);

		$result = explode("\n", trim($this->Html->css(array('cake.generic', 'vendor.generic'))));
		$expected['link']['href'] = 'preg:/.*css\/cake\.generic\.css/';
		$this->assertTags($result[0], $expected, 'html5 arrayed[0] css');
		$expected['link']['href'] = 'preg:/.*css\/vendor\.generic\.css/';
		$this->assertTags($result[1], $expected, 'html5 arrayed[1] css');
		$this->assertEqual(count($result), 2);

		ClassRegistry::removeObject('view');
		$view =& new HtmlHelperMockView();
		ClassRegistry::addObject('view', $view);
		$view->expectAt(0, 'addScript', array(new PatternExpectation('/css_in_head.css/')));
		$result = $this->Html->css('css_in_head', null, array('inline' => false));
		$this->assertNull($result);

		$view =& ClassRegistry::getObject('view');
		$view->expectAt(1, 'addScript', array(new NoPatternExpectation('/inline=""/')));
		$result = $this->Html->css('more_css_in_head', null, array('inline' => false));
		$this->assertNull($result);
/**
 * html4
*/
		$this->Html->__type = 'html4';
		$this->Html->_setTypes();
		$result = $this->Html->css('screen');
		$expected = array(
			'link' => array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => 'preg:/.*css\/screen\.css/')
		);
		$this->assertTags($result, $expected, 'html4 screen css');

		$result = $this->Html->css('screen');
		$expected = array(
			'link' => array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => 'preg:/.*css\/screen\.css/')
		);
		$this->assertTags($result, $expected, 'html4 css');

		$result = $this->Html->css('screen.css');
		$this->assertTags($result, $expected, 'hmtl4 withsuffix added');

		$result = $this->Html->css('my.css.library');
		$expected['link']['href'] = 'preg:/.*css\/my\.css\.library\.css/';
		$this->assertTags($result, $expected, 'html4 css lib');

		$result = $this->Html->css('screen.css?1234');
		$expected['link']['href'] = 'preg:/.*css\/screen\.css\?1234/';
		$this->assertTags($result, $expected, 'html4 with cache bust url');

		$result = $this->Html->css('http://whatever.com/screen.css?1234');
		$expected['link']['href'] = 'preg:/http:\/\/.*\/screen\.css\?1234/';
		$this->assertTags($result, $expected, 'html4 full http url');

		Configure::write('Asset.filter.css', 'css.php');
		$result = $this->Html->css('cake.generic');
		$expected['link']['href'] = 'preg:/.*ccss\/cake\.generic\.css/';
		$this->assertTags($result, $expected, 'html4 asset filter');

		Configure::write('Asset.filter.css', false);

		$result = explode("\n", trim($this->Html->css(array('cake.generic', 'vendor.generic'))));
		$expected['link']['href'] = 'preg:/.*css\/cake\.generic\.css/';
		$this->assertTags($result[0], $expected, 'html4 arrayed[0] css');
		$expected['link']['href'] = 'preg:/.*css\/vendor\.generic\.css/';
		$this->assertTags($result[1], $expected, 'html4 arrayed[1] css');
		$this->assertEqual(count($result), 2);

		ClassRegistry::removeObject('view');
		$view =& new HtmlHelperMockView();
		ClassRegistry::addObject('view', $view);
		$view->expectAt(0, 'addScript', array(new PatternExpectation('/css_in_head.css/')));
		$result = $this->Html->css('css_in_head', null, array('inline' => false));
		$this->assertNull($result);

		$view =& ClassRegistry::getObject('view');
		$view->expectAt(1, 'addScript', array(new NoPatternExpectation('/inline=""/')));
		$result = $this->Html->css('more_css_in_head', null, array('inline' => false));
		$this->assertNull($result);
	}

/**
 * test use of css() and timestamping
 *
 * @return void
 */
	function testCssTimestamping() {
		Configure::write('debug', 2);
		Configure::write('Asset.timestamp', true);
/**
 * html5
*/
		$this->Html->__type = 'html5';
		$this->Html->_setTypes();
		$expected = array(
			'link' => array('rel' => 'stylesheet', 'href' => '')
		);

		$result = $this->Html->css('cake.generic');
		$expected['link']['href'] = 'preg:/.*css\/cake\.generic\.css\?[0-9]+/';
		$this->assertTags($result, $expected, 'html5 time stamping 1');

		Configure::write('debug', 0);

		$result = $this->Html->css('cake.generic');
		$expected['link']['href'] = 'preg:/.*css\/cake\.generic\.css/';
		$this->assertTags($result, $expected, 'html5 times stamping 2');

		Configure::write('Asset.timestamp', 'force');

		$result = $this->Html->css('cake.generic');
		$expected['link']['href'] = 'preg:/.*css\/cake\.generic\.css\?[0-9]+/';
		$this->assertTags($result, $expected, 'html5 times stamping 3');

		$webroot = $this->Html->webroot;
		$this->Html->webroot = '/testing/';
		$result = $this->Html->css('cake.generic');
		$expected['link']['href'] = 'preg:/\/testing\/css\/cake\.generic\.css\?[0-9]+/';
		$this->assertTags($result, $expected, 'html5 time stamping 4');
		$this->Html->webroot = $webroot;

		$webroot = $this->Html->webroot;
		$this->Html->webroot = '/testing/longer/';
		$result = $this->Html->css('cake.generic');
		$expected['link']['href'] = 'preg:/\/testing\/longer\/css\/cake\.generic\.css\?[0-9]+/';
		$this->assertTags($result, $expected, 'html5 time staming 5');
		$this->Html->webroot = $webroot;
	/**
	 * html4
	*/
		$this->Html->__type = 'html4';
		$this->Html->_setTypes();

		$expected = array(
			'link' => array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => '')
		);

		$result = $this->Html->css('cake.generic');
		$expected['link']['href'] = 'preg:/.*css\/cake\.generic\.css\?[0-9]+/';
		$this->assertTags($result, $expected, true, 'html4 time stamping 1');

		Configure::write('debug', 1);
		
		$result = $this->Html->css('cake.generic');
		$expected['link']['href'] = 'preg:/.*css\/cake\.generic\.css\?[0-9]+/';
		$this->assertTags($result, $expected, true, 'html4 time stamping 2');
		
		Configure::write('Asset.timestamp', 'force');

		$result = $this->Html->css('cake.generic');
		$expected['link']['href'] = 'preg:/.*css\/cake\.generic\.css\?[0-9]+/';
		$this->assertTags($result, $expected, true, 'html4 time stamping 3');

		$webroot = $this->Html->webroot;
		$this->Html->webroot = '/testing/';
		$result = $this->Html->css('cake.generic');
		$expected['link']['href'] = 'preg:/\/testing\/css\/cake\.generic\.css\?[0-9]+/';
		$this->assertTags($result, $expected, true, 'html4 time stamping 4');
		$this->Html->webroot = $webroot;

		$webroot = $this->Html->webroot;
		$this->Html->webroot = '/testing/longer/';
		$result = $this->Html->css('cake.generic');
		$expected['link']['href'] = 'preg:/\/testing\/longer\/css\/cake\.generic\.css\?[0-9]+/';
		$this->assertTags($result, $expected, true, 'html4 time stamping 5');
		$this->Html->webroot = $webroot;
	}

/**
 * test timestamp enforcement for script tags.
 *
 * @return void
 */
	function testScriptTimestampingXhtml() {
		$skip = $this->skipIf(!is_writable(JS), 'webroot/js is not Writable, timestamp testing has been skipped');
		if ($skip) {
			return;
		}
		Configure::write('debug', 2);
		Configure::write('Asset.timestamp', true);

		touch(WWW_ROOT . 'js' . DS. '__cake_js_test.js');
		$timestamp = substr(strtotime('now'), 0, 8);
		
		$this->Html->__type = 'xhtml';
		$this->Html->_setTypes();

		$result = $this->Html->script('__cake_js_test', array('inline' => true, 'once' => false));
		$this->assertPattern('/__cake_js_test.js\?' . $timestamp . '[0-9]{2}"/', $result, 'Timestamp value not found %s');

		Configure::write('debug', 0);
		Configure::write('Asset.timestamp', 'force');
		$result = $this->Html->script('__cake_js_test', array('inline' => true, 'once' => false));
		$this->assertPattern('/__cake_js_test.js\?' . $timestamp . '[0-9]{2}"/', $result, 'Timestamp value not found %s');
		unlink(WWW_ROOT . 'js' . DS. '__cake_js_test.js');
		Configure::write('Asset.timestamp', false);
	}
	
	function testScriptTimestampingHtml5() {
		$skip = $this->skipIf(!is_writable(JS), 'webroot/js is not Writable, timestamp testing has been skipped');
		if ($skip) {
			return;
		}
		Configure::write('debug', 2);
		Configure::write('Asset.timestamp', true);

		touch(WWW_ROOT . 'js' . DS. '__cake_js_test.js');
		$timestamp = substr(strtotime('now'), 0, 8);
		
		$this->Html->__type = 'xhtml';
		$this->Html->_setTypes();

		$result = $this->Html->script('__cake_js_test', array('inline' => true, 'once' => false));
		$this->assertPattern('/__cake_js_test.js\?' . $timestamp . '[0-9]{2}"/', $result, 'Timestamp value not found %s');

		Configure::write('debug', 0);
		Configure::write('Asset.timestamp', 'force');
		$result = $this->Html->script('__cake_js_test', array('inline' => true, 'once' => false));
		$this->assertPattern('/__cake_js_test.js\?' . $timestamp . '[0-9]{2}"/', $result, 'Timestamp value not found %s');
		unlink(WWW_ROOT . 'js' . DS. '__cake_js_test.js');
		Configure::write('Asset.timestamp', false);
	}
	/*
	 * function testScriptWithDefer
	 * @param 
	 */
	
	function testScriptWithDeferAsync() {
		$this->Html->__type = 'html4';
		$this->Html->_setTypes();
		$result = $this->Html->script('foo', array('defer' => true));
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => 'js/foo.js', 'defer' => "true")
		);
		htmlspecialchars($result);	//echo htmlspecialchars($expected);
		//echo "<pre>".htmlspecialchars($expected)."</pre>";
		echo "<pre>".htmlspecialchars($result)."</pre>";
		$this->assertTags($result, $expected, false, 'script does have defer');
		
		$this->Html->__type = 'html5';
		$this->Html->_setTypes();
		$result = $this->Html->script('foo', array('async' => true));
		$expected = array(
			'script' => array('src' => 'js/foo.js', 'async' => 'true')
		);
		//echo "<pre>".htmlspecialchars($expected)."</pre>";
		echo "<pre>".htmlspecialchars($result)."</pre>";
		$this->assertTags($result, $expected, true, 'script does have async');
		
		$result = $this->Html->script('foo', array('inline' => true, 'defer' => true));
		$expected = array(
			'script' => array('src' => 'js/foo.js', 'defer' => 'true')
		);
		echo "<pre>".htmlspecialchars($result)."</pre>";
		$this->assertTags($result, $expected, true, 'script does not have defer');
		
		$result = $this->Html->script('foo', array('defer' => 'true', 'async' => 'true'));
		$expected = array(
			'script' => array('src' => 'js/foo.js', 'defer' => 'true', 'async' => 'true')
		);
		echo "<pre>".htmlspecialchars($result)."</pre>";
		$this->assertTags($result, $expected, true, 'script async and defer');
	}

/**
 * test that scripts with network uri (secure independent)
 *
 * @return void
 */
	function testScriptNetworkUri() {
		$expected = array(
		    'script' => array('src' => '//ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js'),
		);
		$result = $this->Html->script('//ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js');
		echo '<pre>' . htmlspecialchars($result) . '</pre>';
		$this->assertTags($result, $expected, true, 'script async and defer');
	}

/**
 * test that scripts added with uses() are only ever included once.
 * test script tag generation
 *
 * @return void
 */
	function testScript() {
		$skip = $this->skipIf(!is_writable(TEST_APP . 'webroot' . DS . 'js' . DS), 'webroot/js is not Writable, timestamp testing has been skipped ' . JS);
		if ($skip) {
			return;
		}
		Configure::write('Asset.timestamp', false);
		
		/**
		 * html5
		*/
		$this->Html->__type = 'html5';
		$this->Html->_setTypes();
		$result = $this->Html->script('foo');
		$expected = array(
			'script' => array('src' => 'js/foo.js')
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->script(array('foobar', 'bar'));
		echo "<pre>".htmlspecialchars($result)."</pre>";
		$expected = array(
			array('script' => array('src' => 'js/foobar.js')),
			array('script' => array('src' => 'js/bar.js'))
		);
		echo "<pre>".htmlspecialchars($result)."</pre>";
		$this->assertTags($result, $expected);

		$result = $this->Html->script('jquery-1.3');
		$expected = array(
			'script' => array('src' => 'js/jquery-1.3.js')
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->script('test.json');
		$expected = array(
			'script' => array('src' => 'js/test.json.js')
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->script('/plugin/js/jquery-1.3.2.js?someparam=foo');
		$expected = array(
			'script' => array('src' => '/plugin/js/jquery-1.3.2.js?someparam=foo')
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->script('test.json.js?foo=bar');
		$expected = array(
			'script' => array('src' => 'js/test.json.js?foo=bar')
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->script('foo');
		$this->assertNull($result, 'Script returned upon duplicate inclusion %s');

		$result = $this->Html->script(array('foo', 'bar', 'baz'));
		$this->assertNoPattern('/foo.js/', $result);

		$result = $this->Html->script('foo', array('inline' => true, 'once' => false));
		$this->assertNotNull($result);

		$result = $this->Html->script('jquery-1.3.2', array('defer' => true, 'encoding' => 'utf-8'));
		$expected = array(
			'script' => array('src' => 'js/jquery-1.3.2.js', 'defer' => 'defer', 'encoding' => 'utf-8')
		);
		echo "<pre>".htmlspecialchars($result)."</pre>";
		$this->assertTags($result, $expected);

		$view =& ClassRegistry::getObject('view');
		$view =& new HtmlHelperMockView();
		$view->expectAt(0, 'addScript', array(new PatternExpectation('/script_in_head.js/')));
		$result = $this->Html->script('script_in_head', array('inline' => false));
		echo "<pre>".htmlspecialchars($result)."</pre>";
		$this->assertNull($result);
		
		/**
		 * html4
		*/
		$this->Html->__type = 'html4';
		$this->Html->_setTypes();
		$result = $this->Html->script('foo');
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => 'js/foo.js')
		);
		/**
		 * todo: Item #1 / regex #0 failed: Open script tag at 
		*/
		echo "<pre>".htmlspecialchars($result)."</pre>";
		$this->assertTags($result, $expected, true, 'html4 javascript');

		$result = $this->Html->script(array('foobar', 'bar'));
		echo "<pre>".htmlspecialchars($result)."</pre>";
		$expected = array(
			array('script' => array('type' => 'text/javascript', 'src' => 'js/foobar.js')),
			array('script' => array('type' => 'text/javascript', 'src' => 'js/bar.js')),
		);
/**
 * todo: Item #1 / regex #0 failed: Open script tag at
*/
		echo "<pre>".htmlspecialchars($result)."</pre>";

		$this->assertTags($result, $expected, true, 'html4 javascript 2');

		$result = $this->Html->script('jquery-1.3');
		echo "<pre>".htmlspecialchars($result)."</pre>";
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => 'js/jquery-1.3.js')
		);
		/**
		 * todo: Item #1 / regex #0 failed: Open script tag 
		*/
		$this->assertTags($result, $expected, 'html4 jquery');

		$result = $this->Html->script('test.json');
		echo "<pre>".htmlspecialchars($result)."</pre>";
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => 'js/test.json.js')
		);
		
		/**
		 * todo: Item #1 / regex #0 failed: Open script tag at
		*/
		$this->assertTags($result, $expected, 'html4 test json');

		$result = $this->Html->script('/plugin/js/jquery-1.3.2.js?someparam=foo');
		echo "<pre>".htmlspecialchars($result)."</pre>";
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => '/plugin/js/jquery-1.3.2.js?someparam=foo')
		);
		
		/**
		 * todo: Item #1 / regex #0 failed: Open script tag 
		*/
		$this->assertTags($result, $expected, 'html4 abs path with cache bust');

		$result = $this->Html->script('test.json.js?foo=bar');
		echo "<pre>".htmlspecialchars($result)."</pre>";
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => 'js/test.json.js?foo=bar')
		);
		/**
		 * todo: Item #1 / regex #0 failed: Open script tag
		*/
		$this->assertTags($result, $expected);

		$result = $this->Html->script('foo');
		$this->assertNull($result, 'Script returned upon duplicate inclusion %s');

		$result = $this->Html->script(array('foo', 'bar', 'baz'));
		$this->assertNoPattern('/foo.js/', $result);

		$result = $this->Html->script('foo', array('inline' => true, 'once' => false));
		$this->assertNotNull($result);

		$result = $this->Html->script('jquery-1.3.2', array('defer' => true, 'encoding' => 'utf-8'));
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => 'js/jquery-1.3.2.js', 'defer' => 'defer', 'encoding' => 'utf-8')
		);
		/**
		 * todo: Item #1 / regex #0 failed: Open script tag 
		*/
		$this->assertTags($result, $expected);

		$view =& ClassRegistry::getObject('view');
		$view =& new HtmlHelperMockView();
		$view->expectAt(0, 'addScript', array(new PatternExpectation('/script_in_head.js/')));
		$result = $this->Html->script('script_in_head', array('inline' => false));
		$this->assertNull($result);
	}

/**
 * test a script file in the webroot/theme dir.
 *
 * @return void
 */
	function testScriptInTheme() {
		if ($this->skipIf(!is_writable(TEST_APP . 'webroot' . DS . 'theme'), 'Cannot write to webroot/theme')) {
			return;
		}
		App::import('Core', 'File');
		
		$this->Html->__type = 'html5';
		$this->Html->_setTypes();

		$testfile = TEST_APP . 'webroot' . DS . 'theme' . DS . 'test_theme' . DS . 'js' . DS . '__test_js.js';
		$file =& new File($testfile, true);

		App::build(array(
			'views' => array(TEST_APP . 'views'. DS)
		));

		$this->Html->webroot = '/';
		$this->Html->theme = 'test_theme';
		$result = $this->Html->script('__test_js.js');
		$expected = array(
			'script' => array('src' => '/theme/test_theme/js/__test_js.js', 'type' => 'text/javascript')
		);
		/**
		 * todo: Item #1 / regex #0 failed: Text equals "script"
		*/
		$this->assertTags($result, $expected);
		App::build();
	}

/**
 * test Script block generation
 *
 * @return void
 */
	function testScriptBlock() {
		$result = $this->Html->scriptBlock('window.foo = 2;');
		$expected = array(
			'script' => array('type' => 'text/javascript'),
			$this->cDataStart,
			'window.foo = 2;',
			$this->cDataEnd,
			'/script',
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->scriptBlock('window.foo = 2;', array('safe' => false));
		$expected = array(
			'script' => array('type' => 'text/javascript'),
			'window.foo = 2;',
			'/script',
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->scriptBlock('window.foo = 2;', array('safe' => true));
		$expected = array(
			'script' => array('type' => 'text/javascript'),
			$this->cDataStart,
			'window.foo = 2;',
			$this->cDataEnd,
			'/script',
		);
		$this->assertTags($result, $expected);

		$view =& ClassRegistry::getObject('view');
		$view =& new HtmlHelperMockView();
		$view->expectAt(0, 'addScript', array(new PatternExpectation('/window\.foo\s\=\s2;/')));

		$result = $this->Html->scriptBlock('window.foo = 2;', array('inline' => false));
		$this->assertNull($result);

		$result = $this->Html->scriptBlock('window.foo = 2;', array('safe' => false, 'encoding' => 'utf-8'));
		$expected = array(
			'script' => array('type' => 'text/javascript', 'encoding' => 'utf-8'),
			'window.foo = 2;',
			'/script',
		);
		$this->assertTags($result, $expected);
	}

/**
 * test script tag output buffering when using scriptStart() and scriptEnd();
 *
 * @return void
 */
	function testScriptStartAndScriptEnd() {
		
		$this->Html->__type = 'html5';
		$this->Html->_setTypes();
		
		$result = $this->Html->scriptStart(array('safe' => true));
		$this->assertNull($result);
		echo 'this is some javascript';

		$result = $this->Html->scriptEnd();
		$expected = array(
			'script' => array('type' => 'text/javascript'),
			$this->cDataStart,
			'this is some javascript',
			$this->cDataEnd,
			'/script'
		);
		$this->assertTags($result, $expected);


		
		$this->Html->__type = 'html4';
		$this->Html->_setTypes();
		$result = $this->Html->scriptStart(array('safe' => false));
		$this->assertNull($result);
		echo 'this is some javascript';

		$result = $this->Html->scriptEnd();
		$expected = array(
			'script' => array('type' => 'text/javascript'),
			'this is some javascript',
			'/script'
		);
		$this->assertTags($result, $expected);

		ClassRegistry::removeObject('view');
		$View =& new HtmlHelperMockView();

		$View->expectOnce('addScript');
		ClassRegistry::addObject('view', $View);

		$result = $this->Html->scriptStart(array('safe' => false, 'inline' => false));
		$this->assertNull($result);
		echo 'this is some javascript';

		$result = $this->Html->scriptEnd();
		$this->assertNull($result);
	}

/**
 * testCharsetTag method
 *
 * @access public
 * @return void
 */
	function testCharsetTag() {
		Configure::write('App.encoding', null);
		/**
		 * html5
		*/
		$this->Html->__type = 'html5';
		$this->Html->_setTypes();
		Configure::write('App.encoding', 'utf-8');
		$result = $this->Html->charset();
		$expected = array('meta' => array('charset' => 'utf-8'));
		
		$this->assertTags($result, $expected, false, 'html5 charset utf8');

		Configure::write('App.encoding', 'ISO-8859-1');
		$result = $this->Html->charset();
		$expected = array('meta' => array('charset' => 'iso-8859-1'));
		$this->assertTags($result, $expected, false, 'html5 charset ISO 8859-1');

		$result = $this->Html->charset('utf-7');
		$expected = array('meta' => array('charset' => 'utf-7'));
		$this->assertTags($result, $expected, false, 'html5 charset utf7');
		
		/**
		 * html4
		*/
		$this->Html->__type = 'html4';
		$this->Html->_setTypes();
		
		Configure::write('App.encoding', 'UTF-8');
		$result = $this->Html->charset();
		$expected = array('meta' => array('http-equiv' => 'Content-Type', 'content' => 'text/html; charset=utf-8'));
		$this->assertTags($result, $expected, false, 'html4 charset utf8');

		Configure::write('App.encoding', 'ISO-8859-1');
		$result = $this->Html->charset();
		$expected = array('meta' => array('http-equiv' => 'Content-Type', 'content' => 'text/html; charset=iso-8859-1'));
		$this->assertTags($result, $expected, false, 'html4 no args pass App.encoding applied auto');

		$result = $this->Html->charset('UTF-7');
		$expected = array('meta' => array('http-equiv' => 'Content-Type', 'content' => 'text/html; charset=UTF-7'));
		$this->assertTags($result, $expected, false, 'html5 charset utf7');
	}

/**
 * testBreadcrumb method
 *
 * @access public
 * @return void
 */
	function testBreadcrumb() {
		$this->Html->addCrumb('First', '#first');
		$this->Html->addCrumb('Second', '#second');
		$this->Html->addCrumb('Third', '#third');

		$result = $this->Html->getCrumbs();
		$expected = array(
			array('a' => array('href' => '#first')),
			'First',
			'/a',
			'&raquo;',
			array('a' => array('href' => '#second')),
			'Second',
			'/a',
			'&raquo;',
			array('a' => array('href' => '#third')),
			'Third',
			'/a',
		);
		$this->assertTags($result, $expected, true, 'test breadChrumb 1');

		$result = $this->Html->getCrumbs(' &gt; ');
		$expected = array(
			array('a' => array('href' => '#first')),
			'First',
			'/a',
			' &gt; ',
			array('a' => array('href' => '#second')),
			'Second',
			'/a',
			' &gt; ',
			array('a' => array('href' => '#third')),
			'Third',
			'/a',
		);
		$this->assertTags($result, $expected, true, 'test breadChrumb 2');

		$this->assertPattern('/^<a[^<>]+>First<\/a> &gt; <a[^<>]+>Second<\/a> &gt; <a[^<>]+>Third<\/a>$/', $result);
		$this->assertPattern('/<a\s+href=["\']+\#first["\']+[^<>]*>First<\/a>/', $result);
		$this->assertPattern('/<a\s+href=["\']+\#second["\']+[^<>]*>Second<\/a>/', $result);
		$this->assertPattern('/<a\s+href=["\']+\#third["\']+[^<>]*>Third<\/a>/', $result);
		$this->assertNoPattern('/<a[^<>]+[^href]=[^<>]*>/', $result);

		$this->Html->addCrumb('Fourth', null);

		$result = $this->Html->getCrumbs();
		$expected = array(
			array('a' => array('href' => '#first')),
			'First',
			'/a',
			'&raquo;',
			array('a' => array('href' => '#second')),
			'Second',
			'/a',
			'&raquo;',
			array('a' => array('href' => '#third')),
			'Third',
			'/a',
			'&raquo;',
			'Fourth'
		);
		$this->assertTags($result, $expected, true, 'test breadChrumb 3');
	}

/**
 * testNestedList method
 *
 * @access public
 * @return void
 */
	function testNestedList() {
		$list = array(
			'Item 1',
			'Item 2' => array(
				'Item 2.1'
			),
			'Item 3',
			'Item 4' => array(
				'Item 4.1',
				'Item 4.2',
				'Item 4.3' => array(
					'Item 4.3.1',
					'Item 4.3.2'
				)
			),
			'Item 5' => array(
				'Item 5.1',
				'Item 5.2'
			)
		);

		$result = $this->Html->nestedList($list);
		$expected = array(
			'<ul',
			'<li', 'Item 1', '/li',
			'<li', 'Item 2',
			'<ul', '<li', 'Item 2.1', '/li', '/ul',
			'/li',
			'<li', 'Item 3', '/li',
			'<li', 'Item 4',
			'<ul',
			'<li', 'Item 4.1', '/li',
			'<li', 'Item 4.2', '/li',
			'<li', 'Item 4.3',
			'<ul',
			'<li', 'Item 4.3.1', '/li',
			'<li', 'Item 4.3.2', '/li',
			'/ul',
			'/li',
			'/ul',
			'/li',
			'<li', 'Item 5',
			'<ul',
			'<li', 'Item 5.1', '/li',
			'<li', 'Item 5.2', '/li',
			'/ul',
			'/li',
			'/ul'
		);
		$this->assertTags($result, $expected, true, 'test nested list 1');

		$result = $this->Html->nestedList($list, null);
		$expected = array(
			'<ul',
			'<li', 'Item 1', '/li',
			'<li', 'Item 2',
			'<ul', '<li', 'Item 2.1', '/li', '/ul',
			'/li',
			'<li', 'Item 3', '/li',
			'<li', 'Item 4',
			'<ul',
			'<li', 'Item 4.1', '/li',
			'<li', 'Item 4.2', '/li',
			'<li', 'Item 4.3',
			'<ul',
			'<li', 'Item 4.3.1', '/li',
			'<li', 'Item 4.3.2', '/li',
			'/ul',
			'/li',
			'/ul',
			'/li',
			'<li', 'Item 5',
			'<ul',
			'<li', 'Item 5.1', '/li',
			'<li', 'Item 5.2', '/li',
			'/ul',
			'/li',
			'/ul'
		);
		$this->assertTags($result, $expected, true, 'test nested list 2');

		$result = $this->Html->nestedList($list, array(), array(), 'ol');
		$expected = array(
			'<ol',
			'<li', 'Item 1', '/li',
			'<li', 'Item 2',
			'<ol', '<li', 'Item 2.1', '/li', '/ol',
			'/li',
			'<li', 'Item 3', '/li',
			'<li', 'Item 4',
			'<ol',
			'<li', 'Item 4.1', '/li',
			'<li', 'Item 4.2', '/li',
			'<li', 'Item 4.3',
			'<ol',
			'<li', 'Item 4.3.1', '/li',
			'<li', 'Item 4.3.2', '/li',
			'/ol',
			'/li',
			'/ol',
			'/li',
			'<li', 'Item 5',
			'<ol',
			'<li', 'Item 5.1', '/li',
			'<li', 'Item 5.2', '/li',
			'/ol',
			'/li',
			'/ol'
		);
		$this->assertTags($result, $expected, true, 'test nested llist 3');

		$result = $this->Html->nestedList($list, 'ol');
		$expected = array(
			'<ol',
			'<li', 'Item 1', '/li',
			'<li', 'Item 2',
			'<ol', '<li', 'Item 2.1', '/li', '/ol',
			'/li',
			'<li', 'Item 3', '/li',
			'<li', 'Item 4',
			'<ol',
			'<li', 'Item 4.1', '/li',
			'<li', 'Item 4.2', '/li',
			'<li', 'Item 4.3',
			'<ol',
			'<li', 'Item 4.3.1', '/li',
			'<li', 'Item 4.3.2', '/li',
			'/ol',
			'/li',
			'/ol',
			'/li',
			'<li', 'Item 5',
			'<ol',
			'<li', 'Item 5.1', '/li',
			'<li', 'Item 5.2', '/li',
			'/ol',
			'/li',
			'/ol'
		);
		$this->assertTags($result, $expected, true, 'test nested list 3');

		$result = $this->Html->nestedList($list, array('class'=>'list'));
		$expected = array(
			array('ul' => array('class' => 'list')),
			'<li', 'Item 1', '/li',
			'<li', 'Item 2',
			array('ul' => array('class' => 'list')), '<li', 'Item 2.1', '/li', '/ul',
			'/li',
			'<li', 'Item 3', '/li',
			'<li', 'Item 4',
			array('ul' => array('class' => 'list')),
			'<li', 'Item 4.1', '/li',
			'<li', 'Item 4.2', '/li',
			'<li', 'Item 4.3',
			array('ul' => array('class' => 'list')),
			'<li', 'Item 4.3.1', '/li',
			'<li', 'Item 4.3.2', '/li',
			'/ul',
			'/li',
			'/ul',
			'/li',
			'<li', 'Item 5',
			array('ul' => array('class' => 'list')),
			'<li', 'Item 5.1', '/li',
			'<li', 'Item 5.2', '/li',
			'/ul',
			'/li',
			'/ul'
		);
		$this->assertTags($result, $expected, true, 'test nested list 4');

		$result = $this->Html->nestedList($list, array(), array('class' => 'item'));
		$expected = array(
			'<ul',
			array('li' => array('class' => 'item')), 'Item 1', '/li',
			array('li' => array('class' => 'item')), 'Item 2',
			'<ul', array('li' => array('class' => 'item')), 'Item 2.1', '/li', '/ul',
			'/li',
			array('li' => array('class' => 'item')), 'Item 3', '/li',
			array('li' => array('class' => 'item')), 'Item 4',
			'<ul',
			array('li' => array('class' => 'item')), 'Item 4.1', '/li',
			array('li' => array('class' => 'item')), 'Item 4.2', '/li',
			array('li' => array('class' => 'item')), 'Item 4.3',
			'<ul',
			array('li' => array('class' => 'item')), 'Item 4.3.1', '/li',
			array('li' => array('class' => 'item')), 'Item 4.3.2', '/li',
			'/ul',
			'/li',
			'/ul',
			'/li',
			array('li' => array('class' => 'item')), 'Item 5',
			'<ul',
			array('li' => array('class' => 'item')), 'Item 5.1', '/li',
			array('li' => array('class' => 'item')), 'Item 5.2', '/li',
			'/ul',
			'/li',
			'/ul'
		);
		$this->assertTags($result, $expected, true, 'test nested list 4');

		$result = $this->Html->nestedList($list, array(), array('even' => 'even', 'odd' => 'odd'));
		$expected = array(
			'<ul',
			array('li' => array('class' => 'odd')), 'Item 1', '/li',
			array('li' => array('class' => 'even')), 'Item 2',
			'<ul', array('li' => array('class' => 'odd')), 'Item 2.1', '/li', '/ul',
			'/li',
			array('li' => array('class' => 'odd')), 'Item 3', '/li',
			array('li' => array('class' => 'even')), 'Item 4',
			'<ul',
			array('li' => array('class' => 'odd')), 'Item 4.1', '/li',
			array('li' => array('class' => 'even')), 'Item 4.2', '/li',
			array('li' => array('class' => 'odd')), 'Item 4.3',
			'<ul',
			array('li' => array('class' => 'odd')), 'Item 4.3.1', '/li',
			array('li' => array('class' => 'even')), 'Item 4.3.2', '/li',
			'/ul',
			'/li',
			'/ul',
			'/li',
			array('li' => array('class' => 'odd')), 'Item 5',
			'<ul',
			array('li' => array('class' => 'odd')), 'Item 5.1', '/li',
			array('li' => array('class' => 'even')), 'Item 5.2', '/li',
			'/ul',
			'/li',
			'/ul'
		);
		$this->assertTags($result, $expected, true, 'test breadChrumb 5');

		$result = $this->Html->nestedList($list, array('class'=>'list'), array('class' => 'item'));
		$expected = array(
			array('ul' => array('class' => 'list')),
			array('li' => array('class' => 'item')), 'Item 1', '/li',
			array('li' => array('class' => 'item')), 'Item 2',
			array('ul' => array('class' => 'list')), array('li' => array('class' => 'item')), 'Item 2.1', '/li', '/ul',
			'/li',
			array('li' => array('class' => 'item')), 'Item 3', '/li',
			array('li' => array('class' => 'item')), 'Item 4',
			array('ul' => array('class' => 'list')),
			array('li' => array('class' => 'item')), 'Item 4.1', '/li',
			array('li' => array('class' => 'item')), 'Item 4.2', '/li',
			array('li' => array('class' => 'item')), 'Item 4.3',
			array('ul' => array('class' => 'list')),
			array('li' => array('class' => 'item')), 'Item 4.3.1', '/li',
			array('li' => array('class' => 'item')), 'Item 4.3.2', '/li',
			'/ul',
			'/li',
			'/ul',
			'/li',
			array('li' => array('class' => 'item')), 'Item 5',
			array('ul' => array('class' => 'list')),
			array('li' => array('class' => 'item')), 'Item 5.1', '/li',
			array('li' => array('class' => 'item')), 'Item 5.2', '/li',
			'/ul',
			'/li',
			'/ul'
		);
		$this->assertTags($result, $expected, true, 'test nested list final');
	}

/**
 * testMeta method
 *
 * @access public
 * @return void
 */
	function testMeta() {
		$result = $this->Html->meta('this is an rss feed', array('controller' => 'posts', 'ext' => 'rss'));
		$this->assertTags($result, array('link' => array('href' => 'preg:/.*\/posts\.rss/', 'type' => 'application/rss+xml', 'rel' => 'alternate', 'title' => 'this is an rss feed')), true, 'post rss 1');

		$result = $this->Html->meta('rss', array('controller' => 'posts', 'ext' => 'rss'), array('title' => 'this is an rss feed'));
		$this->assertTags($result, array('link' => array('href' => 'preg:/.*\/posts\.rss/', 'type' => 'application/rss+xml', 'rel' => 'alternate', 'title' => 'this is an rss feed')), true, 'test post rss 2');

		$result = $this->Html->meta('atom', array('controller' => 'posts', 'ext' => 'xml'));
		$this->assertTags($result, array('link' => array('href' => 'preg:/.*\/posts\.xml/', 'type' => 'application/atom+xml', 'title' => 'atom')));

		$result = $this->Html->meta('non-existing');
		$this->assertTags($result, array('<meta'));

		$result = $this->Html->meta('non-existing', '/posts.xpp');
		$this->assertTags($result, array('link' => array('href' => 'preg:/.*\/posts\.xpp/', 'type' => 'application/rss+xml', 'rel' => 'alternate', 'title' => 'non-existing')));

		$result = $this->Html->meta('non-existing', '/posts.xpp', array('type' => 'atom'));
		$this->assertTags($result, array('link' => array('href' => 'preg:/.*\/posts\.xpp/', 'type' => 'application/atom+xml', 'title' => 'non-existing')));

		$result = $this->Html->meta('atom', array('controller' => 'posts', 'ext' => 'xml'), array('link' => '/articles.rss'));
		$this->assertTags($result, array('link' => array('href' => 'preg:/.*\/articles\.rss/', 'type' => 'application/atom+xml', 'title' => 'atom')));

		$result = $this->Html->meta(array('link' => 'favicon.ico', 'rel' => 'icon'));
		$expected = array(
			'link' => array('href' => 'preg:/.*favicon\.ico/', 'rel' => 'icon'),
			array('link' => array('href' => 'preg:/.*favicon\.ico/', 'rel' => 'shortcut icon'))
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->meta('icon', 'favicon.ico');
		$expected = array(
			'link' => array('href' => 'preg:/.*favicon\.ico/', 'type' => 'image/x-icon', 'rel' => 'icon'),
			array('link' => array('href' => 'preg:/.*favicon\.ico/', 'type' => 'image/x-icon', 'rel' => 'shortcut icon'))
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->meta('keywords', 'these, are, some, meta, keywords');
		$expected = array('meta' => array('name' => 'keywords', 'content' => 'these, are, some, meta, keywords'));
		$this->assertTags($result, $expected, true, 'meta keywords is being funny ironically search engines ignore them');
		//$this->assertPattern('/\s+([\/]*)>$/', $result);


		$result = $this->Html->meta('description', 'this is the meta description');
		$this->assertTags($result, array('meta' => array('name' => 'description', 'content' => 'this is the meta description')));
		
		$result = $this->Html->meta('author', 'hello@samsherlock.com');
		$this->assertTags($result, array('meta' => array('name' => 'author', 'content' => 'hello@samsherlock.com')), true, 'author meta');

		$result = $this->Html->meta(array('name' => 'ROBOTS', 'content' => 'ALL'));
		$this->assertTags($result, array('meta' => array('name' => 'ROBOTS', 'content' => 'ALL')));

		$this->assertNull($this->Html->meta(array('name' => 'ROBOTS', 'content' => 'ALL'), null, array('inline' => false)));
		$view =& ClassRegistry::getObject('view');
		$result = $view->__scripts[0];
		$this->assertTags($result, array('meta' => array('name' => 'ROBOTS', 'content' => 'ALL')));
	}

/**
 * testTableHeaders method
 *
 * @access public
 * @return void
 */
	function testTableHeaders() {
		$result = $this->Html->tableHeaders(array('ID', 'Name', 'Date'));
		$expected = array('<tr', '<th', 'ID', '/th', '<th', 'Name', '/th', '<th', 'Date', '/th', '/tr');
		$this->assertTags($result, $expected);
	}

/**
 * testTableCells method
 *
 * @access public
 * @return void
 */
	function testTableCells() {
		$tr = array(
			'td content 1',
			array('td content 2', array("width" => "100px")),
			array('td content 3', "width=100px")
		);
		$result = $this->Html->tableCells($tr);
		$expected = array(
			'<tr',
			'<td', 'td content 1', '/td',
			array('td' => array('width' => '100px')), 'td content 2', '/td',
			array('td' => array('width' => 'preg:/100px/')), 'td content 3', '/td',
			'/tr'
		);
		$this->assertTags($result, $expected);

		$tr = array('td content 1', 'td content 2', 'td content 3');
		$result = $this->Html->tableCells($tr, null, null, true);
		$expected = array(
			'<tr',
			array('td' => array('class' => 'column-1')), 'td content 1', '/td',
			array('td' => array('class' => 'column-2')), 'td content 2', '/td',
			array('td' => array('class' => 'column-3')), 'td content 3', '/td',
			'/tr'
		);
		$this->assertTags($result, $expected);

		$tr = array('td content 1', 'td content 2', 'td content 3');
		$result = $this->Html->tableCells($tr, true);
		$expected = array(
			'<tr',
			array('td' => array('class' => 'column-1')), 'td content 1', '/td',
			array('td' => array('class' => 'column-2')), 'td content 2', '/td',
			array('td' => array('class' => 'column-3')), 'td content 3', '/td',
			'/tr'
		);
		$this->assertTags($result, $expected);

		$tr = array(
			array('td content 1', 'td content 2', 'td content 3'),
			array('td content 1', 'td content 2', 'td content 3'),
			array('td content 1', 'td content 2', 'td content 3')
		);
		$result = $this->Html->tableCells($tr, array('class' => 'odd'), array('class' => 'even'));
		$expected = "<tr class=\"even\"><td>td content 1</td> <td>td content 2</td> <td>td content 3</td></tr>\n<tr class=\"odd\"><td>td content 1</td> <td>td content 2</td> <td>td content 3</td></tr>\n<tr class=\"even\"><td>td content 1</td> <td>td content 2</td> <td>td content 3</td></tr>";
		$this->assertEqual($result, $expected);

		$tr = array(
			array('td content 1', 'td content 2', 'td content 3'),
			array('td content 1', 'td content 2', 'td content 3'),
			array('td content 1', 'td content 2', 'td content 3'),
			array('td content 1', 'td content 2', 'td content 3')
		);
		$result = $this->Html->tableCells($tr, array('class' => 'odd'), array('class' => 'even'));
		$expected = "<tr class=\"odd\"><td>td content 1</td> <td>td content 2</td> <td>td content 3</td></tr>\n<tr class=\"even\"><td>td content 1</td> <td>td content 2</td> <td>td content 3</td></tr>\n<tr class=\"odd\"><td>td content 1</td> <td>td content 2</td> <td>td content 3</td></tr>\n<tr class=\"even\"><td>td content 1</td> <td>td content 2</td> <td>td content 3</td></tr>";
		$this->assertEqual($result, $expected);

		$tr = array(
			array('td content 1', 'td content 2', 'td content 3'),
			array('td content 1', 'td content 2', 'td content 3'),
			array('td content 1', 'td content 2', 'td content 3')
		);
		$this->Html->tableCells($tr, array('class' => 'odd'), array('class' => 'even'));
		$result = $this->Html->tableCells($tr, array('class' => 'odd'), array('class' => 'even'), false, false);
		$expected = "<tr class=\"odd\"><td>td content 1</td> <td>td content 2</td> <td>td content 3</td></tr>\n<tr class=\"even\"><td>td content 1</td> <td>td content 2</td> <td>td content 3</td></tr>\n<tr class=\"odd\"><td>td content 1</td> <td>td content 2</td> <td>td content 3</td></tr>";
		$this->assertEqual($result, $expected);
	}

/**
 * testTag method
 *
 * @access public
 * @return void
 */
	function testTag() {
		$result = $this->Html->tag('div');
		$this->assertTags($result, '<div');

		$result = $this->Html->tag('div', 'text');
		$this->assertTags($result, '<div', 'text', '/div');

		$result = $this->Html->tag('div', '<text>', 'class-name');
		$this->assertTags($result, array('div' => array('class' => 'class-name'), 'preg:/<text>/', '/div'));

		$result = $this->Html->tag('div', '<text>', array('class' => 'class-name', 'escape' => true));
		$this->assertTags($result, array('div' => array('class' => 'class-name'), '&lt;text&gt;', '/div'));
	}

/**
 * testDiv method
 *
 * @access public
 * @return void
 */
	function testDiv() {
		$result = $this->Html->div('class-name');
		$this->assertTags($result, array('div' => array('class' => 'class-name')));

		$result = $this->Html->div('class-name', 'text');
		$this->assertTags($result, array('div' => array('class' => 'class-name'), 'text', '/div'));

		$result = $this->Html->div('class-name', '<text>', array('escape' => true));
		$this->assertTags($result, array('div' => array('class' => 'class-name'), '&lt;text&gt;', '/div'));
	}

/**
 * testPara method
 *
 * @access public
 * @return void
 */
	function testPara() {
		$result = $this->Html->para('class-name', '');
		$this->assertTags($result, array('p' => array('class' => 'class-name')));

		$result = $this->Html->para('class-name', 'text');
		$this->assertTags($result, array('p' => array('class' => 'class-name'), 'text', '/p'));

		$result = $this->Html->para('class-name', '<text>', array('escape' => true));
		$this->assertTags($result, array('p' => array('class' => 'class-name'), '&lt;text&gt;', '/p'));
	}
	
	/**
	 * function testSetTypes
	 * @param 
	 */
	
	function testSetTypes() {
		$html5Array = array(
		'html' => '<html%s>',
		'htmlend' => '</html>',
		'meta' => '<meta%s>',
		'metalink' => '<link href="%s"%s>',
		'link' => '<a href="%s"%s>%s</a>',
		'mailto' => '<a href="mailto:%s" %s>%s</a>',
		'form' => '<form %s>',
		'formend' => '</form>',
		'input' => '<input name="%s" %s>',
		'textarea' => '<textarea name="%s" %s>%s</textarea>',
		'hidden' => '<input type="hidden" name="%s" %s>',
		'checkbox' => '<input type="checkbox" name="%s" %s>',
		'checkboxmultiple' => '<input type="checkbox" name="%s[]"%s >',
		'radio' => '<input type="radio" name="%s" id="%s" %s >%s',
		'selectstart' => '<select name="%s"%s>',
		'selectmultiplestart' => '<select name="%s[]"%s>',
		'selectempty' => '<option value=""%s>&nbsp;</option>',
		'selectoption' => '<option value="%s"%s>%s</option>',
		'selectend' => '</select>',
		'optiongroup' => '<optgroup label="%s"%s>',
		'optiongroupend' => '</optgroup>',
		'checkboxmultiplestart' => '',
		'checkboxmultipleend' => '',
		'password' => '<input type="password" name="%s" %s>',
		'file' => '<input type="file" name="%s" %s>',
		'file_no_model' => '<input type="file" name="%s" %s>',
		'submit' => '<input %s>',
		'submitimage' => '<input type="image" src="%s" %s>',
		'button' => '<button type="%s"%s>%s</button>',
		'image' => '<img src="%s" %s>',
		'tableheader' => '<th%s>%s</th>',
		'tableheaderrow' => '<tr%s>%s</tr>',
		'tablecell' => '<td%s>%s</td>',
		'tablerow' => '<tr%s>%s</tr>',
		'block' => '<div%s>%s</div>',
		'blockstart' => '<div%s>',
		'blockend' => '</div>',
		'tag' => '<%s%s>%s</%s>',
		'tagstart' => '<%s%s>',
		'tagend' => '</%s>',
		'para' => '<p%s>%s</p>',
		'parastart' => '<p%s>',
		'label' => '<label for="%s"%s>%s</label>',
		'fieldset' => '<fieldset%s>%s</fieldset>',
		'fieldsetstart' => '<fieldset><legend>%s</legend>',
		'fieldsetend' => '</fieldset>',
		'legend' => '<legend>%s</legend>',
		'css' => '<link rel="%s" href="%s"%s>',
		'style' => '<style %s>%s</style>',
		'charset' => '<meta charset="%s">',
		'ul' => '<ul%s>%s</ul>',
		'ol' => '<ol%s>%s</ol>',
		'li' => '<li%s>%s</li>',
		'error' => '<div%s>%s</div>',
		'javascriptblock' => '<script%s>%s</script>',
		'javascriptstart' => '<script%s>',
		'javascriptlink' => '<script src="%s"%s></script>',
		'javascriptend' => '</script>',
		'header' => '<header%s>%s</header>',
		'footer' => '<footer%s>%s</footer>',
		'article' => '<article%s>%s</article>',
		'articlestart' => '<article%s>',
		'articleend' => '</article>',
		'section' => '<section%s>%s</section>',
		'nav' => '<nav%s>%s</nav>',
		'time' => '<time%s>%s</time>',
		'output' => '<ouput%s>%s</ouput>',
		'details' => '<details%s>%s</details>',
		'menu' => '<menu%s>%s</menu>',
		'command' => '<command%s>%s</command>'
	);
	$xhtmlArray = array(
		'meta' => '<meta%s/>',
		'metalink' => '<link href="%s"%s/>',
		'link' => '<a href="%s"%s>%s</a>',
		'mailto' => '<a href="mailto:%s" %s>%s</a>',
		'form' => '<form %s>',
		'formend' => '</form>',
		'input' => '<input name="%s" %s/>',
		'textarea' => '<textarea name="%s" %s>%s</textarea>',
		'hidden' => '<input type="hidden" name="%s" %s/>',
		'checkbox' => '<input type="checkbox" name="%s" %s/>',
		'checkboxmultiple' => '<input type="checkbox" name="%s[]"%s />',
		'radio' => '<input type="radio" name="%s" id="%s" %s />%s',
		'selectstart' => '<select name="%s"%s>',
		'selectmultiplestart' => '<select name="%s[]"%s>',
		'selectempty' => '<option value=""%s>&nbsp;</option>',
		'selectoption' => '<option value="%s"%s>%s</option>',
		'selectend' => '</select>',
		'optiongroup' => '<optgroup label="%s"%s>',
		'optiongroupend' => '</optgroup>',
		'checkboxmultiplestart' => '',
		'checkboxmultipleend' => '',
		'password' => '<input type="password" name="%s" %s/>',
		'file' => '<input type="file" name="%s" %s/>',
		'file_no_model' => '<input type="file" name="%s" %s/>',
		'submit' => '<input %s/>',
		'submitimage' => '<input type="image" src="%s" %s/>',
		'button' => '<button type="%s"%s>%s</button>',
		'image' => '<img src="%s" %s/>',
		'tableheader' => '<th%s>%s</th>',
		'tableheaderrow' => '<tr%s>%s</tr>',
		'tablecell' => '<td%s>%s</td>',
		'tablerow' => '<tr%s>%s</tr>',
		'block' => '<div%s>%s</div>',
		'blockstart' => '<div%s>',
		'blockend' => '</div>',
		'tag' => '<%s%s>%s</%s>',
		'tagstart' => '<%s%s>',
		'tagend' => '</%s>',
		'para' => '<p%s>%s</p>',
		'parastart' => '<p%s>',
		'label' => '<label for="%s"%s>%s</label>',
		'fieldset' => '<fieldset%s>%s</fieldset>',
		'fieldsetstart' => '<fieldset><legend>%s</legend>',
		'fieldsetend' => '</fieldset>',
		'legend' => '<legend>%s</legend>',
		'css' => '<link rel="%s" type="text/css" href="%s" %s/>',
		'style' => '<style type="text/css"%s>%s</style>',
		'charset' => '<meta http-equiv="Content-Type" content="text/html; charset=%s" />',
		'ul' => '<ul%s>%s</ul>',
		'ol' => '<ol%s>%s</ol>',
		'li' => '<li%s>%s</li>',
		'error' => '<div%s>%s</div>',
		'javascriptblock' => '<script type="text/javascript"%s>%s</script>',
		'javascriptstart' => '<script type="text/javascript">',
		'javascriptlink' => '<script type="text/javascript" src="%s"%s></script>',
		'javascriptend' => '</script>'
	);
	$html4Array = array(
		'meta' => '<meta%s>',
		'metalink' => '<link href="%s"%s>',
		'link' => '<a href="%s"%s>%s</a>',
		'mailto' => '<a href="mailto:%s" %s>%s</a>',
		'form' => '<form %s>',
		'formend' => '</form>',
		'input' => '<input name="%s"%s>',
		'textarea' => '<textarea name="%s"%s>%s</textarea>',
		'hidden' => '<input type="hidden" name="%s"%s>',
		'checkbox' => '<input type="checkbox" name="%s"%s>',
		'checkboxmultiple' => '<input type="checkbox" name="%s[]"%s>',
		'radio' => '<input type="radio" name="%s" id="%s"%s>%s',
		'selectstart' => '<select name="%s"%s>',
		'selectmultiplestart' => '<select name="%s[]"%s>',
		'selectempty' => '<option value=""%s>&nbsp;</option>',
		'selectoption' => '<option value="%s"%s>%s</option>',
		'selectend' => '</select>',
		'optiongroup' => '<optgroup label="%s"%s>',
		'optiongroupend' => '</optgroup>',
		'checkboxmultiplestart' => '',
		'checkboxmultipleend' => '',
		'password' => '<input type="password" name="%s"%s>',
		'file' => '<input type="file" name="%s" %s>',
		'file_no_model' => '<input type="file" name="%s"%s>',
		'submit' => '<input %s>',
		'submitimage' => '<input type="image" src="%s"%s>',
		'button' => '<button type="%s"%s>%s</button>',
		'image' => '<img src="%s"%s>',
		'tableheader' => '<th%s>%s</th>',
		'tableheaderrow' => '<tr%s>%s</tr>',
		'tablecell' => '<td%s>%s</td>',
		'tablerow' => '<tr%s>%s</tr>',
		'block' => '<div%s>%s</div>',
		'blockstart' => '<div%s>',
		'blockend' => '</div>',
		'tag' => '<%s%s>%s</%s>',
		'tagstart' => '<%s%s>',
		'tagend' => '</%s>',
		'para' => '<p%s>%s</p>',
		'parastart' => '<p%s>',
		'label' => '<label for="%s"%s>%s</label>',
		'fieldset' => '<fieldset%s>%s</fieldset>',
		'fieldsetstart' => '<fieldset><legend>%s</legend>',
		'fieldsetend' => '</fieldset>',
		'legend' => '<legend>%s</legend>',
		'css' => '<link rel="%s" type="text/css" href="%s"%s>',
		'style' => '<style type="text/css"%s>%s</style>',
		'charset' => '<meta http-equiv="Content-Type" content="text/html; charset=%s">',
		'ul' => '<ul%s>%s</ul>',
		'ol' => '<ol%s>%s</ol>',
		'li' => '<li%s>%s</li>',
		'error' => '<div%s>%s</div>',
		'javascriptblock' => '<script type="text/javascript"%s>%s</script>',
		'javascriptstart' => '<script type="text/javascript">',
		'javascriptlink' => '<script type="text/javascript" src="%s"%s></script>',
		'javascriptend' => '</script>'
	);
		$this->Html->__type = 'html5';
		$this->Html->_setTypes();
		$result = $this->Html->tags;
		foreach($result as $rtag) { echo "<pre>".htmlspecialchars($rtag)."</pre>"; }
		foreach($html5Array as $h5tag) { echo "<pre>".htmlspecialchars($h5tag)."</pre>";}
		$this->assertEqual($result, $html5Array, 'html5 tags array');
		
		$this->Html->__type = 'html4';
		$this->Html->_setTypes();
		$result = $this->Html->tags;
		foreach($result as $rtag) { echo "<pre>".htmlspecialchars($rtag)."</pre>"; }
		foreach($html4Array as $h4tag) { echo "<pre>".htmlspecialchars($h4tag)."</pre>";}
		$this->assertEqual($result, $html4Array, 'html4 tags array');
		
		$this->Html->__type = 'xhtml';
		$this->Html->_setTypes();
		$result = $this->Html->tags;
		//debug(array($result, $xhtmlArray));
		$this->assertEqual($result, $xhtmlArray, 'xhtml tags array');
	}
	
	/**
	 * function testCanvas
	 * @param 
	 */
	
	function testCanvas() {
		$result = $this->Html->canvas('class-name');
		$this->assertTags($result, array('canvas' => array('class' => 'class-name')));
		
		$result = $this->Html->canvas('class-name', array('id' => 'myCanvas'));
		$this->assertTags($result, array('canvas' => array('class' => 'class-name', 'id' => 'myCanvas')));
	}
	
	/**
	 * function testVideo
	 * @param 
	 */
	
	function testVideo() {
	}
	
	/**
	 * function testAudio
	 * @param 
	 */
	
	function testAudio() {
	}
	
	/**
	 * function testArticle
	 * @param 
	 */
	
	function testArticle() {
		
		$this->Html->__type = 'html5';
		$this->Html->_setTypes();
		$result = $this->Html->article('content');
		
		$expected = '<article>content</article>';
		$this->assertEqual($result, $expected, 'article html5 output');
		$result = $this->Html->article('content', array('id' => 'coolArticles', 'class' => array('line', 'news')));
		$expected = '<article id="coolArticles" class="line news">content</article>';
		$this->assertEqual($result, $expected);
		
		$this->Html->__type = 'xhtml';
		$this->Html->_setTypes();
		$expected = '<div id="coolArticles" class="article line news">content</div>';
		$result = $this->Html->article('content', array('id' => 'coolArticles', 'class' => array('line', 'news')));
		$this->assertEqual($result, $expected, 'article xhtml output');
		
		$this->Html->__type = 'html4';
		$this->Html->_setTypes();
		$expected = '<div id="coolArticles" class="article line news">content</div>';
		$result = $this->Html->article('content', array('id' => 'coolArticles', 'class' => array('line', 'news')));
		$this->assertEqual($result, $expected, 'article html4 output');
	}
	
	/**
	 * function testArticle
	 * @param 
	 */
	
	function testSection() {
		
		$this->Html->__type = 'html5';
		$this->Html->_setTypes();
		$result = $this->Html->section('content', 'my heading');
		
		$expected = '<section>content</section>';
		$this->assertEqual($result, $expected, 'section html5 output');
		$result = $this->Html->section('content', array('id' => 'coolsections', 'class' => array('line', 'news')));
		$expected = '<section id="coolsections" class="line news">content</section>';
		$this->assertEqual($result, $expected);
		
		$this->Html->__type = 'xhtml';
		$this->Html->_setTypes();
		$expected = '<div id="coolsections" class="section line news">content</div>';
		$result = $this->Html->section('content', array('id' => 'coolsections', 'class' => array('line', 'news')));
		$this->assertEqual($result, $expected, 'section xhtml output');
		
		$this->Html->__type = 'html4';
		$this->Html->_setTypes();
		$expected = '<div id="coolsections" class="section line news">content</div>';
		$result = $this->Html->section('content', array('id' => 'coolsections', 'class' => array('line', 'news')));
		$this->assertEqual($result, $expected, 'section html4 output');
	}
	
	
	/**
	 * function testNav
	 * @param 
	 */
	
	function testNav() {
		
		$this->Html->__type = 'html5';
		$this->Html->_setTypes();
		$result = $this->Html->nav('content');
		
		$expected = '<nav>content</nav>';
		$this->assertEqual($result, $expected, 'nav html5 output');
		$result = $this->Html->nav('content', array('id' => 'coolnavs', 'class' => array('line', 'news')));
		$expected = '<nav id="coolnavs" class="line news">content</nav>';
		$this->assertEqual($result, $expected);
		
		$this->Html->__type = 'xhtml';
		$this->Html->_setTypes();
		$expected = '<div id="coolnavs" class="nav line news">content</div>';
		$result = $this->Html->nav('content', array('id' => 'coolnavs', 'class' => array('line', 'news')));
		$this->assertEqual($result, $expected, 'nav xhtml output');
		
		$this->Html->__type = 'html4';
		$this->Html->_setTypes();
		$expected = '<div id="coolnavs" class="nav line news">content</div>';
		$result = $this->Html->nav('content', array('id' => 'coolnavs', 'class' => array('line', 'news')));
		$this->assertEqual($result, $expected, 'nav html4 output');
	}
	
	
	/**
	 * function testNav
	 * @param 
	 */
	
	function testTime() {
		$this->Html->__type = 'html5';
		$this->Html->_setTypes();
		
		$result = $this->Html->time(strtotime('1978-12-29 08:21:19'));
		$expected = '<time>Fri, Dec 29th 1978, 08:21</time>';
		//echo htmlspecialchars($result);
		//echo htmlspecialchars($expected);
		$this->assertEqual($result, $expected, 'time html5 output');
		
		$result = $this->Html->time(strtotime('1978-12-29 08:21:19'), array('pubdate' => true));
		$expected = '<time pubdate="Dec 29th 1978, 08:21">Fri, Dec 29th 1978, 08:21</time>';
		//echo htmlspecialchars($result);
		$this->assertEqual($result, $expected);
		
		$result = $this->Html->time(strtotime('1978-12-29 08:21:19'), array('pubdate' => true));
		$expected = '<time title="Published: Fri, Dec 29th 1978, 08:21">Dec 29th 1978, 08:21</time>';
		//echo htmlspecialchars($result);
		$this->assertEqual($result, $expected);
		
		$this->Html->__type = 'xhtml';
		$this->Html->_setTypes();
		
		$expected = '<span class="time" title="Published: Fri, Dec 29th 1978, 08:21">Dec 29th 1978, 08:21:19</span>';
		$result = $this->Html->time('1978-12-29 08:21:19', array('pubdate' => true));
		echo '<pre>'.htmlspecialchars($result).'</pre>';
		$this->assertEqual($result, $expected, 'time xhtml output');
		
		$expected = '<span class="time" title="Published: 29th Dec 1978, 8:21am">1978-12-29 08:21:19</span>';
		$result = $this->Html->time(strtotime('1978-12-29 08:21:19'), array('pubdate' => true));
		echo '<pre>'.htmlspecialchars($result).'</pre>';
		$this->assertEqual($result, $expected, 'time xhtml output');
		
		$result = $this->Html->time(strtotime('1978-12-29 08:21:19'), array('datetime' => true));
		$expected = '<span class="time" time="Date &amp; Time: 1978-12-29 08:21:19">29th December 1978, 8:21am</time>';
		echo '<pre>'.htmlspecialchars($result).'</pre>';
		$this->assertEqual($result, $expected);
		$expected = '<span class="time" title="Published: 1978-12-29 08:21:19">29th December 1978, 8:21am</span>';
		$result = $this->Html->time(strtotime('1978-12-29 08:21:19'), array('class' => array('myClass'), 'title' => array('Published','Y-M-D h:m:S')));
		echo '<pre>'.htmlspecialchars($result).'</pre>';
		$this->assertEqual($result, $expected, 'time xhtml output');
		
		$this->Html->__type = 'html4';
		$this->Html->_setTypes();
		$expected = '<span class="time myClass" title="Published: 1978-12-29 08:21:19">29th December 1978, 8:21am</span>';
		$result = $this->Html->time(strtotime('1978-12-29 08:21:19'), array('class' => array('myClass'), 'title' => array('Published','Y-M-D h:m:S')));
		echo '<pre>'.htmlspecialchars($result).'</pre>';
		$this->assertEqual($result, $expected, 'time html4 output');
	}
	
	
    
    /*
     * function testGetType
     */
    
    function testGetType() {
	$this->Html->start(array('docType' => 'html5'));
	echo $this->Html->getType();
	$this->assertTrue($this->Html->getType() == 'html5', 'html5 getType');
	$this->Html->start(array('docType' => 'html4'));
	echo $this->Html->getType();
	$this->assertTrue($this->Html->getType() == 'html4', 'html4 getType');
	$this->Html->start(array('docType' => 'xhtml-trans'));
	echo $this->Html->getType();
	$this->assertTrue($this->Html->getType() == 'xhtml', 'xhtml trans getType');
	
	$this->Html->start(array('docType' => 'html5'));
	echo $this->Html->getType();
	$this->assertTrue($this->Html->getType('short') == 'html5', 'html5 getType');
	$this->Html->start(array('docType' => 'html4'));
	echo $this->Html->getType();
	$this->assertTrue($this->Html->getType('short') == 'html4', 'html4 getType');
	$this->Html->start(array('docType' => 'xhtml-trans'));
	echo $this->Html->getType();
	$this->assertTrue($this->Html->getType('short') == 'xhtml', 'xhtml trans getType');
	
	$this->Html->start(array('docType' => 'html5'));
	echo $this->Html->getType();
	$result = $this->Html->getType('array');
	$this->assertEqual($result, array('html5'), 'html5 getType');

	$this->Html->start(array('docType' => 'html4'));
	echo $this->Html->getType();
	$result = $this->Html->getType('array');
	$this->assertEqual($result, array('html4', 'trans'), 'html4 getType');

	$this->Html->start(array('docType' => 'xhtml-trans'));
	echo $this->Html->getType();
	$result = $this->Html->getType('array');
	$this->assertEqual($result, array('xhtml', 'trans'), 'xhtml trans getType');
    }
	/**
	 * function testNav
	 * @param 
	 */
	
	function testIetag() {
		$expected = '<!--[if IE ]> <html class="no-js ie" lang="en"> <![endif]-->';
		$result = $this->Html->ietag('<html class="no-js ie" lang="en">');
		$this->assertEqual($result, $expected, 'all ie condition tag');

		$expected = '<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->';
		$result = $this->Html->ietag('<html class="no-js ie6" lang="en">', 'lt IE 7');
		$this->assertEqual($result, $expected, 'ie condition tag');

		$expected = '<!--[if (gte IE 9)|!(IE) ]><!--> <html class="no-js" lang="en"> <!--<![endif]-->';
		$result = $this->Html->ietag('<html class="no-js" lang="en">', '(gte IE 9)|!(IE)');
		$this->assertEqual($result, $expected, 'ie9 & non ie condition tag');

		$expected = '<!--[if !(IE) ]><!--> <html class="no-js yay" lang="en"> <!--<![endif]-->';
		$result = $this->Html->ietag('<html class="no-js yay" lang="en">', '!(IE)');
		//echo "<pre>".htmlspecialchars($expected)."</pre>";
		//echo "<pre>".htmlspecialchars($result)."</pre>";
		$this->assertEqual($result, $expected, 'non ie condition tag');
	}
}
