<?php
App::import('Model', 'AssetCompress.AssetFilterInterface');
App::import('Vendor', 'CssMin', array('file' => 'cssmin/CssMin.php'));

/**
 * CssMin filter.
 *
 * Allows you to filter Css files through CssMin.  You need to put CssMin in your application's
 * vendors directories.  You can get it from http://code.google.com/p/cssmin/
 *
 * @package asset_compress
 * @author Mark Story
 */
class CssMinFilter implements AssetFilterInterface {
/**
 * Apply CssMin to $content.
 *
 * @param string $content Content to filter.
 * @return string
 */
	public function filter($content) {
		return CssMin::minify($content);
	}
/**
 * Gets settings for this filter.  Will always include 'paths'
 * key which points at paths available for the type of asset being generated.
 *
 * @param array $settings Array of settings.
 */
	public function settings($settings) {
		parent::settings($settings);
	}

/**
 * Input filter.
 *
 * @param string $filename Name of the file
 * @param string $content Content of the file.
 */
	public function input($filename, $content) {
		return parent::input($filename, $content);
	}

/**
 * Output filter.
 *
 * @param string $target The build target being made.
 * @param string $content The content to filter.
 */
	public function output($target, $content) {
		return parent::output($target, $content);
	}
}
