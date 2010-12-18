<?php
/**
 * Copyright 2005-2010, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2005-2010, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

include(dirname(dirname(__FILE__)) . DS .  'common_params.php');
?> 
/**
 * Returns the search data
 *
 * @param string
 * @param array
 * @param array
 * @return
 * @access protected
 */
	protected function _findSearch($state, $query, $results = array()) {
		if ($state == 'before') {
			$this->Behaviors->attach('Containable', array('autoFields' => false));
			$results = $query;

			if (isset($query['operation']) && $query['operation'] == 'count') {
				$results['fields'] = array('COUNT(*)');
			}

			return $results;
		} elseif ($state == 'after') {
			if (isset($query['operation']) && $query['operation'] == 'count') {
				if (isset($query['group']) && is_array($query['group']) && !empty($query['group'])) {
					return count($results);
				}
				return $results[0][0]['COUNT(*)'];
			}
			return $results;
		}
	}

/**
 * Customized paginateCount method
 *
 * @param array
 * @param integer
 * @param array
 * @return
 * @access public
 */
	function paginateCount($conditions = array(), $recursive = 0, $extra = array()) {
		$parameters = compact('conditions');
		if ($recursive != $this->recursive) {
			$parameters['recursive'] = $recursive;
		}
		if (isset($extra['type']) && isset($this->_findMethods[$extra['type']])) {
			$extra['operation'] = 'count';
			return $this->find($extra['type'], array_merge($parameters, $extra));
		} else {
			return $this->find('count', array_merge($parameters, $extra));
		}
	}

