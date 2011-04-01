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
	var $__type = 'html5';

	/**
	 * Document type definitions
	 *
	 * @var array
	 * @access private
	 */
	var $__docTypes = array(
		'html5' => '<!doctype html>',
		'html4-strict'  => '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">',
		'html4-trans'  => '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">',
		'html4-frame'  => '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">',
		'xhtml-strict' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">',
		'xhtml-trans' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
		'xhtml-frame' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">',
		'xhtml11' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">'
	);

	var $__presentational_classes = array();

	/**
	 * Adds a link to the breadcrumbs array.
	 *
	 * @param string $name Text for link
	 * @param string $link URL for link (if empty it won't be a link)
	 * @param mixed $options Link attributes e.g. array('id'=>'selected')
	 * @return void
	 * @see HtmlHelper::link() for details on $options that can be used.
	 * @access public
	 */
	function addCrumb($name, $link = null, $options = null) {
		$this->_crumbs[] = array($name, $link, $options);
	}

	/**
	 * function _setTypes
	 * @todo
	 * 	- someting need resolving here it may be the tests (wade through output)
	 * @param $arg
	 */
	function _setTypes() {
		switch(strtolower(substr($this->__type, 0, 5)))    {
			case 'html5':
				$this->tags = array(
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
				    'command' => '<command%s>%s</command>',
				    'canvas' => '<canvas%s>%s</canvas>'
				);
			break;
			case 'html4':
				$this->tags = array(
				    'html' => '<html%s>',
				    'htmlend' => '</html>',
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
			case 'xhtml':
				$this->tags = array(
				    'html' => '<html%s>',
				    'htmlend' => '</html>',
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
		}
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

	/*
	 * function getType
	 * @param $format mixed long, short or array default is short
	 */
	function getType($format = 'short') {
	    switch($format) {
		case 'array':
		    return explode('-', $this->__type);
		case 'long':
		    return explode('-', $this->__type);
		case 'short':
		    $hyphenPos = strpos($this->__type, '-');
		    return ($hyphenPos !== false) ? substr($this->__type, 0, $hyphenPos) : $this->__type;
	    }
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
				$out = sprintf($this->tags['metalink'], $options['link'], $this->_parseAttributes($options, array('link'), ' ', ($this->__type == 'html5') ? '' : ' '));
				$options['rel'] = 'shortcut icon';
			} else {
				$options['link'] = $this->url($options['link'], true);
			}
			$out .= sprintf($this->tags['metalink'], $options['link'], $this->_parseAttributes($options, array('link'), ' ', ($this->__type == 'html5') ? '' : ' '));
		} else {
			$out = sprintf($this->tags['meta'], $this->_parseAttributes($options, array('type'), ' ', ($this->__type == 'html5') ? '' : ' '));
		}

		if ($inline) {
			return $out;
		} else {
			$view =& ClassRegistry::getObject('view');
			$view->addScript($out);
		}
	}

	/**
	 * Returns a charset META-tag.
	 *
	 * @param string $charset The character set to be used in the meta tag. If empty,
	 *  The App.encoding value will be used. Example: "utf-8".
	 * @return string A meta tag containing the specified character set.
	 * @access public
	 * @link http://book.cakephp.org/view/1436/charset
	 */
	function charset($charset = null) {
		return sprintf($this->tags['charset'], (!empty($charset) ? $charset : strtolower(Configure::read('App.encoding'))));
	}

	/**
	 * Creates an HTML link.
	 *
	 * If $url starts with "http://" this is treated as an external link. Else,
	 * it is treated as a path to controller/action and parsed with the
	 * HtmlHelper::url() method.
	 *
	 * If the $url is empty, $title is used instead.
	 *
	 * ### Options
	 *
	 * - `escape` Set to false to disable escaping of title and attributes.
	 *
	 * @param string $title The content to be wrapped by <a> tags.
	 * @param mixed $url Cake-relative URL or array of URL parameters, or external URL (starts with http://)
	 * @param array $options Array of HTML attributes.
	 * @param string $confirmMessage JavaScript confirmation message.
	 * @return string An `<a />` element.
	 * @access public
	 * @link http://book.cakephp.org/view/1442/link
	 */
	function link($title, $url = null, $options = array(), $confirmMessage = false) {
		$escapeTitle = true;
		if ($url !== null) {
			$url = $this->url($url);
		} else {
			$url = $this->url($title);
			$title = $url;
			$escapeTitle = false;
		}

		if (isset($options['escape'])) {
			$escapeTitle = $options['escape'];
		}

		if ($escapeTitle === true) {
			$title = h($title);
		} elseif (is_string($escapeTitle)) {
			$title = htmlentities($title, ENT_QUOTES, $escapeTitle);
		}

		if (!empty($options['confirm'])) {
			$confirmMessage = $options['confirm'];
			unset($options['confirm']);
		}
		if ($confirmMessage) {
			$confirmMessage = str_replace("'", "\'", $confirmMessage);
			$confirmMessage = str_replace('"', '\"', $confirmMessage);
			$options['onclick'] = "return confirm('{$confirmMessage}');";
		} elseif (isset($options['default']) && $options['default'] == false) {
			if (isset($options['onclick'])) {
				$options['onclick'] .= ' event.returnValue = false; return false;';
			} else {
				$options['onclick'] = 'event.returnValue = false; return false;';
			}
			unset($options['default']);
		}
		return sprintf($this->tags['link'], $url, $this->_parseAttributes($options), $title);
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
	function css($path, $rel = null, $options = array()) {
		/**
		 * todo: themes are borked for non html5 (very borked need to ensure that type is returned in string)
		 *      timestamps are borked
		*/
		$options += array('inline' => true);
		if (is_array($path)) {
			$out = '';
			foreach ($path as $i) {
				$out .= "\n\t" . $this->css($i, $rel, $options);
			}
			if ($options['inline'])  {
				return $out . "\n";
			}
			return;
		}

		if (strpos($path, '://') !== false) {
			$url = $path;
		} else {
			if ($path[0] !== '/') {
				$path = CSS_URL . $path;
			}

			if (strpos($path, '?') === false) {
				if (substr($path, -4) !== '.css') {
					$path .= '.css';
				}
			}
			$url = $this->assetTimestamp($this->webroot($path));

			if (Configure::read('Asset.filter.css')) {
				$pos = strpos($url, CSS_URL);
				if ($pos !== false) {
					$url = substr($url, 0, $pos) . 'ccss/' . substr($url, $pos + strlen(CSS_URL));
				}
			}
		}

		if ($rel == 'import') {
			$out = sprintf($this->tags['style'], $this->_parseAttributes($options, array('inline'), '', ($this->__type == 'html5' ? '' : ' ')), '@import url(' . $url . ');');
		} else {
			if ($rel == null) {
				$rel = 'stylesheet';
			}
			$out = sprintf($this->tags['css'], $rel, $url, $this->_parseAttributes($options, array('inline'), ($this->__type == 'html5' ? '' : ' '), ' '));
		}

		if ($options['inline']) {
			return $out;
		} else {
			$view =& ClassRegistry::getObject('view');
			$view->addScript($out);
		}
	}

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
		$prefix = '';
		if (strpos($url, '://') === false) {
			if (substr($url, 0, 2) !== '//' && $url[0] !== '/') {
				$url = JS_URL . $url;
			} elseif(substr($url, 0, 2) == '//') {
			    //$prefix = '/';
			}
			if (strpos($url, '?') === false && substr($url, -3) !== '.js') {
				$url .= '.js';
			}
			$url = $this->assetTimestamp($this->webroot($url));

			if (Configure::read('Asset.filter.js')) {
				$url = str_replace(JS_URL, 'cjs/', $url);
			}
		}

		$attributes = $this->_parseAttributes($options, array('inline', 'once'), ($this->__type == 'html5' ? '' : ' '));
		$out = sprintf($this->tags['javascriptlink'], $prefix.$url, $attributes);

		if ($options['inline']) {
		    return $out;
		} else {
			$view =& ClassRegistry::getObject('view');
			$view->addScript($out);
		}
	}

	/**
	 * Wrap $script in a script tag.
	 *
	 * ### Options
	 *
	 * - `safe` (boolean) Whether or not the $script should be wrapped in <![CDATA[ ]]>
	 * - `inline` (boolean) Whether or not the $script should be added to $scripts_for_layout or output inline
	 *
	 * @param string $script The script to wrap
	 * @param array $options The options to use.
	 * @return mixed string or null depending on the value of `$options['inline']`
	 * @access public
	 * @link http://book.cakephp.org/view/1604/scriptBlock
	 */
	function scriptBlock($script, $options = array()) {
		$options += array('safe' => ($this->__type == 'html5' ? false : true), 'inline' => true);
		if ($options['safe']) {
			$script  = "\n" . '//<![CDATA[' . "\n" . $script . "\n" . '//]]>' . "\n";
		}
		$inline = $options['inline'];
		unset($options['inline'], $options['safe']);
		$attributes = $this->_parseAttributes($options, ($this->__type == 'html5' ? '' : ' '), ($this->__type == 'html5' ? '' : ' '));
		if ($inline) {
		    return sprintf($this->tags['javascriptblock'], $attributes, $script);
		} else {
			$view =& ClassRegistry::getObject('view');
			$view->addScript(sprintf($this->tags['javascriptblock'], $attributes, $script));
		    return null;
		}
	}

	/**
	 * Begin a script block that captures output until HtmlHelper::scriptEnd()
	 * is called. This capturing block will capture all output between the methods
	 * and create a scriptBlock from it.
	 *
	 * ### Options
	 *
	 * - `safe` Whether the code block should contain a CDATA
	 * - `inline` Should the generated script tag be output inline or in `$scripts_for_layout`
	 *
	 * @param array $options Options for the code block.
	 * @return void
	 * @access public
	 * @link http://book.cakephp.org/view/1605/scriptStart
	 */
	function scriptStart($options = array()) {
		$options += array('safe' => ($this->__type == 'html5' ? '' : ' '), 'inline' => true);
		$this->_scriptBlockOptions = $options;
		ob_start();
	    return null;
	}

	/**
	 * End a Buffered section of Javascript capturing.
	 * Generates a script tag inline or in `$scripts_for_layout` depending on the settings
	 * used when the scriptBlock was started
	 *
	 * @return mixed depending on the settings of scriptStart() either a script tag or null
	 * @access public
	 * @link http://book.cakephp.org/view/1606/scriptEnd
	 */
	function scriptEnd() {
		$buffer = ob_get_clean();
		$options = $this->_scriptBlockOptions;
		$this->_scriptBlockOptions = array();
	    return $this->scriptBlock($buffer, $options);
	}

	/**
	 * Builds CSS style data from an array of CSS properties
	 *
	 * ### Usage:
	 *
	 * {{{
	 * echo $html->style(array('margin' => '10px', 'padding' => '10px'), true);
	 *
	 * // creates
	 * 'margin:10px;padding:10px;'
	 * }}}
	 *
	 * @param array $data Style data array, keys will be used as property names, values as property values.
	 * @param boolean $oneline Whether or not the style block should be displayed on one line.
	 * @return string CSS styling data
	 * @access public
	 * @link http://book.cakephp.org/view/1440/style
	 */
	function style($data, $oneline = true) {
		if (!is_array($data)) {
		    return $data;
		}
		$out = array();
		foreach ($data as $key=> $value) {
		    $out[] = $key.':'.$value.';';
		}
		if ($oneline) {
		    return join(' ', $out);
		}
	    return implode("\n", $out);
	}

	/**
	 * Returns the breadcrumb trail as a sequence of &raquo;-separated links.
	 *
	 * @param string $separator Text to separate crumbs.
	 * @param string $startText This will be the first crumb, if false it defaults to first crumb in array
	 * @return string Composed bread crumbs
	 * @access public
	 */
	function getCrumbs($separator = '&raquo;', $startText = false) {
		if (!empty($this->_crumbs)) {
			$out = array();
			if ($startText) {
				$out[] = $this->link($startText, '/');
			}

			foreach ($this->_crumbs as $crumb) {
				if (!empty($crumb[1])) {
					$out[] = $this->link($crumb[0], $crumb[1], $crumb[2]);
				} else {
					$out[] = $crumb[0];
				}
			}
		    return join($separator, $out);
		} else {
		    return null;
		}
	}

	/**
	 * Creates a formatted IMG element. If `$options['url']` is provided, an image link will be
	 * generated with the link pointed at `$options['url']`.  This method will set an empty
	 * alt attribute if one is not supplied.
	 *
	 * ### Usage
	 *
	 * Create a regular image:
	 *
	 * `echo $html->image('cake_icon.png', array('alt' => 'CakePHP'));`
	 *
	 * Create an image link:
	 *
	 * `echo $html->image('cake_icon.png', array('alt' => 'CakePHP', 'url' => 'http://cakephp.org'));`
	 *
	 * @param string $path Path to the image file, relative to the app/webroot/img/ directory.
	 * @param array $options Array of HTML attributes.
	 * @return string completed img tag
	 * @access public
	 * @link http://book.cakephp.org/view/1441/image
	 */
	function image($path, $options = array()) {
		if (is_array($path)) {
			$path = $this->url($path);
		} elseif (strpos($path, '://') === false) {
			if ($path[0] !== '/') {
				$path = IMAGES_URL . $path;
			}
			$path = $this->assetTimestamp($this->webroot($path));
		}

		if (!isset($options['alt'])) {
			$options['alt'] = '';
		}

		$url = false;
		if (!empty($options['url'])) {
			$url = $options['url'];
			unset($options['url']);
		}

		$image = sprintf($this->tags['image'], $path, $this->_parseAttributes($options, null, '', ' '));

		if ($url) {
		    return sprintf($this->tags['link'], $this->url($url), null, $image);
		}
	    return $image;
	}

	/**
	 * Returns a row of formatted and named TABLE headers.
	 *
	 * @param array $names Array of tablenames.
	 * @param array $trOptions HTML options for TR elements.
	 * @param array $thOptions HTML options for TH elements.
	 * @return string Completed table headers
	 * @access public
	 * @link http://book.cakephp.org/view/1446/tableHeaders
	 */
	function tableHeaders($names, $trOptions = null, $thOptions = null) {
		$out = array();
		foreach ($names as $arg) {
			$out[] = sprintf($this->tags['tableheader'], $this->_parseAttributes($thOptions), $arg);
		}
	    return sprintf($this->tags['tablerow'], $this->_parseAttributes($trOptions), join(' ', $out));
	}

	/**
	 * Returns a formatted string of table rows (TR's with TD's in them).
	 *
	 * @param array $data Array of table data
	 * @param array $oddTrOptions HTML options for odd TR elements if true useCount is used
	 * @param array $evenTrOptions HTML options for even TR elements
	 * @param bool $useCount adds class "column-$i"
	 * @param bool $continueOddEven If false, will use a non-static $count variable,
	 *    so that the odd/even count is reset to zero just for that call.
	 * @return string Formatted HTML
	 * @access public
	 * @link http://book.cakephp.org/view/1447/tableCells
	 */
	function tableCells($data, $oddTrOptions = null, $evenTrOptions = null, $useCount = false, $continueOddEven = true) {
		if (empty($data[0]) || !is_array($data[0])) {
			$data = array($data);
		}

		if ($oddTrOptions === true) {
			$useCount = true;
			$oddTrOptions = null;
		}

		if ($evenTrOptions === false) {
			$continueOddEven = false;
			$evenTrOptions = null;
		}

		if ($continueOddEven) {
			static $count = 0;
		} else {
			$count = 0;
		}

		foreach ($data as $line) {
			$count++;
			$cellsOut = array();
			$i = 0;
			foreach ($line as $cell) {
				$cellOptions = array();

				if (is_array($cell)) {
					$cellOptions = $cell[1];
					$cell = $cell[0];
				} elseif ($useCount) {
					$cellOptions['class'] = 'column-' . ++$i;
				}
				$cellsOut[] = sprintf($this->tags['tablecell'], $this->_parseAttributes($cellOptions), $cell);
			}
			$options = $this->_parseAttributes($count % 2 ? $oddTrOptions : $evenTrOptions);
			$out[] = sprintf($this->tags['tablerow'], $options, implode(' ', $cellsOut));
		}
	    return implode("\n", $out);
	}

	/**
	 * Returns a formatted block tag, i.e DIV, SPAN, P.
	 *
	 * @todo
	 *	- `escape` Whether or not the contents should be html_entity escaped.
	 *
	 * @param string $name Tag name.
	 * @param string $text String content that will appear inside the div element.
	 *   If null, only a start tag will be printed
	 * @param array $options Additional HTML attributes of the DIV tag, see above.
	 * @return string The formatted tag element
	 * @access public
	 * @link http://book.cakephp.org/view/1443/tag
	 */
	function tag($name, $text = null, $options = array()) {
		if (is_array($options) && isset($options['escape']) && $options['escape']) {
			$text = h($text);
			unset($options['escape']);
		}
		if (!is_array($options)) {
			$options = array('class' => $options);
		}
		if ($text === null) {
			$tag = 'tagstart';
		} else {
			$tag = 'tag';
		}
	    return sprintf($this->tags[$tag], $name, $this->_parseAttributes($options, null, ' ', ''), $text, $name);
	}

	/**
	 * Returns a formatted DIV tag for HTML FORMs.
	 *
	 * ### Options
	 *
	 * - `escape` Whether or not the contents should be html_entity escaped.
	 *
	 * @param string $class CSS class name of the div element.
	 * @param string $text String content that will appear inside the div element.
	 *   If null, only a start tag will be printed
	 * @param array $options Additional HTML attributes of the DIV tag
	 * @return string The formatted DIV element
	 * @access public
	 * @link http://book.cakephp.org/view/1444/div
	 */
	function div($class = null, $text = null, $options = array()) {
		if (!empty($class)) {
			$options['class'] = $class;
		}
	    return $this->tag('div', $text, $options);
	}

	/**
	 * Returns a formatted P tag.
	 *
	 * ### Options
	 *
	 * - `escape` Whether or not the contents should be html_entity escaped.
	 *
	 * @param string $class CSS class name of the p element.
	 * @param string $text String content that will appear inside the p element.
	 * @param array $options Additional HTML attributes of the P tag
	 * @return string The formatted P element
	 * @access public
	 * @link http://book.cakephp.org/view/1445/para
	 */
	function para($class, $text, $options = array()) {
		if (isset($options['escape'])) {
			$text = h($text);
		}
		if ($class != null && !empty($class)) {
			$options['class'] = $class;
		}
		if ($text === null) {
			$tag = 'parastart';
		} else {
			$tag = 'para';
		}
	    return sprintf($this->tags[$tag], $this->_parseAttributes($options, null, ' ', ''), $text);
	}

	/**
	 * Build a nested list (UL/OL) out of an associative array.
	 *
	 * @param array $list Set of elements to list
	 * @param array $options Additional HTML attributes of the list (ol/ul) tag or if ul/ol use that as tag
	 * @param array $itemOptions Additional HTML attributes of the list item (LI) tag
	 * @param string $tag Type of list tag to use (ol/ul)
	 * @return string The nested list
	 * @access public
	 */
	function nestedList($list, $options = array(), $itemOptions = array(), $tag = 'ul') {
		if (is_string($options)) {
			$tag = $options;
			$options = array();
		}
		$items = $this->__nestedListItem($list, $options, $itemOptions, $tag);
	    return sprintf($this->tags[$tag], $this->_parseAttributes($options, null, ' ', ''), $items);
	}

	/**
	 * Internal function to build a nested list (UL/OL) out of an associative array.
	 *
	 * @param array $items Set of elements to list
	 * @param array $options Additional HTML attributes of the list (ol/ul) tag
	 * @param array $itemOptions Additional HTML attributes of the list item (LI) tag
	 * @param string $tag Type of list tag to use (ol/ul)
	 * @return string The nested list element
	 * @access private
	 * @see HtmlHelper::nestedList()
	 */
	function __nestedListItem($items, $options, $itemOptions, $tag) {
		$out = '';
		$index = 1;

		foreach ($items as $key => $item) {
			if (is_array($item)) {
				$item = $key . $this->nestedList($item, $options, $itemOptions, $tag);
			}
			if (isset($itemOptions['even']) && $index % 2 == 0) {
				$itemOptions['class'] = $itemOptions['even'];
			} else if (isset($itemOptions['odd']) && $index % 2 != 0) {
				$itemOptions['class'] = $itemOptions['odd'];
			}
			$out .= sprintf($this->tags['li'], $this->_parseAttributes($itemOptions, array('even', 'odd'), ' ', ''), $item);
			$index++;
		}
	    return $out;
	}


	/**
	 * @todo
	 * 	- remove this is old?
	 */
	function markuptag() {
		// read config to see if using html5bp mutlti html   
		// read config to get lang
		// manifest_for_layout
		//if($this->theme) {}
	    return $this->tag('html');
	}

	/**
	 * start creates an initial block of html with auto or param based options
	 * @param $options mixed an optional array of options for use within the start block
	 * @example start(array('multihtml' => true, 'manifest' => 'manifestname', 'lang' => 'override cfg', ''))
	*/
	function start($options = null) {
		# NOTE: for manifesto
		# todo https://developer.mozilla.org/En/Offline_resources_in_Firefox
		
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
		if(isset($options['multihtml']) && $options['multihtml'] === true) {
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

		//if($this->theme) {}

		if($docType == '') {
			$docType = $this->docType();
		}

	    return $docType . $htmltag . $this->tag('head') . $this->charset();
	}

	/**
	 * function ietag
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

	/**
	 * microformats https://developer.mozilla.org/en/Using_microformats
	 *
	 * @todo readup and decide
	 */

	/**
	 * html5 tags with html4.5 class fallbacks
	 * @todo output, audio, flash
	*/
	
	/*
	 * function header
	 * @todo
	 * 	- wraps header items
	 * 	- group textual headers in a hgroup if array
	 * 	- add ability to add nav
	 * 	- add ability to add figure or branding image (css is better for branding)
	 * @param $headers mixed string/array of headers
	 * @param $options mixed array of options eg class, add content default is false
	 */
	function header($headers, $options = array()) {
		
	}

	/*
	 * function footer
	 * @todo
	 * 	-wrap content items with footer
	 * @param $content mixed string/array of content
	 * @param $options mixed array of options eg class default is false
	 */
	
	function footer($content, $options = array()) {
	    
	}

	/** 
	 * function article
	 * @param $content string of content
	 * @param $content array  of options
	 */
	function article($content, $options = array()) {
		$classes = '';
		if(isset($options['class']))    {
			$classes = ' ';
			$classes.= ($options['class'] !== array()) ? implode(' ', $options['class']) : $options['class'];
		}
		if($this->__type == 'html5') {
			if($classes !== '') $options['class'] = trim($classes);
		    return $this->tag('article', $content, $options);
		} else {
			$classes = (trim($classes) !== '') ? 'article' . $classes : 'article';
		    return $this->div($classes, $content, $options);   
		}
	}

	/*
	 * function section
	 * @todo
	 * 	- handle aside and subsections
	 * 	- have option to sectionize see wp sectionize
	 * @param $content string of content for section
	 * @param $header array to be passed to header function
	 * @param $footer array to be passed to footer function
	 */
	function section($content, $header, $footer = array(), $options = array()) {
		# https://developer.mozilla.org/en/Sections_and_Outlines_of_an_HTML5_document
		$classes = '';
		if(isset($options['class']))    {
			$classes = ' ';
			$classes.= ($options['class'] !== array()) ? implode(' ', $options['class']) : $options['class'];
		}
		if($this->__type == 'html5') {
			if($classes !== '') $options['class'] = trim($classes);
		    return $this->tag('section', $content, $options);
		} else {
			$classes = (trim($classes) !== '') ? 'section' . $classes : 'section';
		    return $this->div($classes, $content, $options);   
		}
	}

	/*
	 * function nav
	 * @param $content string of nav content
	 * @param $options array of items such as class
	 */
	function nav($content, $options = array()) {
		$classes = '';

		if(isset($options['class']))    {
			$classes = ' ';
			$classes.= ($options['class'] !== array()) ? implode(' ', $options['class']) : $options['class'];
		}

		if($this->__type == 'html5') {
			if($classes !== '') $options['class'] = trim($classes);
		    return $this->tag('nav', $content, $options);
		} else {
			$classes = (trim($classes) !== '') ? 'nav' . $classes : 'nav';
		    return $this->div($classes, $content, $options);   
		}
	}

	/**
	 * function menu
	 * @todo
	 * @param 
	 */
	function menu() {
		if($this->__type == 'html5') {
		    
		} else {
		    
		}
	}

	/**
	 * function command
	 * @todo
	 * 	- noby yet implements this I think
	 * @param 
	 */
	function command() {
		if($this->__type == 'html5') {
		    
		} else {
		    
		}
	}

	/**
	 * function video
	 * @todo
	 * 	- see ideas mentioned in audio
	 * @param $sources array of video sources
	 * @param $options array of attribs etc
	 */
	function video($sources, $options = array()) {
	    if($this->__type == 'html5') {
		
	    } else {
		
	    }
	}

	/**
	 * function audio
	 * @todo
	 * 	- can pass built set of source
	 * 	- if built sources not passed looks for approp files based on name
	 * 	  and makes sources
	 * 	- make fallback option that uses flash swfobject if cfg'd
	 * @param $sources array of video sources
	 * @param $options array of attribs etc
	 */
	function audio($sources, $options = array()) {
		if($this->__type == 'html5') {
		    
		} else {
		    
		}
	}

	/**
	 * function source
	 * @todo
	 *	- by default will not check the presence of file
	 * @param 
	 */
	function source($source, $options = array()) {
		if($this->__type == 'html5') {
		    
		} else {
		    
		}
	}
	
	/**
	 * function output
	 * @todo
	 * @param 
	 */
	
	function output() {
		if($this->__type == 'html5') {
		    
		} else {
		    
		}
	}

	/**
	 * function mark
	 * @todo
	 * @param 
	 */
	function mark() {
		# https://developer.mozilla.org/en/HTML/Element/mark
		if($this->__type == 'html5') {
		    
		} else {
		    
		}
	}

	/**
	 * function figure
	 * @todo
	 *  - write tests
	 * @param 
	 */
	function figure($figure, $options = array(), $figcaption = '') {
		# https://developer.mozilla.org/en/HTML/Element/figure
		if($this->__type == 'html5') {
		    return $this->tag('figure', $figure, $options);
		} else {
		    return $this->tag('div', $figure, array('class' => 'figure'));
		}
	}

	/**
	 * function figcaption
	 * @todo
	 * @param 
	 */
	function figcaption($text, $options = array()) {
		# https://developer.mozilla.org/en/HTML/Element/figcaption
		if($this->__type == 'html5') {
		    return $this->tag('figcaption', $text, $options);
		} else {
		    return $this->tag('div', $text, array('class' => 'caption'));
		}
	}

	/**
	 * function canvas
	 * @todo
	 * @param $options array of options
	 * @param $fallback string of content
	 */
	function canvas($options, $fallback = '') {
		$fallback = (empty($fallback)) ? $this->para('message', __('content not available', true)) : $fallback;
		if($this->__type == 'html5') {
		    return $this->tag('canvas', $fallback, $options);
		} else {
		    return $this->tag('div', $fallback, array('class' => 'canvas'));
		}
	}

	/**
	 * function time
	 *@todo:
	 * outputs time tag
	 *  <time class="..." pubdate>2011-11-11 11:11:00</time>
	 *  <span class="time ..." title="published">2011-11-11 11:11:00</span>
	 * 
	 * @param $content string time used to create attribs
	 * @param $options array of options
	 */
	function time($content, $options = array()) {
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
