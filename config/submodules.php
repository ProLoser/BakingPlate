<?php
/**
 * see if some extra sugar can be added these are old comments on ideas
 * using markstory asset compress CakeDC is way behind on magic stuff
 *
 * could this use a alias system whereby is the value is not a git url
 * it look for BakingPlate.{key}.{value} to get giturl
 *
 * eg within core mark_story => asset_compress
 * adds submodule asset_compress from group mark_story
 * 
 * I think it would be nice for peeps to be able make a group of own desired plugins
 * of course this is quite easy if using git since user can make a branch on have own
 * group within - the alis system is not essential but would be nice
 *
 * also since users may want CakeDc over Mark Story version of asset compress or other plugins
 * then some checking to ensure that clashes don't occur - of course git would bork in thise case
 * too - but Bp should avoid this
 *
 * the group vendors is a special case should always goto vendor dir 
 * 
 */
// Required submodules
$config['BakingPlate']['core'] = array(
	'debug_kit'			=> 'git://github.com/cakephp/debug_kit.git',
	'lazy_model'		=> 'git://github.com/Phally/lazy_model.git',
	'linkable'			=> 'git://github.com/Terr/linkable.git',
	'asset_compress'	=> 'git://github.com/markstory/asset_compress.git',
	'analogue'			=> 'git://github.com/joebeeson/analogue.git',
	'navigation'		=> 'git://github.com/sams/cakephp-navigation.git',
	'webmaster_tools'	=> 'git://github.com/davidpersson/webmaster_tools.git',
	'batch'				=> 'git://github.com/ProLoser/CakePHP-Batch.git',
);
// Submodules that don't fall under any other group
$config['BakingPlate']['extra'] = array(
	'mongodb'			=> 'git://github.com/ichikaway/mongoDB-Datasource.git',
	'searchable'		=> 'git://github.com/neilcrookes/searchable.git',
	'clear_cache' 		=> 'git://github.com/ceeram/clear_cache.git',
	'asset_mapper'		=> 'git://github.com/1Marc/cakephp-asset-mapper.git',
);

$config['BakingPlate']['markstory'] = array(
	'acl_extras'		=> 'git://github.com/markstory/acl_extras.git',
	'acl_menu'			=> 'git://github.com/markstory/cakephp_menu_component.git',
	'geshi'				=> 'git://github.com/markstory/cakephp_geshi.git',
	'vcard'				=> 'git://github.com/markstory/cakephp_vcard.git',
);

$config['BakingPlate']['davidpersson'] = array(
	'webmaster_tools'	=> 'git://github.com/davidpersson/webmaster_tools.git',
	'media'				=> 'git://github.com/davidpersson/media.git',
	'queue'				=> 'git://github.com/davidpersson/queue.git',
);

$config['BakingPlate']['milesj'] = array(
	'ajax_handler'		=> 'git://github.com/milesj/cake-ajax_handler.git',
	'auto_login'		=> 'git://github.com/milesj/cake-auto_login.git',
	'cache_kill'		=> 'git://github.com/milesj/cake-cache_kill.git',
	'data_kit'			=> 'git://github.com/milesj/cake-data_kit.git',
	'decoda'			=> 'git://github.com/milesj/cake-decoda.git',
	'feeds'				=> 'git://github.com/milesj/cake-feeds.git',
	'forum'				=> 'git://github.com/milesj/cake-forum.git',
	'spam_blocker'		=> 'git://github.com/milesj/cake-spam_blocker.git',
	'uploader'			=> 'git://github.com/milesj/cake-uploader.git',
	'we_game'			=> 'git://github.com/milesj/cake-we_game.git',
);

$config['BakingPlate']['mariano'] = array(
	'tagging'			=> 'git://github.com/mariano/tagging.git',
	'syrup'				=> 'git://github.com/mariano/syrup.git',
	'robot'				=> 'git://github.com/mariano/robot.git',
	'openid'			=> 'git://github.com/mariano/openid.git',
);

