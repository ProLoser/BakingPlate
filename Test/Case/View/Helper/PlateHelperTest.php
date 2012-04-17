<?php
/**
 * Plate Test Cases
 * created 2011-11-14 04:35:16 : 1321245316
 */
App::uses('Controller', 'Controller');
App::uses('Helper', 'View');
App::uses('AppHelper', 'View/Helper');
App::uses('HtmlPlusHelper', 'BakingPlate.View/Helper');
App::uses('PlateHelper', 'BakingPlate.View/Helper');

if (!defined('FULL_BASE_URL')) {
	define('FULL_BASE_URL', 'http://cakephp.org');
}

/**
 * TheHtmlTestController class
 *
 * @package       Cake.Test.Case.View.Helper
 */
class TheHtmlTestController extends Controller {

/**
 * name property
 *
 * @var string 'TheTest'
 */
	public $name = 'TheTest';

/**
 * uses property
 *
 * @var mixed null
 */
	public $uses = null;
}

/**
 * PlateHelper Test Case
 *
 */
class PlateHelperTestCase extends CakeTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->View = $this->getMock('View', array('addScript'), array(new TheHtmlTestController()));
		$this->Plate = new PlateHelper($this->View);
		$this->HtmlPlus = new HtmlPlusHelper($this->View);
		$this->_appEncoding = Configure::read('App.encoding');
		$this->_lang = Configure::read('Config.language');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Plate);

		parent::tearDown();
	}

/**
 * testHtml method
 *
 * @return void
 */
	public function testHtml() {
		Configure::write('Config.language', 'en-gb');
		$result = $this->Plate->html();
		Configure::write('Config.language', $this->_lang);
		$expected = '<!--[if lt IE 7]> <html lang="en-gb" class="no-js ie6"> <![endif]--><!--[if IE 7]> <html lang="en-gb" class="no-js ie7"> <![endif]--><!--[if IE 8]> <html lang="en-gb" class="no-js ie8"> <![endif]--><!--[if gt IE 8]><!--> <html lang="en-gb" class="no-js"> <!--<![endif]-->';
		$this->assertEqual($result, $expected, 'no settings passed');

		$result = $this->Plate->html(array('ie' => true, 'manifest' => '/app.cache', 'lang' => 'en-Cockney', 'class' => 'joy'));
		$expected = '<!--[if lt IE 7]> <html lang="en-Cockney" manifest="/app.cache" class="joy no-js ie6"> <![endif]--><!--[if IE 7]> <html lang="en-Cockney" manifest="/app.cache" class="joy no-js ie7"> <![endif]--><!--[if IE 8]> <html lang="en-Cockney" manifest="/app.cache" class="joy no-js ie8"> <![endif]--><!--[if gt IE 8]><!--> <html lang="en-Cockney" manifest="/app.cache" class="joy no-js"> <!--<![endif]-->';
		$this->assertEqual($result, $expected, 'settings passed');

		$result = $this->Plate->html(array('ie' => false));
		$expected = '<html lang="' . $this->_lang . '" class="no-js">';
		$this->assertEqual($result, $expected, 'ie false');

		$result = $this->Plate->html(array('ie' => false, 'lang' => false));
		$expected = '<html class="no-js">';
		$result = str_replace(array("\n", "\r"), '', $result);
		$this->assertEqual($result, $expected, 'ie false');
	}

