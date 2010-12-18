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

/**
 * Subtemplate Task generates templated output used in other tasks
 *
 * @package templates
 * @subpackage templates.shells
 */
class Subtemplate extends Shell {

/**
 * variables to add to template scope
 *
 * @var array
 */
	public $templateVars = array();

/**
 * Paths to look for templates on.
 * Contains a list of $theme => $path
 *
 * @var array
 */
	public $subTemplatePaths = array();

/**
 *  Constructs this Shell instance.
 *
 */
	public function __construct(&$template) { 
		$this->Template = $template;
		parent::__construct($template->Dispatch);
	}

/**
 * Initialize callback.  Setup paths for the template task.
 *
 * @return void
 */
	public function initialize() {
		$this->subTemplatePaths = $this->_findSubthemes();
		//debug($this->subTemplatePaths);
	}

/**
 * Find the paths to all the installed shell themes extensions in the app.
 *
 * @return array Array of bake themes that are installed.
 */
	protected function _findSubthemes() {
		$paths = App::path('shells');
		$plugins = App::objects('plugin');
		foreach ($plugins as $plugin) {
			$paths[$plugin] = $this->_pluginPath($plugin) . 'vendors' . DS . 'shells' . DS;
		}

		foreach ($paths as $i => $path) {
			$paths[$i] = rtrim($path, DS) . DS;
		}

		$subthemes = array();
		foreach ($paths as $plugin => $path) {
			$Folder =& new Folder($path . 'subtemplates', false);
			$contents = $Folder->read();
			$subDirs = $contents[0];
			foreach ($subDirs as $dir) {
				if (empty($dir) || preg_match('@^skel$|_skel|\..+$@', $dir)) {
					continue;
				}
				$Folder =& new Folder($path . 'subtemplates' . DS . $dir);
				$contents = $Folder->read();
				$subDirs = $contents[0];
				
				$templateDir = $path . 'subtemplates' . DS . $dir . DS;
				$subthemes[$plugin . '.' . $dir] = $templateDir;
			}
		}
		return $subthemes;
	}

/**
 * Set variable values to the template scope
 *
 * @param mixed $one A string or an array of data.
 * @param mixed $two Value in case $one is a string (which then works as the key).
 *   Unused if $one is an associative array, otherwise serves as the values to $one's keys.
 * @return void
 */
	public function set($one, $two = null) {
		$data = null;
		if (is_array($one)) {
			if (is_array($two)) {
				$data = array_combine($one, $two);
			} else {
				$data = $one;
			}
		} else {
			$data = array($one => $two);
		}

		if ($data == null) {
			return false;
		}

		foreach ($data as $name => $value) {
			$this->templateVars[$name] = $value;
		}
	}

/**
 * Runs the template
 *
 * @param string $directory directory / type of thing you want
 * @param string $filename template name
 * @param string $vars Additional vars to set to template scope.
 * @return contents of generated code template
 */
	public function generate($directory, $filename, $vars = null) {
		if ($vars !== null) {
			$this->set($vars);
		}
		if (empty($this->subTemplatePaths)) {
			$this->initialize();
		}
		$subthemePaths = $this->getSubThemePaths();
		foreach ($subthemePaths as $path) {
			$templateFile = $this->_findTemplate($path, $directory, $filename);
			if ($templateFile) {
				extract($this->templateVars);
				$template = $this->Template;
				ob_start();
				ob_implicit_flush(0);
				include($templateFile);
				$content = ob_get_clean();
				return $content;
			}
		}
		return '';
	}

/**
 * Find the subtheme name for the current operation.
 *
 * @return array returns the path to the selected theme.
 */
	public function getSubThemePaths() {
		if (!empty($this->params['subthemes'])) {
			$subthemes = explode(',', $this->params['subthemes']);
			$paths = array();
			foreach ($subthemes as $subtheme) {
				if (isset($this->subTemplatePaths[$subtheme])) {
					$paths[] = $this->subTemplatePaths[$subtheme];
				}
			}
			return $paths;
		}
		return array();
	}

/**
 * Find a template inside a directory inside a path.
 * Will scan all other theme dirs if the template is not found in the first directory.
 *
 * @param string $path The initial path to look for the file on. If it is not found fallbacks will be used.
 * @param string $directory Subdirectory to look for ie. 'views', 'objects'
 * @param string $filename lower_case_underscored filename you want.
 * @return string filename will exit program if template is not found.
 */
	protected function _findTemplate($path, $directory, $filename) {
		$themeFile = $path . $directory . DS . $filename . '.ctp';
		if (file_exists($themeFile)) {
			return $themeFile;
		}
		$this->err(sprintf(__('Could not find template for %s', true), $filename));
		return false;
	}
}
