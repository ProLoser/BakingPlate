<?php
/**
 * Automatic generation of HTML FORMs from given data.
 *
 * Used for scaffolding.
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
 * @subpackage    cake.cake.libs.view.helpers
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('FormHelper', 'View/Helper');
/**
 * Form helper library.
 *
 * Automatic generation of HTML FORMs from given data.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.view.helpers
 * @link http://book.cakephp.org/view/1383/Form
 */

# https://developer.mozilla.org/en/HTML/HTML5/Forms_in_HTML5

class FormPlusHelper extends FormHelper {
	
/**
 * Creates a text input widget.
 *
 * @param string $fieldName Name of a field, in the form "Modelname.fieldname"
 * @param array $options Array of HTML attributes.
 * @return string A generated HTML text input element
 * @access public
 * @link http://book.cakephp.org/view/1432/text
 */
	function text($fieldName, $options = array()) {
		$options = $this->_addPlaceholder($fieldName, $options);
		return parent::text($fieldName, $options);
	}
	
/**
 * Creates a textarea widget.
 *
 * ### Options:
 *
 * - `escape` - Whether or not the contents of the textarea should be escaped. Defaults to true.
 *
 * @param string $fieldName Name of a field, in the form "Modelname.fieldname"
 * @param array $options Array of HTML attributes, and special options above.
 * @return string A generated HTML text input element
 * @access public
 * @link http://book.cakephp.org/view/1433/textarea
 */
	function textarea($fieldName, $options = array()) {
		$options = $this->_addPlaceholder($fieldName, $options);
		return parent::textarea($fieldName, $options);
	}
	
/**
 * Formats a string into a human-readable format
 *
 * @param string $text 
 * @return string A formatted version of $text
 */
	function _labelText($text) {
		if (strpos($text, '.') !== false) {
			$text = array_pop(explode('.', $text));
		} else {
			$text = $text;
		}
		if (substr($text, -3) == '_id') {
			$text = substr($text, 0, strlen($text) - 3);
		}
		$text = __(Inflector::humanize(Inflector::underscore($text)));
		return $text;
	}

/**
 * Supplements an $options array with placeholder attributes
 *
 * @param string $fieldName 
 * @param string $options 
 * @return array reformed version of $options
 */
	function _addPlaceholder($fieldName, $options) {
		if (isset($options['placeholder']) && $options['placeholder'] === true) {
			if (!empty($options['label'])) {
				$options['placeholder'] = $options['label'];
			} else {
				$options['placeholder'] = $this->_labelText($fieldName);
			}
		}
		return $options;
	}
}