$config['BakingPlate']['proloser'] = array(
	'batch'				=> 'git://github.com/ProLoser/CakePHP-Batch.git',
	'joinable'			=> 'git://github.com/ProLoser/CakePHP-Joinable.git',
	'cacheable'			=> 'git://github.com/ProLoser/CakePHP-Cacheable.git',
	'supervalidateable'	=> 'git://github.com/ProLoser/cakephp-supervalidatable-behavior.git',
	'cart'				=> 'git://github.com/ProLoser/CakePHP-Cart.git',
	'github'				=> 'git://github.com/ProLoser/CakePHP-Github.git',
	'wizard'			=> 'git://github.com/ProLoser/wizard.git',	
	'csv'				=> 'git://github.com/ProLoser/CakePHP-CSV.git',
	'geoip'				=> 'git://github.com/ProLoser/cakephp-geoip.git',
);

$config['BakingPlate']['sams'] = array(
	'navigation'		=> 'git://github.com/sams/cakephp_navigation.git',
	'static_cache'		=> 'git://github.com/sams/static_cache.git',
	'manifesto'			=> 'git://github.com/sams/manifesto.git',
	'contact'			=> 'git://github.com/sams/contact.git',
);

$config['BakingPlate']['mcurry'] = array(
	'ab_test'			=> 'git://github.com/mcurry/ab_test.git',
	'asset'			=> 'git://github.com/mcurry/asset.git',
	'builder'			=> 'git://github.com/mcurry/builder.git',
	'chat'		=> 'git://github.com/mcurry/chat.git',
	'click'		=> 'git://github.com/mcurry/click.git',
	'discogs'		=> 'git://github.com/mcurry/cakephp_datasource_discogs.git',
	'find'		=> 'git://github.com/mcurry/find.git',
	'js'		=> 'git://github.com/mcurry/js.git',
	'js_validate'		=> 'git://github.com/mcurry/js_validate.git',
	'layout_switcher'	=> 'git://github.com/mcurry/layout_switcher.git',
	'html_cache'		=> 'git://github.com/mcurry/html_cache.git',
	'interactive'		=> 'git://github.com/mcurry/interactive.git',
	'pagination_recall'		=> 'git://github.com/mcurry/pagination_recall.git',
	'progress_bar'		=> 'git://github.com/mcurry/progress_bar.git',
	'seo'		=> 'git://github.com/mcurry/seo.git',
	//'simplepie'			=> 'git://github.com/mcurry/simplepie.git',
	'sql_log'		=> 'git://github.com/mcurry/sql_log.git',
	'tests'		=> 'git://github.com/mcurry/cakephp_tests.git',
	'update'             => 'git://github.com/mcurry/update.git',
	'url_cache'		=> 'git://github.com/mcurry/url_cache.git',
);

$config['BakingPlate']['petteyg'] = array(
	'wapl' 				=> 'git://github.com/petteyg/wapl.git'
);

$config['BakingPlate']['josegonzalez'] = array(
	'log'				=> 'git://github.com/josegonzalez/log.git',
	'purifiable'		=> 'git://github.com/josegonzalez/purifiable.git',
	'retranslate'		=> 'git://github.com/josegonzalez/retranslatable-behavior.git',
	'gzip'				=> 'git://github.com/josegonzalez/gzip-component.git',
	'sitemap'			=> 'git://github.com/josegonzalez/sitemap-helper.git',
	'settings'			=> 'git://github.com/josegonzalez/settings.git',
	'trackable'			=> 'git://github.com/josegonzalez/trackable-behavior.git',
	'trimmable'			=> 'git://github.com/josegonzalez/trimmable-behavior.git',
	'upload_pack' 		=> 'git://github.com/josegonzalez/uploadpack.git',
	'webservice'		=> 'git://github.com/josegonzalez/webservice_plugin.git',
	'wysiwyg'			=> 'git://github.com/josegonzalez/cakephp-wysiwyg-helper.git',
);

