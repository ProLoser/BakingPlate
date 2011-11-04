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
	
	var $helpers = array('BakingPlate.HtmlPlus');
	
/**
 * Holds an instance of the view
 *
 * @var object
 */
	var $_View;
	
/**
 * Used for naming a store block of output
 *
 * @var string
 */
	var $__blockName = null;
	
/**
 * contruct
 * 	- allow defaults to be overridden
 * @param $settings array
 */
	public function __construct (View $View, $settings = array()) {
		// current view is used by analytics and capture ouput
		$this->_View = $View;
		$this->request = $View->request;

		Configure::load('BakingPlate.libs');
		
		parent::__construct($this->_View, $settings);
	}

/**
 * Creates an opening html tag with optional classes, conditional comments, manifet and language
 *
 * @param array $options
 * @example echo $this->Plate->html(array('ie' => true, 'manifest' => 'manifestname', 'lang' => 'override cfg', ''))
 * @link https://developer.mozilla.org/En/Offline_resources_in_Firefox
 */
	public function html($options = array()) {
		$options = array_merge(array(
			'lang' => Configure::read('Config.language'),
			'manifest' => null,
			'ie' => true,
			'js' => true,
			'class' => '',
		), $options);
		
		if ($options['js']) {
			// incase of existing class add space
			$options['class'] .= ' no-js';
		}
		unset($options['js']);
		
		if ($options['ie']) {
			$ie = $options['ie'];
			unset($options['ie']);
			// remove uneeded spaces (if no class was set in options)
			$options['class'] = trim($options['class']);
			$backup = $options;
			$content = '';
			// output a sequence of html tags to target ie versions and lastly all non ie browsers (including ie9 since it is mostly good)
			$options['class'] .= ' lt-ie9 lt-ie8 lt-ie7';
			$content .= $this->iecc($this->HtmlPlus->tag('html', null, $options), '<7') . "\n";
			$options = $backup;
			$options['class'] .= ' lt-ie9 lt-ie8';
			$content .= $this->iecc($this->HtmlPlus->tag('html', null, $options), 7) . "\n"; 
			$options = $backup;
			$options['class'] .= ' lt-ie9';
			$content .= $this->iecc($this->HtmlPlus->tag('html', null, $options), 8) . "\n"; 
			$options = $backup;
			$content .= $this->iecc($this->HtmlPlus->tag('html', null, $options), '>8', true);
		} else {
			$options = array_filter($options);
			$options['class'] = trim($options['class']);
			$content = $this->HtmlPlus->tag('html', null, $options);
		}

		return $content;
	}

/**
 * Returns a script tag to a cdn hosted js library
 *
 * @param string $name 
 * @param string $options 
 * @return void
 * @author Dean Sofer
 */
	public function lib($name, $options = array()) {
		$options = array_merge(array(
			'compressed' => true,
			'fallback' => null, // path/to/fallback/lib.js
		), Configure::read('BakingPlate.Libs.' . strtolower($name)), $options);
		$url = (!$options['compressed'] && !empty($options['cdnu'])) ? $options['cdnu'] : $options['cdn'];
		$url = str_replace(':version', $options['version'], $url);
		$content = $this->HtmlPlus->script($url);
		if (!empty($options['fallback_check']) && !empty($options['fallback'])) {
			$fallback = str_replace('</', '\x3C/', $this->HtmlPlus->script($options['fallback']));
			$fallback = $options['fallback_check'] . " || document.write('" . $fallback . "')";
			$content .= "\n" . $this->HtmlPlus->scriptBlock($fallback, array('safe' => false));
		}
		return $content;
	}

/**
 * dd_png
 * @param $fixClasses array of elements/classnames to fix
 */
	public function pngFix($selectors = array('img', '.png')) {
		$selectors = (is_array($selectors)) ? implode(', ', $selectors) : $selectors;
		$content = $this->HtmlPlus->script('libs/dd_belatedpng');
		$content .= $this->HtmlPlus->scriptBlock("DD_belatedPNG.fix('$selectors'); ", array('safe' => false));
		return $this->iecc($content, '<7');
	}

