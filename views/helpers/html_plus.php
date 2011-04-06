<?php
/**
 * Html Helper class file.
 *
 * Simplifies the construction of HTML elements.
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
 * @subpackage    cake.cake.libs.view.helpers
 * @since         CakePHP(tm) v 0.9.1
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::import('Helper', 'Html');
/**
 * Html Helper class for easy use of HTML widgets.
 *
 * HtmlHelper encloses all methods needed while working with HTML pages.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.view.helpers
 * @link http://book.cakephp.org/view/1434/HTML
 */
class HtmlPlusHelper extends HtmlHelper {

	/**
	 * html tags used by this helper.
	 *
	 * @var array
	 * @access public
	 */
	var $tags = array(
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
		// @depeciated
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
	    'command' => '<command%s>%s</command>',
	    'canvas' => '<canvas%s>%s</canvas>'
	);

	/**
	 * Breadcrumbs.
	 *
	 * @var array
	 * @access protected
	 */
	var $_crumbs = array();

	/**
	 * Names of script files that have been included once
	 *
	 * @var array
	 * @access private
	 */
	var $__includedScripts = array();

	/**
	 * Options for the currently opened script block buffer if any.
	 *
	 * @var array
	 * @access protected
	 */
	var $_scriptBlockOptions = array();

	/**
	 * Document type definitions
	 *
	 * @var array
	 * @access private
	 */
	var $__docTypes = array(
		'html5' => '<!doctype html>'
	);

	var $__presentational_classes = array();


	/*
	 * function getType
	 * @param $format mixed long, short or array default is short
	 * @deprecated
	 */
	function getType() {
		//self::;
	}
	
	

	/**
	 * Returns a doctype string.
	 *
	 * Possible doctypes:
	 *
	 *  - html5:  HTML5.
	 *  - html4-strict:  HTML4 Strict.
	 *  - html4-trans:  HTML4 Transitional.
	 *  - html4-frame:  HTML4 Frameset.
	 *  - xhtml-strict: XHTML1 Strict.
	 *  - xhtml-trans: XHTML1 Transitional.
	 *  - xhtml-frame: XHTML1 Frameset.
	 *  - xhtml11: XHTML1.1.
	 *
	 * @todo
	 * 	- make html4 or xhtml the default
	 * @param string $type Doctype to use.
	 * @return string Doctype string
	 * @access public
	 * @link http://book.cakephp.org/view/1439/docType
	 */
	function docType($type = 'html5') {
		if (isset($this->__docTypes[$type])) {
			$this->__type = $type;
		    return $this->__docTypes[$type];
		}
	    return null;
	}

	/**
	 * Creates a link to an external resource and handles basic meta tags
	 *
	 * ### Options
	 *
	 * - `inline` Whether or not the link element should be output inline, or in scripts_for_layout.
	 *
	 * @param string $type The title of the external resource
	 * @param mixed $url The address of the external resource or string for content attribute
	 * @param array $options Other attributes for the generated tag. If the type attribute is html,
	 *    rss, atom, or icon, the mime-type is returned.
	 * @return string A completed `<link />` element.
	 * @access public
	 * @link http://book.cakephp.org/view/1438/meta
	 */
	function meta($type, $url = null, $options = array()) {
		$inline = isset($options['inline']) ? $options['inline'] : true;
		unset($options['inline']);

		if (!is_array($type)) {
			$types = array(
				'rss'	=> array('type' => 'application/rss+xml', 'rel' => 'alternate', 'title' => $type, 'link' => $url),
				'atom'	=> array('type' => 'application/atom+xml', 'title' => $type, 'link' => $url),
				'icon'	=> array('type' => 'image/x-icon', 'rel' => 'icon', 'link' => $url),
				'keywords' => array('name' => 'keywords', 'content' => $url),
				'description' => array('name' => 'description', 'content' => $url),
				'author' => array('name' => 'author', 'content' => str_replace('http://', '', $url)),
			);

			if ($type === 'icon' && $url === null) {
				$types['icon']['link'] = $this->webroot('favicon.ico');
			}

			if (isset($types[$type])) {
				$type = $types[$type];
			} elseif (!isset($options['type']) && $url !== null) {
				if (is_array($url) && isset($url['ext'])) {
					$type = $types[$url['ext']];
				} else {
					$type = $types['rss'];
				}
			} elseif (isset($options['type']) && isset($types[$options['type']])) {
				$type = $types[$options['type']];
				unset($options['type']);
			} else {
				$type = array();
			}
		} elseif ($url !== null) {
			$inline = $url;
		}
		$options = array_merge($type, $options);
		$out = null;

		if (isset($options['link'])) {
			if (isset($options['rel']) && $options['rel'] === 'icon') {
				$out = sprintf($this->tags['metalink'], $options['link'], $this->_parseAttributes($options, array('link'), ' ', ' '));
				$options['rel'] = 'shortcut icon';
			} else {
				$options['link'] = $this->url($options['link'], true);
			}
			$out .= sprintf($this->tags['metalink'], $options['link'], $this->_parseAttributes($options, array('link'), ' ', ' '));
		} else {
			$out = sprintf($this->tags['meta'], $this->_parseAttributes($options, array('type'), ' ', ' '));
		}

		if ($inline) {
			return $out;
		} else {
			$view =& ClassRegistry::getObject('view');
			$view->addScript($out);
		}
	}

