<?php
/**
 * LocalizedRouter
 *
 * NOTE: Do not use this class as a substitute of Router class.
 * Use it only for CroogoRouter::connect()
 *
 * @package  Croogo
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class LangRouter {

/**
 * Regex key for searching the url for lang prefixes
 *
 * @var string
 */
	public static $langCode = '(?!js|css|img)[a-z]{2,3}(?<!js|css|img)';

/**
 * Create an extra Route for lang-based URLs
 *
 * For example,
 * http://yoursite.com/blog/post-title, and
 * http://yoursite.com/eng/blog/post-title
 *
 * Returns this object's routes array. Returns false if there are no routes available.
 *
 * @param string $route			An empty string, or a route string "/"
 * @param array $default		NULL or an array describing the default route
 * @param array $params			An array matching the named elements in the route to regular expressions which that element should match.
 * @return void
 */
	public function connect($route, $default = array(), $params = array()) {
		Router::connect($route, $default, $params);
		if ($route == '/') {
				$route = '';
		}
		Router::connect('/:lang' . $route, $default, array_merge(array('lang' => LangRouter::$langCode), $params));
	}
/**
 * If you want your non-routed controler actions (like /users/add) to support lang based urls,
 * this method must be called AFTER all the routes.
 *
 * @return void
 */
	public function localize() {
		Router::connect('/:lang/:controller/:action/*', array(), array('lang' => LangRouter::$langCode));
	}
}