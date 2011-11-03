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
				if ($params['options']['limit'] == $limit) {
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
	
	
	

/**
 * Returns a set of numbers for the paged result set
 * uses a modulus to decide how many numbers to show on each side of the current page (default: 8)
 *
 * ### Options
 *
 * - `before` Content to be inserted before the numbers
 * - `after` Content to be inserted after the numbers
 * - `model` Model to create numbers for, defaults to PaginatorHelper::defaultModel()
 * - `modulus` how many numbers to include on either side of the current page, defaults to 8.
 * - `separator` Separator content defaults to ' | '
 * - `tag` The tag to wrap links in, defaults to 'span'
 * - `first` Whether you want first links generated, set to an integer to define the number of 'first'
 *    links to generate
 * - `last` Whether you want last links generated, set to an integer to define the number of 'last'
 *    links to generate
 *
 * @param mixed $options Options for the numbers, (before, after, model, modulus, separator)
 * @return string numbers string.
 * @access public
 */
	function numbers($options = array()) {
		$activeClass = 'active';
		if ($options === true) {
			$options = array(
				'before' => '', 'after' => '', 'first' => 'first', 'last' => 'last', 'separator' => ''
			);
		}

		$defaults = array(
			'tag' => 'span', 'before' => null, 'after' => null, 'model' => $this->defaultModel(),
			'modulus' => '8', 'separator' => '', 'first' => null, 'last' => null,
		);
		$options += $defaults;

		$params = (array)$this->params($options['model']) + array('page'=> 1);
		unset($options['model']);

		if ($params['pageCount'] <= 1) {
			return false;
		}

		extract($options);
		unset($options['tag'], $options['before'], $options['after'], $options['model'],
			$options['modulus'], $options['separator'], $options['first'], $options['last']);

		$out = '';

		if ($modulus && $params['pageCount'] > $modulus) {
			$half = intval($modulus / 2);
			$end = $params['page'] + $half;

			if ($end > $params['pageCount']) {
				$end = $params['pageCount'];
			}
			$start = $params['page'] - ($modulus - ($end - $params['page']));
			if ($start <= 1) {
				$start = 1;
				$end = $params['page'] + ($modulus  - $params['page']) + 1;
			}

			if ($first && $start > 1) {
				$offset = ($start <= (int)$first) ? $start - 1 : $first;
				if ($offset < $start - 1) {
					$out .= $this->first($offset, array('tag' => $tag, 'separator' => $separator));
				} else {
					$out .= $this->first($offset, array('tag' => $tag, 'after' => $separator, 'separator' => $separator));
				}
			}

			$out .= $before;

			for ($i = $start; $i < $params['page']; $i++) {
				$out .= $this->Html->tag($tag, $this->link($i, array('page' => $i), $options))
					. $separator;
			}

			$out .= $this->Html->tag($tag, $params['page'], array('class' => 'current'));
			if ($i != $params['pageCount']) {
				$out .= $separator;
			}

			$start = $params['page'] + 1;
			for ($i = $start; $i < $end; $i++) {
				$out .= $this->Html->tag($tag, $this->link($i, array('page' => $i), $options))
					. $separator;
			}

			if ($end != $params['page']) {
				$out .= $this->Html->tag($tag, $this->link($i, array('page' => $end), $options));
			}

			$out .= $after;

			if ($last && $end < $params['pageCount']) {
				$offset = ($params['pageCount'] < $end + (int)$last) ? $params['pageCount'] - $end : $last;
				if ($offset <= $last && $params['pageCount'] - $end > $offset) {
					$out .= $this->last($offset, array('tag' => $tag, 'separator' => $separator));
				} else {
					$out .= $this->last($offset, array('tag' => $tag, 'before' => $separator, 'separator' => $separator));
				}
			}

		} else {
			$out .= $before;

			for ($i = 1; $i <= $params['pageCount']; $i++) {
				if ($i == $params['page']) {
					$out .= $this->Html->tag($tag, '<span>'.$i.'</span>', array('class' => $activeClass));
				} else {
					$out .= $this->Html->tag($tag, $this->link($i, array('page' => $i), $options));
				}
				if ($i != $params['pageCount']) {
					$out .= $separator;
				}
			}

			$out .= $after;
		}

		return $out;
	}
}