/**
 * testLib method
 *
 * @return void
 */
	public function testLib() {
		$this->Plate->HtmlPlus->webroot = '/';
		Configure::write('BakingPlate.Libs.jquery',
			array(
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

/**
 * testPngFix method
 *
 * @return void
 */
	public function testPngFix() {
		$expected = '';
		$result = $this->Plate->pngFix();
		$expected = "<!--[if lt IE 7]> <script src=\"js/libs/dd_belatedpng.js\"></script><script>DD_belatedPNG.fix('img, .png'); </script> <![endif]-->";
		$this->assertEqual($result, $expected, 'Png Fix');
	}

/**
 * testIecc method
 *
 * @return void
 */
	public function testIecc() {
		$result = $expected = '';
		$result = $this->Plate->iecc('<p>Just for IE</p>', 'IE');
		$expected = '<!--[if IE]> <p>Just for IE</p> <![endif]-->';
		$this->assertEqual($result, $expected, 'just for ie');

		$result = '';
		$result = $this->Plate->iecc('<p>Just for IE</p>');
		$this->assertEqual($result, $expected, 'just for ie more basic');

		$result = '';
		$result = $this->Plate->iecc('<p>Just for IE</p>', true);
		$this->assertEqual($result, $expected, 'just for ie TRUE basic ');

		$result = $expected = '';
		$result = $this->Plate->iecc('<p>Just for IE 5.5</p>', '5.5');
		$expected = '<!--[if IE 5.5]> <p>Just for IE 5.5</p> <![endif]-->';
		$this->assertEqual($result, $expected, 'Just for IE 5.5');

		$result = $expected = '';
		$result = $this->Plate->iecc('<p>Just for IE less than or equal to 5.5</p>', '5.5<');
		$expected = '<!--[if lte IE 5.5]> <p>Just for IE less than or equal to 5.5</p> <![endif]-->';
		$this->assertEqual($result, $expected, 'Just for IE less than or equal to 5.5');

		$result = $expected = '';
		$result = $this->Plate->iecc('<p>Just for IE 8 and less</p>', '8<');
		$expected = '<!--[if lte IE 8]> <p>Just for IE 8 and less</p> <![endif]-->';
		$this->assertEqual($result, $expected, 'just for ie 8 and less ');

		$result = $expected = '';
		$result = $this->Plate->iecc('<p>just for ie 9 and non ie browsers</p>', 9, true);
		$expected = '<!--[if IE 9]><!--> <p>just for ie 9 and non ie browsers</p> <!--<![endif]-->';
		$this->assertEqual($result, $expected, 'just for ie 9 and non ie browsers');

		$result = $expected = '';
		$result = $this->Plate->iecc('<p>just for ie 9 and non ie browsers STRING</p>', '9', true);
		$expected = '<!--[if IE 9]><!--> <p>just for ie 9 and non ie browsers STRING</p> <!--<![endif]-->';
		$this->assertEqual($result, $expected, 'just for ie 9 and non ie browsers STRING');

		$result = $expected = '';
		$result = $this->Plate->iecc('<p>Not for IE and just the really nice, nice browsers</p>', '!IE', true);
		$expected = '<!--[if !IE]><!--> <p>Not for IE and just the really nice, nice browsers</p> <!--<![endif]-->';
		$this->assertEqual($result, $expected, 'Just not for IE and just the really nice, nice browsers');

		$result = $expected = '';
		$result = $this->Plate->iecc('<p>Not for IE and just the really nice, nice browsers</p>', '>9', true);
		$expected = '<!--[if gt IE 9]><!--> <p>Not for IE and just the really nice, nice browsers</p> <!--<![endif]-->';
		$this->assertEqual($result, $expected, 'Not for IE and just the really nice, nice browsers');

		$result = $expected = '';
		$result = $this->Plate->iecc('<p>Not for IE < 9; just the really nice, nice browsers (including ie9)</p>', '9>', true);
		$expected = '<!--[if gte IE 9]><!--> <p>Not for IE < 9; just the really nice, nice browsers (including ie9)</p> <!--<![endif]-->';
		$this->assertEqual($result, $expected, 'Not for IE < 9; just the really nice, nice browsers (including ie9)');

		$result = $expected = '';
		$result = $this->Plate->iecc('<p>Not for IE < 9; just the ie9+</p>', '9>');
		$expected = '<!--[if gte IE 9]> <p>Not for IE < 9; just the ie9+</p> <![endif]-->';
		$this->assertEqual($result, $expected, 'Not for IE < 9; just the ie9+');

		$result = $expected = '';
		$result = $this->Plate->iecc('<p>Not for IE < 9; just the ie9+</p>', 'gte IE 9');
		$expected = '<!--[if gte IE 9]> <p>Not for IE < 9; just the ie9+</p> <![endif]-->';
		$this->assertEqual($result, $expected, 'Passing a built string');

		$result = $expected = '';
		$result = $this->Plate->iecc('<p>Not for IE < 9; just the ie9+</p>', '(gte IE 9|!IE)');
		$expected = '<!--[if (gte IE 9|!IE)]><!--> <p>Not for IE < 9; just the ie9+</p> <!--<![endif]-->';
		$this->assertEqual($result, $expected, 'Passing a built string - that auto escapes');
	}

/**
 * testAnalytic method
 *
 * @return void
 */
	public function testAnalytic() {
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
		Configure::write('debug', 2);
		$this->assertEqual($result, $expected, 'Google Analytics no arg');

		$expected = $GA2;
		Configure::write('debug', 0);
		$result = $this->Plate->analytics('2707-123');
		Configure::write('debug', 2);
		$this->assertEqual($result, $expected, 'Google Anlaytics Passing id');
	}

/**
 * testStart method
 *
 * @return void
 */
	public function testStart() {
	}

/**
 * testStop method
 *
 * @return void
 */
	public function testStop() {
	}

/**
 * testTree method
 *
 * @return void
 */
	public function testTree() {
	}

/**
 * testChrome method
 *
 * @return void
 */
	public function testChrome() {
	}

}
