<?php
/**
 * PaginatorPlusHelper
 * 
 * Slight tweak on the original paginator
 *
 * @package BakingPlate
 * @author Dean Sofer
 * @version $Id$
 * @copyright Art Engineered
 * @since       BakingPlate v 0.1
 * @package       BakingPlate.View.Helper
 * @license     MIT License (http://www.opensource.org/licenses/mit-license.php)
 **/
App::uses('PaginatorHelper', 'View/Helper');
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
	public function prev($title = '« prev', $options = array(), $disabledTitle = null, $disabledOptions = array()) {
		$disabledOptions = array_merge($options, $disabledOptions);
		return parent::prev($title, $options, $disabledTitle, $disabledOptions);
	}
	
	public function next($title = 'next »', $options = array(), $disabledTitle = null, $disabledOptions = array()) {
		$disabledOptions = array_merge($options, $disabledOptions);
		return parent::next($title, $options, $disabledTitle, $disabledOptions);
	}
	
/**
 * Generates a series of links for adjusting the # of records shown
 *
 * @param mixed $limits int for single link or an array (with optional 'label' => 'limit') 
 * @param array $options 
 *	tag: change or disable the container of each link
 *	between: content to place between each link
 *	before: content to place inside container before each link (if 'tag' = !empty)
 *	after: content to place insider container after each link (if 'tag' = !empty)
 * @return string $result
 * @author Dean Sofer
 */
	public function limit($limits, $options = array()) {
		$options = array_merge(array(
			'tag' => 'span',
			'between' => null,
			'before' => null,
			'after' => null,
		), $options);
		if (is_array($limits)) {
			$result = '';
			$count = 0;
			foreach ($limits as $label => $limit) {
				$count++;
				if (!is_string($label))
					$label = $limit;
				$params = $this->params();
				if ($params['limit'] == $limit) {
					if (empty($options['tag'])) {
						$result .= $label . "\n";
					} else {
						$result .= $this->Html->tag($options['tag'], $options['before'] . $label . $options['after'], array('class' => 'current')) . "\n";
					}
				} else {
					if (empty($options['tag'])) {
						$result .= $this->Html->link($label, array('limit' => $limit)) . "\n";
					} else {
						$result .= $this->Html->tag($options['tag'], $options['before'] . $this->Html->link($label, array('limit' => $limit)) . $options['after']) . "\n";
					}
				}
				if ($count != count($limits)) {
					$result .= $options['between'];
				}
			}
			return $result;
		} else {
			if (!$label)
				$label = $limits;
			return $this->Html->link($label, array('limit' => $limits));
		}
	}
}