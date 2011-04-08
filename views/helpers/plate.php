<?php
/**
 * Plate Helper class for easy use of HTML widgets.
 *
 * PlateHelper misc helper methods for use with apps baked with BakingPlate
 *
 * @package       cake
 * @subpackage    cake.cake.libs.view.helpers
 * @link http://book.cakephp.org/view/1434/HTML
 */

class PlateHelper extends AppHelper {
	var $helpers = array('Html', 'Form');
	var $_jsLibArr;
	var $_view;
	
	/**
	 * Used for naming a store block of output
	 *
	 * @var string
	 */
	var $__blockName = null;
	var $__forLayout = true;
	
	/**
	 * jsLibFallback
	 * @var array named content deployment networks
	 */
	private $_jsLibFallback = 'window.:name || document.write(\'<script src=":path/:lib-:version:min.js">\x3C/script>\')';
	
	/**
	 * jsLibDefaults
	 * @var array of base params of a jsLib
	 */
	private $_jsLibDefaults = array('fallback' => false, 'cdn' => false, 'theme' => false, 'min' => '.min');
	
	/**
	 * contruct
	 * 	- allow defaults to be overridden
	 * @param $settings array
	 */
	
	public function __construct ($settings = array()) {
		// current view is used by analytics and capture ouput
		$this->_view = &ClassRegistry::getObject('view');

		if(defined('JSLIBFALLBACK')) {
			$this->_jsLibFallback = JSLIBFALLBACK;
		}

		// try first app copy of jslibs load BP copy if not
		Configure::load('jslibs');
		
		if(!Configure::read('BakingPlate.JsLib')) {
			Configure::load('BakingPlate.jslibs');
		}
		
		$this->_jsLibArr = Configure::read('BakingPlate.JsLib');
	}

	/**
	 * open will create an initial block of html with auto or param based options
	 * @param $options mixed an optional array of options for use within the start block
	 * @example start(array('iecc' => true, 'manifest' => 'manifestname', 'lang' => 'override cfg', ''))
	*/
	public function open($options = null) {
		# NOTE: for manifesto
		# todo https://developer.mozilla.org/En/Offline_resources_in_Firefox
		
		$htmltag = $docType = '';
		$htmlAttribs = $manifest = $lang = array();
		$lang['lang'] = true;

		// manifest_for_layout
		if(!empty($options['manifest'])) {
			$manifestBase = Configure::read('Manifest.basePath') ? Configure::read('Manifest.basePath') . '/' : '/';
			$manifest['manifest'] = $manifestBase . $options['manifest'] . '.manifest';
		}
		
		if(!empty($options['lang'])) {
			$lang['lang'] = (($options['lang'] === true) && Configure::read('Config.language')) ? strtolower(Configure::read('Config.language')) : $options['lang'];
		} else {
			$lang['lang'] = false;
		}
		
		$htmlAttribs  = array_merge($manifest, $lang);
		if(isset($options['iecc']) && $options['iecc'] === true) {
			$ietag= '';
			$ies = array(6 => 'lt IE 7',7 => 'IE 7', 8 => 'IE 8');
			foreach($ies as $ieVersion => $condComm) {
				$htmltag.= "\n";
				$ietag = $this->Html->tag('html', null, array_merge($htmlAttribs, array('class' => 'no-js ie'.$ieVersion)));
				$htmltag.= $this->ietag($ietag, $condComm);
			}
			$htmltag.= "\n";
			$condComm = '(gte IE 9)|!(IE)';
			$ietag = $this->Html->tag('html', null, array_merge($htmlAttribs, array('class' => 'no-js')));
			$htmltag.= $this->ietag($ietag, $condComm);
		} elseif(isset($options['iecc']) && $options['iecc'] == 'IEMobile') {
			$ietag= '';
			$ies = array(7 => 'IEMobile 7', 8 => 'IEMobile 8');
			foreach($ies as $ieVersion => $condComm) {
				$htmltag.= "\n";
				$ietag = $this->Html->tag('html', null, array_merge($htmlAttribs, array('class' => 'no-js ie'.$ieVersion)));
				$htmltag.= $this->ietag($ietag, $condComm);
			}
			$htmltag.= "\n";
			$condComm = '(gte IEMobile 8)|!(IEMobile)';
			$ietag = $this->Html->tag('html', null, array_merge($htmlAttribs, array('class' => 'no-js')));
			$htmltag.= $this->ietag($ietag, $condComm);
		} else {
			$htmltag = "\n" . $this->Html->tag('html', null, $htmlAttribs);
		}

		if($docType == '') {
			$docType = $this->Html->docType();
		}

		return $docType . $htmltag . $this->Html->tag('head') . $this->Html->charset();
	}
	
