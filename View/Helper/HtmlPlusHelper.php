<?php
/**
 * HtmlPlus Helper class file.
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @package BakingPlate
 * @author Dean Sofer
 * @version $Id$
 * @copyright Art Engineered
 * @since       BakingPlate v 0.1
 * @package       BakingPlate.View.Helper
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('HtmlHelper', 'View/Helper');

class HtmlPlusHelper extends HtmlHelper {

/**
 * html tags used by this helper.
 *
 * @var array
 * @access public
 */
	protected $_tags = array(
		'html' => '<html%s>',
		'htmlend' => '</html>',
		'meta' => '<meta%s>',
		'metalink' => '<link href="%s"%s>',
		'link' => '<a href="%s"%s>%s</a>',
		'mailto' => '<a href="mailto:%s" %s>%s</a>',
		'form' => '<form action="%s"%s>',
		'formend' => '</form>',
		'input' => '<input name="%s" %s>',
		'textarea' => '<textarea name="%s" %s>%s</textarea>',
		'hidden' => '<input type="hidden" name="%s" %s>',
		'checkbox' => '<input type="checkbox" name="%s" %s>',
		'checkboxmultiple' => '<input type="checkbox" name="%s[]"%s>',
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
		'button' => '<button%s>%s</button>',
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
		'time' => '<time%s>%s</time>',
		'javascriptblock' => '<script%s>%s</script>',
		'javascriptstart' => '<script%s>',
		'javascriptlink' => '<script src="%s"%s></script>',
		'javascriptend' => '</script>'
	);

/**
 * contruct
 * 	- allow defaults to be overridden
 * @param $settings array
 */
	public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);
	}

/**
 * The time element represents either a time on a 24 hour clock,
 * or a precise date in the proleptic Gregorian calendar,
 * optionally with a time and a time-zone offset.
 *
 * @param $content string
 * @param $options array
 *      'format' STRING: Use the specified TimeHelper method (or format()). FALSE: Generate the datetime. NULL: Do nothing.
 *      'datetime' STRING: If 'format' is STRING use as the formatting string. FALSE: Don't generate attribute
 *		'pubdate' BOOLEAN: If the pubdate attribute should be set
 */
	public function time($content, $options = array()) {
		$options = array_merge(array(
		'datetime' => DATE_W3C,
		'pubdate' => false,
		'format' => false,
		), $options);

		if ($options['format'] !== null) {
			App::uses('TimeHelper', 'View/Helper');
			$t = &new TimeHelper($this->_View);
		}
		if ($options['format']) {
			$time = $content;
			if (method_exists($t, $options['format'])) {
							$content = $t->$options['format']($content);
			} else {
							$content = $t->format($options['format'], $content);
			}
			$options['datetime'] = $t->format($options['datetime'], strtotime($time));
		} elseif ($options['format'] === false && $options['datetime']) {
			$options['datetime'] = $t->format($options['datetime'], strtotime($content));
		}

		if ($options['pubdate']) {
			$pubdate = true;
		}

		unset($options['format']);
		unset($options['pubdate']);
		$attributes = $this->_parseAttributes($options, array(0), ' ', '');

		if (isset($pubdate)) {
			$attributes .= ' pubdate';
		}

		return sprintf($this->_tags['time'],  $attributes, $content);
	}
}