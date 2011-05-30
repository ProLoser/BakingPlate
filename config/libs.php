<?php
/**
 * Do not use local paths in this file!
 *
 * All libraries should be referenced off-server. Do not use this for self-hosted CDNs
 *
 * @author Dean Sofer
 */

/**
 *
 * Google Hosted JS Libs
 *
 *  jQuery
 *  jQuery UI
 *  Chrome Frame
 *  Dojo
 *  Ext Core
 *  MooTools
 *  Prototype
 *  script.aculo.us
 *  SWFObject
 *  Yahoo! User Interface Library (YUI)
 *  WebFont Loader
 *  
 **/

$config['BakingPlate']['Libs']['jquery'] = array(
	// url to cdn
	'cdn' => '//ajax.googleapis.com/ajax/libs/jquery/:version/jquery.min.js',
	// (optional) url to uncompressed version
	'cdnu' => '//ajax.googleapis.com/ajax/libs/jquery/:version/jquery.js',
	// default version to use
	'version' => '1.6',
	// (optional) snippet of js to check if the lib is active
	'fallback_check' => 'window.jQuery',
);
$config['BakingPlate']['Libs']['jqueryui'] = array(
	'cdn' => '//ajax.googleapis.com/ajax/libs/jqueryui/:version/jquery-ui.min.js',
	'cdnu' => '//ajax.googleapis.com/ajax/libs/jqueryui/:version/jquery-ui.js',
	'version' => '1.8',
	'fallback_check' => null,
);
// Chrome Frame
$config['BakingPlate']['Libs']['chrome-frame'] = array(
	'cdn' => '//ajax.googleapis.com/ajax/libs/chrome-frame/:version/CFInstall.min.js',
	'cdnu' => '//ajax.googleapis.com/ajax/libs/chrome-frame/:version/CFInstall.js',
	'version' => '1.0.2',
	'fallback_check' => null,
);
// Dojo
$config['BakingPlate']['Libs']['dojo'] = array(
	'cdn' => '//ajax.googleapis.com/ajax/libs/dojo/:version/dojo.xd.js',
	'cdnu' => '//ajax.googleapis.com/ajax/libs/dojo/:version/dojo.xd.js.uncompressed.js',
	'version' => '1.6.0',
	'fallback_check' => 'window.dojo',
);
// Ext
$config['BakingPlate']['Libs']['ext-core'] = array(
	'cdn' => '//ajax.googleapis.com/ajax/libs/ext-core/:version/ext-core.js',
	'cdnu' => '//ajax.googleapis.com/ajax/libs/ext-core/:version/ext-core-debug.js',
	'version' => '3.1.0',
	'fallback_check' => 'window.Ext',
);
//  mootools
$config['BakingPlate']['Libs']['mootools'] = array(
	'cdn' => '//ajax.googleapis.com/ajax/libs/mootools/:version/mootools-yui-compressed.js',
	'cdnu' => '//ajax.googleapis.com/ajax/libs/mootools/:version/mootools.js',
	'version' => '1.3.1',
	'fallback_check' => 'window.MooTools',
);
// Prototype
$config['BakingPlate']['Libs']['prototype'] = array(
	'cdn' => '//ajax.googleapis.com/ajax/libs/prototype/:version/prototype.js',
	'version' => '1.7.0.0',
	'fallback_check' => 'window.Prototype',
);
// Scriptaculous
$config['BakingPlate']['Libs']['scriptaculous'] = array(
	'cdn' => '//ajax.googleapis.com/ajax/libs/scriptaculous/:version/scriptaculous.js',
	'version' => '1.8.3',
	'fallback_check' => null,
);

// SWFObject
$config['BakingPlate']['Libs']['swfobject'] = array(
	'cdn' => '//ajax.googleapis.com/ajax/libs/swfobject/:version/swfobject.js',
	'cdnu' => '//ajax.googleapis.com/ajax/libs/swfobject/:version/swfobject_src.js',
	'fallback_check' => 'window.swfobject',
	'version' => '2.2',
);
// YUI
$config['BakingPlate']['Libs']['yui'] = array(
	'cdn' => '//ajax.googleapis.com/ajax/libs/yui/3.3.0/build/yui/:version/yui-min.js',
	'cdnu' => '//ajax.googleapis.com/ajax/libs/yui/3.3.0/build/yui/:version/yui.js',
	'fallback_check' => 'window.YAHOO',
	'version' => '3.3.0',
);

// Webfont.js
$config['BakingPlate']['Libs']['webfont'] = array(
	'cdn' => '//ajax.googleapis.com/ajax/libs/webfont/:version/webfont.js',
	'cdnu' => '//ajax.googleapis.com/ajax/libs/webfont/:version/webfont_debug.js',
	'fallback_check' => 'window.webfont',
	'version' => '1.0.19',
);

/**
 * Misc Js Libs
 * Firebug-lite
 * YahooProfiler
 */
$config['BakingPlate']['Libs']['firebug-lite'] = array(
	'cdn' => 'https://getfirebug.com/firebug-lite.js'
);
$config['BakingPlate']['Libs']['yahoo-profiler'] = array(
	'cdn' => 'http://yui.yahooapis.com/2.9.0/build/profiler/profiler-min.js'
);


