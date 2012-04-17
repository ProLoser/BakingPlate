<?php
/* HtmlPlus Test Cases
 * generated on: 2011-11-14 04:35:01 : 1321245301
 */
App::uses('Controller', 'Controller');
App::uses('Helper', 'View');
App::uses('AppHelper', 'View/Helper');
App::uses('HtmlPlusHelper', 'BakingPlate.View/Helper');

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
 * HtmlPlusHelper Test Case
 *
 */
class HtmlPlusHelperTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.post');

/**
 * html property
 *
 * @var object
 */
	public $Html = null;

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->View = $this->getMock('View', array('addScript'), array(new TheHtmlTestController()));
		$this->Html = new HtmlPlusHelper($this->View);
		//$this->Html->request = new CakeRequest(null, false);
		//$this->Html->request->webroot = '';
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->HtmlPlus);

		parent::tearDown();
	}

/**
 * test that scripts added with uses() are only ever included once.
 * test script tag generation
 *
 * @return void
 */
	public function testScript() {
		$result = $this->Html->script('foo');
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => 'js/foo.js')
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->script(array('foobar', 'bar'));
		$expected = array(
			array('script' => array('type' => 'text/javascript', 'src' => 'js/foobar.js')),
			'/script',
			array('script' => array('type' => 'text/javascript', 'src' => 'js/bar.js')),
			'/script',
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->script('jquery-1.3');
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => 'js/jquery-1.3.js')
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->script('test.json');
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => 'js/test.json.js')
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->script('http://example.com/test.json');
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => 'http://example.com/test.json')
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->script('/plugin/js/jquery-1.3.2.js?someparam=foo');
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => '/plugin/js/jquery-1.3.2.js?someparam=foo')
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->script('test.json.js?foo=bar');
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => 'js/test.json.js?foo=bar')
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
			'script' => array('type' => 'text/javascript', 'src' => 'js/jquery-1.3.2.js', 'defer' => 'defer', 'encoding' => 'utf-8')
		);
		$this->assertTags($result, $expected);

		$this->View->expects($this->any())->method('addScript')
			->with($this->matchesRegularExpression('/script_in_head.js/'));
		$result = $this->Html->script('script_in_head', array('inline' => false));
		$this->assertNull($result);
	}

/**
 * testTime method
 *
 * @return void
 */
	public function testTime() {
	}

/**
 * testDocType method
 *
 * @return void
 */
	public function testDocType() {
		$result = $this->Html->docType();
		$expected = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
		$this->assertEquals($expected, $result);

		$result = $this->Html->docType('html4-strict');
		$expected = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
		$this->assertEquals($expected, $result);

		$this->assertNull($this->Html->docType('non-existing-doctype'));
	}
}