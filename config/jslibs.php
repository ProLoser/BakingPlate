<?php

## todo make theme and fallback default to false

// lib and name are much the same but some lib need to
// be called via a string with partial uppercasing such jQuery
// so for now I have two but want to find a better way 

$config['BakingPlate']['YahooProfiler'] = array(
		'lib' => 'libs/yahooprofiler',
		'version' => '2.8.1',
		'min' => '',
);
$config['BakingPlate']['JsLib']['modernizr'] = array(
		'lib' => 'libs/modernizr',
		'path' => 'libs/',
		'version' => '1.7'
);

$config['BakingPlate']['JsLib']['firebug-lite'] = array(
		'url' => 'https://getfirebug.com/firebug-lite.js'
);

$config['BakingPlate']['JsLib']['css3-mediaqueries'] = array(
		'lib' => 'libs/css3-mediaqueries',
		'path' => 'libs/',
		'version' => false,
);
/**
 * 
		'Microsoft' => 'http://ajax.aspnetcdn.com/ajax/:name/:lib-:version:min.js',
		'jQuery' => 'http://code.jquery.com/jquery-:version:min.js',
		'customName' => 'http://cusotm.example.org/static/:theme/:type/:lib-:version:min.:type'
 */
$config['BakingPlate']['JsLib']['jQuery'] = array(
		'cdn' => '//ajax.googleapis.com/ajax/libs/:lib/:version/:lib:min.js',
		'lib' => 'jquery',
		'version' => '1.5.1',
		'path' => 'libs/',
		'fallback' => true
);
//$config['BakingPlate']['JsLib']['SWFObject'] = array(
//		'cdn' => '//ajax.googleapis.com/ajax/libs/:lib/:version/:lib:min.js',
//		'lib' => 'swfobject',
//		'name' => 'SWFObject',
//		'version' => '2.2',
//		'min' => '',
//		'uncompressed' => '_src',
//		'fallback' => true
//);