	/**
	 * Creates a link element for CSS stylesheets.
	 *
	 * ### Options
	 *
	 * - `inline` If set to false, the generated tag appears in the head tag of the layout. Defaults to true
	 *
	 * @param mixed $path The name of a CSS style sheet or an array containing names of
	 *   CSS stylesheets. If `$path` is prefixed with '/', the path will be relative to the webroot
	 *   of your application. Otherwise, the path will be relative to your CSS path, usually webroot/css.
	 * @param string $rel Rel attribute. Defaults to "stylesheet". If equal to 'import' the stylesheet will be imported.
	 * @param array $options Array of HTML attributes.
	 * @return string CSS <link /> or <style /> tag, depending on the type of link.
	 * @access public
	 * @link http://book.cakephp.org/view/1437/css
	 */


	/**
	 * Returns one or many `<script>` tags depending on the number of scripts given.
	 *
	 * If the filename is prefixed with "/", the path will be relative to the base path of your
	 * application.  Otherwise, the path will be relative to your JavaScript path, usually webroot/js.
	 *
	 * Can include one or many Javascript files.
	 *
	 * ### Options
	 *
	 * - `inline` - Whether script should be output inline or into scripts_for_layout.
	 * - `once` - Whether or not the script should be checked for uniqueness. If true scripts will only be
	 *   included once, use false to allow the same script to be included more than once per request.
	 *
	 * @param mixed $url String or array of javascript files to include
	 * @param mixed $options Array of options, and html attributes see above. If boolean sets $options['inline'] = value
	 * @return mixed String of `<script />` tags or null if $inline is false or if $once is true and the file has been
	 *   included before.
	 * @access public
	 * @link http://book.cakephp.org/view/1589/script
	 */
	function script($url, $options = array()) {
		if (is_bool($options)) {
			list($inline, $options) = array($options, array());
			$options['inline'] = $inline;
		}
		$options = array_merge(array('inline' => true, 'once' => true, 'defer' => false, 'async' => false), $options);
		if (is_array($url)) {
			$out = '';
			foreach ($url as $i) {
				$out .= "\n\t" . $this->script($i, $options);
			}
			if ($options['inline'])  {
			    return $out . "\n";
			}
		    return null;
		}
		if ($options['once'] && isset($this->__includedScripts[$url])) {
			return null;
		}
		if ($options['defer']) {
			$options['defer'] = true;
		}
		if ($options['async']) {
			$options['async'] = true;
		}
		$this->__includedScripts[$url] = true;

		if (strpos($url, '://') === false) {
			if (substr($url, 0, 2) !== '//' && $url[0] !== '/') {
				$url = JS_URL . $url;
			}
			if (strpos($url, '?') === false && substr($url, -3) !== '.js') {
				$url .= '.js';
			}
			$url = $this->assetTimestamp($this->webroot($url));

			if (Configure::read('Asset.filter.js')) {
				$url = str_replace(JS_URL, 'cjs/', $url);
			}
		}
		$attributes = $this->_parseAttributes($options, array('inline', 'once'), ' ');
		$out = sprintf($this->tags['javascriptlink'], $url, $attributes);

		if ($options['inline']) {
			return $out;
		} else {
			$view =& ClassRegistry::getObject('view');
			$view->addScript($out);
		}
	}

