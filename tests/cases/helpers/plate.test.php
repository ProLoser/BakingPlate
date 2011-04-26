<?php
//App::import('Core', array('Helper', 'AppHelper', 'ClassRegistry', 'Controller', 'Model', 'Folder'));
App::import('Helper', array('BakingPlate.HtmlPlus', 'BakingPlate.FormPlus', 'BakingPlate.Plate'));

//if (!defined('FULL_BASE_URL')) {
//	define('FULL_BASE_URL', 'http://cakephp.org');
//}
//
//if (!defined('TEST_APP')) {
//	define('TEST_APP', APP . 'tests' . DS . 'test_app' . DS);
//	//die(TEST_APP);
//}
//
//if (!defined('JS')) {
//	define('JS', TEST_APP . 'webroot' . DS . 'js' . DS);
//}
//
//if (!defined('CSS')) {
//	define('CSS', TEST_APP . 'webroot' . DS . 'css' . DS);
//}
//
//if (!defined('THEME')) {
//	define('THEME', TEST_APP . 'webroot' . DS . 'theme' . DS);
//}


/**
 * TheHtmlTestController class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.view.helpers
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



class PlateHelperTestCase extends CakeTestCase {

	/**
	 * @var object
	 * @access public
	 */
	var $Html = null;
	var $Form = null;
	var $Plate = null;
	var $View = null;

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
		$this->Plate =& new PlateHelper();
		$this->Plate->HtmlPlus =& new HtmlPlusHelper();
		$this->View = $view;
		$this->_appEncoding = Configure::read('App.encoding');
		$this->_asset = Configure::read('Asset');
		$this->_debug = Configure::read('debug');
	}
	
	/**
	 * endTest method
	 *
	 * @access public
	 * @return void
	 */
	function endTest() {
		Configure::write('App.encoding', $this->_appEncoding);
		ClassRegistry::flush();
		unset($this->Html);
		unset($this->Form);
		unset($this->Plate);
	}

	function testHtml() {
		$result = $expected = '';
		Configure::write('Config.language', 'en-gb');
		$result = $this->Plate->html();
		Configure::write('Config.language', $this->_appEncoding);
		$expected = '<!--[if lt IE 7]> <html lang="en-gb" class="no-js ie6"> <![endif]--><!--[if IE 7]> <html lang="en-gb" class="no-js ie7"> <![endif]--><!--[if IE 8]> <html lang="en-gb" class="no-js ie8"> <![endif]--><!--[if gt IE 8]><!--> <html lang="en-gb" class="no-js"> <!--<![endif]-->';
		$result = str_replace(array("\n", "\r"), '', $result);
		$this->assertEqual($result, $expected, 'no settings passed');
		
		$result = $this->Plate->html(array('ie' => true, 'manifest' => '/app.cache', 'lang' => 'en-Cockney', 'class' => 'joy'));
		$result = str_replace(array("\n", "\r"), '', $result);
		$expected = '<!--[if lt IE 7]> <html lang="en-Cockney" manifest="/app.cache" class="joy no-js ie6"> <![endif]--><!--[if IE 7]> <html lang="en-Cockney" manifest="/app.cache" class="joy no-js ie7"> <![endif]--><!--[if IE 8]> <html lang="en-Cockney" manifest="/app.cache" class="joy no-js ie8"> <![endif]--><!--[if gt IE 8]><!--> <html lang="en-Cockney" manifest="/app.cache" class="joy no-js"> <!--<![endif]-->';
		$this->assertEqual($result, $expected, 'settings passed');
	}

	function testLib() {
		$this->Plate->HtmlPlus->webroot = '/';
		Configure::write('BakingPlate.Libs.jquery', array(
				'cdn' => '//ajax.googleapis.com/ajax/libs/jquery/:version/jquery.min.js',
				'cdnu' => '//ajax.googleapis.com/ajax/libs/jquery/:version/jquery.js',
				'version' => '1.5.2',
				'fallback_check' => 'window.jQuery',
			)
		);
		
		$expected = array(
				'script' => array('src' => '//ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js')
		);
		
		$result = $this->Plate->lib('jquery', array('fallback' => false));
		$this->assertTags($result, $expected, false, 'JS Lib Test Using jquery default 2.2 from google its minified');
		
		$settings = array(
				'cdn' => '//ajax.googleapis.com/ajax/libs/jquery/:version/jquery.min.js',
				'cdnu' => '//ajax.googleapis.com/ajax/libs/jquery/:version/jquery.js',
				'version' => '1.3.2',
				'fallback_check' => 'window.jQuery',
				'fallback' => 'libs/jquery-1.3.2.min'
		    );

		$expected = '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>' . "\n" . 
		    '<script>window.jQuery || document.write(\'<script src="/js/libs/jquery-1.3.2.min.js">\x3C/script>\')</script>';
		$result = $this->Plate->lib('jquery', $settings);
		$this->assertEqual($result, $expected, 'JS Lib Test Using jquery default 1.3.2 from google its minified with fallback');

		$expected = '<script src="//ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>' . "\n" . 
		    '<script>window.swfobject || document.write(\'<script src="/js/libs/swfobject.js">\x3C/script>\')</script>';
		$result = $this->Plate->lib('swfobject', array('fallback' => 'libs/swfobject'));
		$this->assertEqual($result, $expected, 'JS Lib Test Using SwfOject 2.2 with fallback');
	}

	function testAnalytics() {
		Configure::write('Site.analytics', 'UA-9870-123');

	$GA1 = <<<GA1
<script>
   var _gaq = [['_setAccount', 'UA-9870-123'], ['_trackPageview']];
   (function(d, t) {
    var g = d.createElement(t),
        s = d.getElementsByTagName(t)[0];
    g.async = true;
    g.src = ('https:' == location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g, s);
   })(document, 'script');
</script>
GA1;

	$GA2 = <<<GA2
<script>
   var _gaq = [['_setAccount', 'UA-2707-123'], ['_trackPageview']];
   (function(d, t) {
    var g = d.createElement(t),
        s = d.getElementsByTagName(t)[0];
    g.async = true;
    g.src = ('https:' == location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g, s);
   })(document, 'script');
</script>
GA2;
		$expected = $GA1;
		Configure::write('debug', 0);
		$result = $this->Plate->analytics();
		Configure::write('debug', $this->_debug);
		$result = str_replace(array("\n", "\r", "\t"), '', $result);
		$expected = str_replace(array("\n", "\r", "\t"), '', $expected);
		$this->assertEqual($result, $expected, 'Google Analytics no arg');
		
		$expected = $GA2;
		Configure::write('debug', 0);
		$result = $this->Plate->analytics('2707-123');
		Configure::write('debug', $this->_debug);
		$result = str_replace(array("\n", "\r", "\t"), '', $result);
		$expected = str_replace(array("\n", "\r", "\t"), '', $expected);
		$this->assertEqual($result, $expected, 'Google Anlaytics Passing id');
	}
	function testStartStop() {
	    $aside_for_layout = '';
	    $AS1 = <<<AS1
		<aside>
			<h3>This is an aside</h3>
			<p>An aside is tangental to the subject of the section or article</p>
			<p>Though it is still relevent.</p>
		</aside>
AS1;
	
		$this->Plate->start('aside');
		?>
		<aside>
			<h3>This is an aside</h3>
			<p>An aside is tangental to the subject of the section or article</p>
			<p>Though it is still relevent.</p>
		</aside><?php
		$this->Plate->stop();

		$result = $this->View->getVar('aside_for_layout');
		$expected = $AS1;
		$result = str_replace(array("\n", "\r", "\t"), '', $result);
		$expected = str_replace(array("\n", "\r", "\t"), '', $expected);
		$this->assertEqual($result, $expected, 'Capture Output');

		$aside_for_layout = '';
		
		$AS2 = <<<AS2
		<aside>
			<h3>My Thing</h3>
			<p>An aside is tangental to the subject of the section or article</p>
			<p>Though it is still relevent.</p>
		</aside>
AS2;
	
		$this->Plate->start('myThing', false);
		?>
		<aside>
			<h3>My Thing</h3>
			<p>An aside is tangental to the subject of the section or article</p>
			<p>Though it is still relevent.</p>
		</aside><?php
		$result = $this->Plate->stop();
		
		$expected = $AS2;
		$result = str_replace(array("\n", "\r", "\t"), '', $result);
		$expected = str_replace(array("\n", "\r", "\t"), '', $expected);
		$this->assertEqual($result, $expected, 'Capture Output');


	}
}


?>