<?php
/**
 * Plate Model Behavior
 *
 * @package BakingPlate
 * @author Dean Sofer
 * @version $Id$
 * @copyright Art Engineered
 **/
class PlateBehavior extends ModelBehavior {

/**
 * Allows the mapping of preg-compatible regular expressions to public or
 * private methods in this class, where the array key is a /-delimited regular
 * expression, and the value is a class method.  Similar to the functionality of
 * the findBy* / findAllBy* magic methods.
 *
 * @var array
 * @access public
 */
	public $mapMethods = array();

/**
 * Convenience method to update one record without invoking any callbacks
 *
 * @param array $fields Set of fields and values, indexed by fields.
 *    Fields are treated as SQL snippets, to insert literal values manually escape your data.
 * @param mixed $conditions Conditions to match, true for all records
 * @return boolean True on success, false on Model::id is not set or failure
 * @access public
 * @author Jose Diaz-Gonzalez
 * @link http://book.cakephp.org/view/1031/Saving-Your-Data
 **/
	public function update($model, $fields, $conditions = array()) {
		$conditions = (array)$conditions;
		if (!$model->id) {
			return false;
		}

		$conditions = array_merge(array("{$model->alias}.{$model->primaryKey}" => $model->id), $conditions);

		return $model->updateAll($fields, $conditions);
	}

/**
 * Custom Model::paginateCount() method to support custom model find pagination
 *
 * @param array $conditions
 * @param int $recursive
 * @param array $extra
 * @return array
 */
	public function paginateCount($model, $conditions = array(), $recursive = 0, $extra = array()) {
		$parameters = compact('conditions');

		if ($recursive != $model->recursive) {
				$parameters['recursive'] = $recursive;
		}

		if (isset($extra['type'])) {
				$extra['operation'] = 'count';
				return $model->find($extra['type'], array_merge($parameters, $extra));
		} else {
				return $model->find('count', array_merge($parameters, $extra));
		}
	}

/**
 * Removes 'fields' key from count query on custom finds when it is an array,
 * as it will completely break the Model::_findCount() call
 *
 * @param string $state Either "before" or "after"
 * @param array $query
 * @param array $data
 * @return int The number of records found, or false
 * @access protected
 * @see Model::find()
 */
	protected function _findCount($model, $state, $query, $results = array()) {
		if ($state == 'before' && isset($query['operation'])) {
			if (!empty($query['fields']) && is_array($query['fields'])) {
				if (!preg_match('/^count/i', $query['fields'][0])) {
					unset($query['fields']);
				}
			}
		}
		return parent::_findCount($state, $query, $results);
	}

/**
 * Disables/detaches all behaviors from model
 *
 * @param mixed $except string or array of behaviors to exclude from detachment
 * @param boolean $detach If true, detaches the behavior instead of disabling it
 * @return void
 * @access public
 * @author Jose Diaz-Gonzalez
 */
	public function disableAllBehaviors($model, $except = array(), $detach = false) {
		$behaviors = array_diff($model->Behaviors->attached(), (array)$except);
		foreach ($behaviors as $behavior) {
			if ($detach) {
				$model->Behaviors->detach($behavior);
			} else {
				$model->Behaviors->disable($behavior);
			}
		}
	}

/**
 * Enables all previously disabled attachments
 *
 * @return void
 * @access public
 * @author Jose Diaz-Gonzalez
 */
	public function enableAllBehaviors($model) {
		$behaviors = $model->Behaviors->attached();
		foreach ($behaviors as $behavior) {
			if (!$model->Behaviors->enabled($behavior)) {
				$model->Behaviors->enable($behavior);
			}
		}
	}
}