	/**
	 * start creates an initial block of html with auto or param based options
	 * https://developer.mozilla.org/En/Offline_resources_in_Firefox
	 *
	 * @param $options mixed an optional array of options for use within the start block
	 * @example start(array('multihtml' => true, 'manifest' => 'manifestname', 'lang' => 'override cfg', ''))
	*/
	function start($options = null) {
		$htmltag = $docType = '';
		$htmlAttribs = $manifest = $lang = array();
		
		$options['docType'] = (!isset($options['docType']) || $options['docType'] === false) ? $this->__type : $options['docType'];
		
		$options['docType'] = ($options['docType'] == 'html4' || $options['docType'] == 'xhtml') ? $options['docType'] . '-trans' : $options['docType'];
		$lang['lang'] = true;

		// manifest_for_layout
		if(isset($options['manifest']) &&  ($options['manifest'] !== '' ||  $options['manifest'] !== false)) {
			$manifestBase = Configure::read('Manifest.basePath') ? Configure::read('Manifest.basePath') . '/' : '/';
			$manifest['manifest'] = $manifestBase . $options['manifest'] . '.manifest';
		}
		
		if(isset($options['lang']) && $options['lang'] !== false) {
			$lang['lang'] = (($options['lang'] === true) && Configure::read('Config.language')) ? strtolower(Configure::read('Config.language')) : $options['lang'];
		} else {
			$lang['lang'] = false;
		}

		if(isset($options['docType']) && $options['docType'] !== false) {
			$docType = $this->docType($options['docType']);
		}
		
		$htmlAttribs  = array_merge($manifest, $lang);
		if(!empty($options['iecc'])) {
			$ietag= '';
			$ies = array(6 => 'lt IE 7',7 => 'IE 7', 8 => 'IE 8');
			foreach($ies as $ieVersion => $condComm) {
				$htmltag.= "\n";
				$ietag = $this->tag('html', null, array_merge($htmlAttribs, array('class' => 'no-js ie'.$ieVersion)));
				$htmltag.= $this->ietag($ietag, $condComm);
			}
			$htmltag.= "\n";
			$condComm = '(gte IE 9)|!(IE)';
			$ietag = $this->tag('html', null, array_merge($htmlAttribs, array('class' => 'no-js')));
			$htmltag.= $this->ietag($ietag, $condComm);
		} else {
			$htmltag = "\n" . $this->tag('html', null, $htmlAttribs);
		}

		if($docType == '') {
			$docType = $this->docType();
		}

		return $docType . $htmltag . "\n<head>\n\t" . $this->charset() . "\n";
	}

	/**
	 * ietag
	 * @deprecated moved to proper home plate helper
	 * @param $content string markup to be wrapped in ie condition
	 * @param $iecond string an ie condition
	 */
	function ietag($content, $iecond = 'IE') {
		$pre = '<!--[if '.$iecond.' ]> ';
		$post = ' <![endif]-->';
		//debug($iecond);
		//debug(strpos($iecond, '!(IE)'));
		//debug(strpos($iecond, '!(IE)') !== false ? 'yay' : 'nay');
		if(strpos($iecond, '!(IE)') !== false) {
			$pre = trim($pre);
			$pre .= '<!--> ';
			$post = ' <!--' . trim($post);
		}
	    return $pre . $content . $post;
	}

	/*
	 * function addPresentationalClass
	 * @todo
	 * 	- the array of presenational class names get removed before markup is output
	 * @param $name string a presentational classname
	 */
	function addPresentationalClass($name) {
	    $this->__presentational_classes[$name];
	}

//	function _parseAttributes($options, $exclude = null, $insertBefore = ' ', $insertAfter = null) {
//            parent::_parseAttributes($options, $exclude, $insertBefore, $insertAfter);
//            return $out ? $insertBefore . $out . $insertAfter : '';
//        }
}
