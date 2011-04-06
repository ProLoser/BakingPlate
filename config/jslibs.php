<?php

## todo make theme and fallback default to false

// lib and name are much the same but some lib need to
// be called via a string with partial uppercasing such jQuery
// so for now I have two but want to find a better way 

$config['BakingPlate']['YahooProfiler'] = array(
		'lib' => 'yahooprofiler',
		'theme' => false,
		'name' => 'YahooProfiler',
		'version' => '2.8.1',
		'compressed' => true,
		'fallback' => false
);
$config['BakingPlate']['JsLib']['modernizr'] = array(
		'lib' => 'modernizr',
		'theme' => false,
		'name' => 'modernizr',
		'version' => '1.7',
		'compressed' => true,
		'fallback' => false
);

$config['BakingPlate']['JsLib']['firebug-lite'] = array(
		'url' => 'https://getfirebug.com/firebug-lite.js'
);

$config['BakingPlate']['JsLib']['css3-mediaqueries'] = array(
		'lib' => 'css3-mediaqueries',
		'theme' => false,
		'name' => 'css3-mediaqueries',
		'version' => false,
		'min' => 'min',
		'fallback' => false
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
		'theme' => false,
		'name' => 'jQuery',
		'version' => '1.5.1',
		'min' => 'min',
		'fallback' => true
);
