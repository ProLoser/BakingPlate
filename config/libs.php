<?php
/**
 * Do not use local paths in this file!
 *
 * All libraries should be referenced off-server. Do not use this for self-hosted CDNs
 *
 * @author Dean Sofer
 */ 
$config['BakingPlate']['Libs']['jquery'] = array(
	// url to cdn
	'cdn' => '//ajax.googleapis.com/ajax/libs/jquery/:version/jquery.js',
	// (optional) url to uncompressed version
	'cdnu' => '//ajax.googleapis.com/ajax/libs/jquery/:version/jquery.min.js',
	// default version to use
	'version' => '1.5.2',
	// (optional) snippet of js to check if the lib is active
	'fallback_check' => 'window.jQuery',
);
$config['BakingPlate']['Libs']['prototype'] = array(
	'cdn' => '//ajax.googleapis.com/ajax/libs/prototype/:version/prototype.js',
	'version' => '1.7.0.0',
	'fallback_check' => 'window.Prototype',
);
$config['BakingPlate']['Libs']['swfobject'] = array(
	'cdn' => '//ajax.googleapis.com/ajax/libs/swfobject/:version/swfobject.js',
	'cdnu' => '',
	'version' => '2.2',
);
$config['BakingPlate']['Libs']['firebug'] = array(
	'cdn' => 'https://getfirebug.com/firebug-lite.js'
);