	/**
	 * jsLibFallback
	 */
	public function jsLibFallback($key, $options) {
		$fallback = $this->_jsLibFallback;
		// set the name as some jslibs will be mixedcase js objects - but url will be lowercase
		// the name option maybe set to test the lib to determin if fallback should be loaded
		$options['name'] = (isset($options['name']) && $options['name'] !== $key) ? $options['name'] : $key;
		if(!empty($options['path'])) {
			$options['path'] = (!$options['theme']) ? $this->webroot . 'js/libs' : $this->webroot('/') . 'js/libs';
		}
		// todo use sprintf?
		foreach($options as $key => $value) {
			$fallback = str_replace(':'.$key, $value, $fallback);
		}
		return $fallback;
	}
	
	
	/**
	 * cdnlib
	 * @param options array of options eg host = google, lib = jquery, version = null, compressed = true
	 */
	function cdnLib($options) {
		// some jsLibs will be sourced from cdns
		$cdn = (!empty($options['cdn'])) ? $options['cdn'] : ':lib-:version:min';
		foreach($options as $key => $value) {
			// when jsLib uses local cdn and theme place an extra / 
			$value = ($key == 'theme' && $options['cdn'] == 'local')  ? "$value/": "$value";
			$cdn = str_replace(':'.$key, $value, $cdn);
		} 
	    return $cdn;
	}
	
	
	/**
	 * jsLib
	 * @example jsLib()
	 * @example jsLib(array('cdn' => <cdName>, 'lib' => <libName>, 'version' => <versionRelease>))
	 * @param array of javascrip library options such as cdn, libname, version, minification
	 */
	public function jsLib($lib = false) {

		if(!$lib) return;
		$jsLib = array();
		$jsLibsCfg = Configure::read('BakingPlate.JsLib');

		if(is_string($lib) && !empty($jsLibsCfg[$lib])) {
			$jsLib = $jsLibsCfg[$lib];
		} elseif(is_array($lib)) {
			//  todo handle array of libs eg for jquery ui and yahoo profiler
			return;
		}

		$jsLib = array_merge($this->_jsLibDefaults, $jsLib); // var to concat build to return including fallback if set etc
		
		if(!empty($jsLib['url'])) return $this->Html->script('url');

		$jsLib['min'] = (!isset($jsLib['compressed']) || $jsLib['compressed'] === true) ? '.min' : '';
		$name = $lib;
		$lib = $this->Html->script($this->cdnLib($jsLib));
		
		if($jsLib['fallback']) {
			$lib.= $this->Html->scriptBlock($this->jsLibFallback($name, $jsLib), array('safe' => false));
		}

		return $lib;
	}

	/**
	 * dd_png
	 * @param $fixClasses array of elements/classnames to fix
	 */
	public function pngFix($classes = array('img', '.png')) {
		$classes = (is_array($classes)) ? implode(', ', $classes) : $classes;
		$pngFix = $this->Html->script(array('libs/dd_belatedpng')) .
		$this->Html->scriptBlock("DD_belatedPNG.fix('$classes'); ", array('safe' => false));
		return $this->conditionalComment($pngFix, -7);
	}

	/**
	 * profiling
	 * outputs yahoo profiling code - only if admin is logged in and debug is set
	 * @param void
	 */   
	public function profiling() {
	    return $this->Html->script(array('profiling/yahoo-profiling.min', 'profiling/config'));
	}
	
	/**
	 * the following two methods do the same thing in different ways
	 * the first does not output non ie (ie+ would be the arg to output
	 * ie9 and non ie browsers so internet explorer plus other better
	 * browsers) == (gte IE 9)|!(IE)
	 *
	 * the second can output non ie tags with the second arg being
	 * (gte IE 9)|!(IE) to give you non the same ie+
	 *
	 * also we have IEMobile to consider I have PlatePlus outputing this
	 * correctly and will mv these commits to BakingPlate
	 *
	 * start uses the 2nd and start the 1st
	 *
	 * so one survives but which
	 */

	/**
	 * conditionalComment
	 * outputs an ie conditional comment containing content
	 * @example conditionalComment('all ies')
	 * @example conditionalComment('just ie7 and below', -7)
	 * @param $content string of content
	 * @param $ie mixed true for all ie -or- false for non ie -or- string ie condition
	 */
	public function conditionalComment($content, $ie = true) {
		$iee = 'IE';
		$template = '<!--[if %2$s ]>%1$s<![endif]-->';
		if($ie !== false) {
			if($ie < 0) {
				// lessthan equal to the reverse of the negtive number
				$iee = abs($ie);
				$template = '<!--[if lt IE %2$d ]>%1$s<![endif]-->';
			} elseif(is_numeric($ie)) {
				// straight number
				$iee = 'IE';
				$template = '<!--[if IE %2$s ]>%1$s<![endif]-->';
			} elseif(strpos($ie, 'IEMobile') !== false) {
				$ie = str_replace('IEMobile', '', $ie);
				if($ie < 0) {
					// lessthan equal to the reverse of the negtive number
					$iee = abs($ie);
					$template = '<!--[if lt IEMobile %2$d ]>%1$s<![endif]-->';
				} else {
					// straight number
					$iee = $ie;
					$template = '<!--[if IEMobile %2$s ]>%1$s<![endif]-->';
				}
			}
		} else {
		    // not ie a 
		}

		if(is_array($content)) {
			$output = '';
			foreach($content as $iec) {
				$iec = str_replace("\\r\\n", "\\r\\n\\t",  $iec);
				$output.= "\n$iec\n";
			}
		    return sprintf($template, $output, $iee);
		}
		
		if(strpos($content, "\\r\\n"))   {
			$content = str_replace("\\r\\n", "\\r\\n\\t",  $content);
			$content = "\n$content\n";
		}
	    return sprintf($template, $content, $iee);
	}

