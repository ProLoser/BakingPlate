<?php
/**
 * AutoHelperView
 *
 * Provides automatic loading, or "lazy loading" of heleprs for the `View`
 * class.
 *
 * If a helper needs to be called prior to rendering or if it has any
 * settings you should keep it in your controller's `$helpers` array.
 *
 * @author Joe Beeson <jbeeson@gmail.com>
 */
App::uses('ThemeView', 'View');
class ThemedAutoHelperView extends ThemeView {

/**
 * Stores our array of known helpers.
 *
 * @var array
 * @access protected
 */
	protected $_helpers = array();

/**
 * Called when a request for a non-existant member variable is caught.
 * If the requested $variable matches a known helper we will attempt to
 * load it up for the caller.
 *
 * @param string $variable
 * @return mixed
 * @access public
 */
	public function __get($variable = '') {
		$variable = str_replace('_','.',$variable);

		// Is the $variable a known helper name? If so, load the helper
		if (in_array($variable, $this->_getHelpers())) {
			$this->_loadHelper($variable);
		}

		// Get the proper helper name
		if (strpos($variable,'.')) {
		    list(,$variable) = explode('.', $variable);
		}

		// Make sure the variable is now available and if so, return it
		if (isset($this->$variable)) {
			return $this->$variable;
		}
	}

/**
 * Returns an array of known helpers. We will cache the known helpers
 * so that we don't have to keep bothering App::object()
 *
 * @param boolean $cache
 * @return array
 * @access protected
 */
	protected function _getHelpers($cache = true) {
		// Check if we don't have the array of if we're told not to cache
		if (empty($this->_helpers) or !$cache) {
			$this->_helpers = App::objects('helper');
		}

		// Return the array of helpers
		return $this->_helpers;
	}

/**
 * Convenience method for loading up a specific helper.
 *
 * @param string $helper
 * @return null
 * @access protected
 */
	protected function _loadHelper($helper) {
		// Load the variable up
		$this->loaded = $this->_loadHelpers(
			$this->loaded,
			array($helper)
		);

		if (strpos($helper,'.')) {
			list(,$helper) = explode('.', $helper);
		}


		// Assign the helper into a member variable
		$this->$helper = $this->loaded[$helper];
	}

/**
 * Renders and returns output for given view filename with its
 * array of data.
 *
 * We override the `View` method because the core uses a pass-by-ref in
 * its code, which causes our `__get` method to barf, everywhere.
 *
 * @param string $___viewFn
 * @param array $___dataForView
 * @param boolean $loadHelpers
 * @param boolean $cached
 * @return string
 * @access public
 */
	public function _render($___viewFn, $___dataForView, $loadHelpers = true, $cached = false) {
		$loadedHelpers = array();

		if ($this->helpers != false && $loadHelpers === true) {
			$loadedHelpers = $this->_loadHelpers($loadedHelpers, $this->helpers);
			$helpers = array_keys($loadedHelpers);
			$helperNames = array_map(array('Inflector', 'variable'), $helpers);

			for ($i = count($helpers) - 1; $i >= 0; $i--) {
				$name = $helperNames[$i];
				$helper = $loadedHelpers[$helpers[$i]];

				if (!isset($___dataForView[$name])) {
					${$name} = $helper;
				}
				$this->loaded[$helperNames[$i]] = $helper;
				$this->{$helpers[$i]} = $helper;
			}
			$this->_triggerHelpers('beforeRender');
			unset($name, $loadedHelpers, $helpers, $i, $helperNames, $helper);
		}

		extract($___dataForView, EXTR_SKIP);
		ob_start();

		if (Configure::read('debug') > 0) {
			include ($___viewFn);
		} else {
			@include ($___viewFn);
		}

		if ($loadHelpers === true) {
			$this->_triggerHelpers('afterRender');
		}

		$out = ob_get_clean();
		$caching = (
			isset($this->loaded['cache']) &&
			(($this->cacheAction != false)) && (Configure::read('Cache.check') === true)
		);

		if ($caching) {
			if (is_a($this->loaded['cache'], 'CacheHelper')) {
				$cache = $this->loaded['cache'];
				$this->Cache->base = $this->request->base;
				$this->Cache->here = $this->request->here;
				$this->Cache->helpers = $this->helpers;
				$this->Cache->action = $this->request->action;
				$this->Cache->controllerName = $this->name;
				$this->Cache->layout = $this->layout;
				$this->Cache->cacheAction = $this->cacheAction;
				$this->Cache->cache($___viewFn, $out, $cached);
			}
		}
		return $out;
	}

}