/**
 * Wrap the content in a set of ie conditional comments
 *
 * wrap content in a ie conditional comment - treat non ie targets as special case
 * @param string $content markup to be wrapped in ie condition
 * @param mixed $condition [true, false, '<7', '>8']
 * @param boolean $escape set to true to escape the cc for non-ie browsers
 */
	function iecc($content, $condition, $escape = false) {
		if ($condition === false) {
			$condition = ' !IE';
		} else {
			$cond = '';
			if (($pos = strpos($condition, '<')) !== false) {
				$cond = ' lt';
				$condition = trim($condition, '<');
			} elseif (($pos = strpos($condition, '>')) !== false) {
				$cond = ' gt';
				$condition = trim($condition, '>');
			}
			if ($pos !== false && $pos !== 0) {
				$cond .= 'e';
			}
			$condition = $cond . ' IE ' . $condition;
		}
		
		$pre = '<!--[if' . $condition . ']>';
		$post = '<![endif]-->';

		// if the iecondition is targeting non ie browsers prepend and append get adjusted
		if ($escape || strpos($condition, '!IE') !== false) {
			$pre .= '<!-->';
			$post = '<!--' . $post;
		}
		return $pre . ' ' .  $content . ' ' . $post;
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
	}

/** 
 * Start a block of output to display in layout 
 * 
 * @param string $name Will be prepended to form {$name}_for_layout variable  or leave blank to just use the output
 */ 
	function start($name = false) {
		if (!is_null($this->__blockName)) 
			trigger_error('PlateHelper::start - Blocks cannot overlap'); 

		$this->__blockName = $name; 
		ob_start(); 
		return null; 
	}

/** 
 * Ends a block of output to display in layout
 * 
 * @return string $buffer
 */ 
	function stop() { 
		if(is_null($this->__blockName)) 
			trigger_error('PlateHelper::stop - No blocks currently running');
		$buffer = @ob_get_contents(); 
		@ob_end_clean();
		if ($this->__blockName) {
			$this->_View->set($this->__blockName.'_for_layout', $buffer);
		}	
		$this->__blockName = null;
		return $buffer;
	}
	
/**
 * A tree list generator because all the other crap out there sucks
 *
 * @param array $data - works with find(threaded), untested with generateTreeList()
 * @param array $options 
 *	displayField - name: field to use for the link texts
 *	group - ul: tag to use for groups
 *	item - li: tag to use for items
 *	attributes - array(): attributes to pass to the group tag
 *	callback - null: specifies how the content should be generated
 *		null: use automatic link-generation
 *		false: just use displayField text
 *		string: method name as declared in AppHelper (usefull for any advanced customizations)
 * @param boolean $top - if this is the top level of the data array
 * @return string output
 * @author Dean Sofer
 */
	function tree($data, $options = array(), $callbackOptions = array(), $top = true) {
		if (empty($data))
			return;
			
		$options = array_merge(array(
			'displayField' => 'name',
			'group' => 'ul',
			'attributes' => array(),
			'item' => 'li',
			'callback' => null, // Set to false to disable autolinking. Set to a methodname as declared in AppHelper
		), $options);
			
		$result = '';
		$model = key($data[key($data)]);
		$i = 0;
		foreach ($data as $row) {
			if ($options['callback'] && method_exists($this, $options['callback'])) {
				$callbackOptions['top'] = $top;
				$content = $this->$options['callback']($row, $callbackOptions);
			} elseif ($options['callback'] === null) {
				$content = $this->HtmlPlus->link($row[$model][$options['displayField']], array('controller' => Inflector::tableize($model), 'action' => 'view', $row[$model]['id']));				
			} else {
				$content = $row[$model][$options['displayField']];
			}
			if (!empty($row['children'])) {
				$content .= $this->tree($row['children'], $options, $callbackOptions, false);
			}
			$i++;
			$altrow = ($i % 2 == 0) ? array('class' => 'altrow') : array();
			$result .= "\n\t" . $this->HtmlPlus->tag($options['item'], $content, $altrow);
		}
		return $this->HtmlPlus->tag($options['group'], $result . "\n", $options['attributes']);
	}
	
	
	/**
	 * Prompts IE6 users to install chrome frame if they don't have it. Remove to support IE6
	 *
	 * @return string
	 */
	public function chrome() {
		$cfcc = $this->lib('chrome-frame');
		$cfcc .= $this->HtmlPlus->scriptBlock('window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})', array('safe' => false));
		return $this->iecc($cfcc, '<7');
	}
}
