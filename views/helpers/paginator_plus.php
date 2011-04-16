<?php
/**
 * PaginatorPlusHelper
 * 
 * Slight tweak on the original paginator
 *
 * @package default
 * @author Dean Sofer
 * @version $Id$
 * @copyright Art Engineered
 **/
App::import('Helper', 'Paginator');
class PaginatorPlusHelper extends PaginatorHelper {
	
/**
 * Tweaked the arrows and disabled options use regular options as defaults
 *
 * @param string $title 
 * @param string $options 
 * @param string $disabledTitle 
 * @param string $disabledOptions 
 * @return void
 * @author Dean Sofer
 * @see paginator.php
 */
	function prev($title = '« Previous', $options = array(), $disabledTitle = null, $disabledOptions = array()) {
		$disabledOptions = array_merge($options, $disabledOptions);
		return parent::prev($title, $options, $disabledTitle, $disabledOptions);
	}
	
	function next($title = 'Next »', $options = array(), $disabledTitle = null, $disabledOptions = array()) {
		$disabledOptions = array_merge($options, $disabledOptions);
		return parent::next($title, $options, $disabledTitle, $disabledOptions);
	}
}