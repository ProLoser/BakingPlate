<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
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
 * @subpackage    cake.cake
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::import('Vendor', 'UrlCache.url_cache_app_helper');
class AppHelper extends UrlCacheAppHelper {
	
	/**
	 * Specifies whether the url prefix should be left alone in array urls when unspecified
	 *
	 * @var boolean True: leave prefix in url, False: strip prefix from url if unset
	 */
	var $maintainPrefix = true;
	
	/**
	 * The Html->url() function overridden to support local prefixes
	 *
	 * @param string $url 
	 * @param string $full 
	 * @return void
	 * @author Dean Sofer
	 */
	function url($url = null, $full = false) {
		if (is_array($url)) {
			if (!isset($url['lang']) && isset($this->params['lang'])) {
				$url['lang'] = $this->params['lang'];
			} elseif (isset($url['lang']) && $url['lang'] == Configure::read('Languages.default')) {
				unset($url['lang']);
			}
			if (!isset($url['plugin'])) {
				$url['plugin'] = false;
			}
			if (!$this->maintainPrefix) {
				$routing = Configure::read('Routing');
				if (!empty($routing['prefixes'])) {
					$prefixes = array_diff_key(array_flip($routing['prefixes']), $url);
					$url = array_merge($url, array_fill_keys(array_keys($prefixes), false)); 
				}
			}
		}
		return parent::url($url, $full);
	}
}