$config['BakingPlate']['webtechnick'] = array(
	'fileupload'		=> 'git://github.com/webtechnick/CakePHP-FileUpload-Plugin.git',
	'facebook'			=> 'git://github.com/webtechnick/CakePHP-Facebook-Plugin.git',
	'webtecknick'		=> 'git://github.com/webtechnick/CakePHP-Webtechnick-Plugin.git',
	'paypal_ipn'		=> 'git://github.com/webtechnick/CakePHP-Paypal-IPN-Plugin.git',
	'popup'				=> 'git://github.com/webtechnick/CakePHP-Popup-Plugin.git',
	'configuration'	=> 'git://github.com/webtechnick/CakePHP-Configuration-Plugin.git',
	'gigya'				=> 'git://github.com/webtechnick/CakePHP-Gigya-Plugin.git',
	'rake'				=> 'git://github.com/webtechnick/CakePHP-Rake-Plugin.git',
	'seo'				=> 'git://github.com/webtechnick/CakePHP-Seo-Plugin.git',
);

$config['BakingPlate']['cakedc'] = array(
	'asset_compress'	=> 'git://github.com/CakeDC/asset_compress.git',
	'bitly'	                => 'git://github.com/CakeDC/bitly.git',
	'categories'			=> 'git://github.com/CakeDC/categories.git',
	'comments'			=> 'git://github.com/CakeDC/comments.git',
	'favourites'				=> 'git://github.com/CakeDC/favourites.git',
	'i18n'				=> 'git://github.com/CakeDC/i18n.git',
	'markup_parsers'	=> 'git://github.com/CakeDC/markup_parsers.git',
	'migrations'		=> 'git://github.com/CakeDC/migrations.git',
	'problems'			=> 'git://github.com/CakeDC/problems.git',
	'ratings'			=> 'git://github.com/CakeDC/ratings.git',
	'recaptcha'			=> 'git://github.com/CakeDC/recaptcha.git',
	'search'			=> 'git://github.com/CakeDC/search.git',
	'tags'				=> 'git://github.com/CakeDC/tags.git',
	'templates'				=> 'git://github.com/CakeDC/templates.git',
	'tiny_mce'				=> 'git://github.com/CakeDC/TinyMCE.git',
	'users'				=> 'git://github.com/CakeDC/users.git',
	'utils'				=> 'git://github.com/CakeDC/utils.git',
);

$config['BakingPlate']['mi'] = array(
	'mi'				=> 'git://github.com/AD7six/mi.git',
	'mi_seo'			=> 'git://github.com/AD7six/mi_seo.git',
	'mi_panel'			=> 'git://github.com/AD7six/mi_panel.git',
	'mi_asset'			=> 'git://github.com/AD7six/mi_asset.git',
	'mi_acl'			=> 'git://github.com/AD7six/mi_acl.git',
	'mi_enum'			=> 'git://github.com/AD7six/mi_enums.git',
	'mi_settings'		=> 'git://github.com/AD7six/mi_settings.git',
	'mi_email'			=> 'git://github.com/AD7six/mi_email.git',
	'mi_lists'			=> 'git://github.com/AD7six/mi_lists.git',
	'mi_data_buckets'	=> 'git://github.com/AD7six/mi_data_buckets.git',
	'mi_db'				=> 'git://github.com/AD7six/mi_db.git',
	'mi_pages'			=> 'git://github.com/AD7six/mi_pages.git',
	'mi_hummingbird'	=> 'git://github.com/AD7six/mi_hummingbird.git',
	'mi_maps'			=> 'git://github.com/AD7six/mi_maps.git',
	'mi_write'			=> 'git://github.com/AD7six/mi_write.git',
	'mi_js'				=> 'git://github.com/AD7six/mi_js.git',
	'mi_tags'			=> 'git://github.com/AD7six/mi_tags.git',
	'mi_queue'			=> 'git://github.com/AD7six/mi_queue.git',
	
);

// Commonly Used Vendors
$config['BakingPlate']['vendors'] = array(
	'php_arrays'		=> 'git://github.com/debuggable/php_arrays.git',
	'simpletest'		=> '',
	'phpunit'		=> '',
	'cssmin'			=> 'git://gist.github.com/911988.git',
	'jsmin'			=> 'git://github.com/rgrove/jsmin-php.git',
	'phpthumb'		=> 'git://github.com/masterexploder/PHPThumb.git',
);