	/**
	 * ietag
	 * wrap content in a ie conditional comment - treat non ie targets as special case
	 * @param $content string markup to be wrapped in ie condition
	 * @param $iecond string an ie condition
	 */
	function ietag($content, $iecond = 'IE') {
		$pre = '<!--[if '.$iecond.' ]> ';
		$post = ' <![endif]-->';
		if(strpos($iecond, '!(IE)') !== false) {
			$pre = trim($pre);
			$pre .= '<!--> ';
			$post = ' <!--' . trim($post);
		}
	    return $pre . $content . $post;
	}
	
	/**
	 * chromeFrame
	 * outputs a chromFrame meta innvocation
	 * @param void
	 */
	public function chromeFrame() {
	    return $this->Html->meta(array('http-equiv' => 'X-UA-Compatible', 'content' => 'IE=edge,chrome=1'));
	}
	
	/**
	 * analytics
	 * outputs google analytics code - only if on live domain and the GA id is set
	 * @todo
	 * 	- move elemets to plugin
	 * 	- make the app elements override the plugins
	 * @param $element string to override the default (elements should be moved into plugin)
	 */
	public function analytics($code = '') {
		if (empty($code))
			$code = Configure::read('Site.analytics');
			
		if (!empty($code) && !Configure::read('debug')) {	
			if (substr($code, 0, 3) != 'UA-')
				$code = 'UA-' . $code;
		    	return $this->_view->element('analytics', array('plugin' => 'BakingPlate', 'code' => $code));
		}
		#$element = !empty($element) ? $element : 'extras/google_analytics';
		#return $this->_currentView->element($element, array('google_analytics' => $GoogleAnalytics));
	}
	
	/**
	 * siteVerification
	 * output single or set of seo verification metas
	 * @param $name mixed string meta name or array of meta names
	 * @param $name mixed string meta content or array of meta content
	 */
	public function siteVerification($name, $content) {
		if(is_array($name) && is_array($content)) {
			$metas = count($name);
			if(!($metas == count($content))) return null;
			$meta = '';
			for($i = 0; $i < $metas; $i++) {
				$meta.= $this->Html->meta('meta', null, array('name' => $name[$i], 'content' => $content[$i]));
			}
		    return $meta;
		} else {
		    return $this->Html->tag('meta', null, compact('name', 'content'));
		}
	}

	/**
	 * modernizr
	 * @todo
	 * 	- resolve path issues
	 * @param $options mixed array of options to override cfg build settings
	 * @author Sam Sherlock
	 */
	public function modernizr() {
		return $this->jsLib('modernizr');
	}

		
	/**
	 * function firebugLite
	 *
	 * @param void
	 * @return string script tag for firebug lite
	 */
	public function firebugLite() {
		return $this->Html->script('https://getfirebug.com/firebug-lite.js');
	}
	
	public function mediaQueriesJS() {
		$mediaQueries = $this->jsLib('css3-mediaqueries');
		return $this->conditionalComment($mediaQueries, "IEMobile 7");
	}
	
	/**
	 * siteIcons - outputs all meta tags for various types of favicons, iOS touch
	 * todo
	*/
	public function siteIcons($icon) {
	}


	/** 
	 * Start a block of output to display in layout 
	 * 
	 * @param string $name Will be prepended to form {$name}_for_layout variable 
	 * @param boolean $forLayout (optional) Set to false to prevent appending '_for_layout' to variable name
	 */ 
	function start($name, $forLayout = true) {
		if(!is_null($this->__blockName)) 
			trigger_error('PlateHelper::start - Blocks cannot overlap'); 

		$this->__blockName = $name; 
		ob_start(); 
		return null; 
	}

	/** 
	 * Ends a block of output to display in layout 
	 */ 
	function stop() { 
		if(is_null($this->__blockName)) 
			trigger_error('PlateHelper::stop - No blocks currently running');
		$buffer = @ob_get_contents(); 
		@ob_end_clean(); 
		$name = ($this->__forLayout) ? $this->__blockName.'_for_layout' : $this->__blockName;
		$this->_view->set($name, $buffer); 
		$this->__blockName = null;
		return $buffer;
	}
}
