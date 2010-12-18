<?php
App::import('Model', 'AssetCompress.AssetFilterInterface');

//class CssMinNativeFilter implements AssetFilterInterface {
//	public function filter($input) {
//		$output = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $input);
//		$output = str_replace(array("\r\n", "\r", "\n", "\t", '/\s\s+/', '  ', '   '), '', $output);
//		$output = str_replace(array(' {', '{ '), '{', $output);
//		$output = str_replace(array(' }', '} '), '}', $output);
//		return $output;
//	}
//}


App::import('Vendor', 'csstidy', array('file' => 'csstidy/class.csstidy.php'));

class CssTidyFilter implements AssetFilterInterface {
	// set the css compression level
	// options: default, low_compression, high_compression, highest_compression
	// 'default' means no compression
	public function filter($input) {
		$compression = 'high'; // high highest default
		$tidy = new csstidy();
		//$tidy->load_template();
		$tidy->parse($input);
		return $tidy->print->plain();
	}
}
?>