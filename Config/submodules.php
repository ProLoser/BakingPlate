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
	'linkable'			=> 'git://github.com/ProLoser/linkable.git',
        'batch'				=> 'git://github.com/ProLoser/CakePHP-Batch.git',
        'url_cache'                     => 'http://github.com/lorenzo/url_cache.git'
);
// Submodules that don't fall under any other group
$config['BakingPlate']['extra'] = array(
	'mongodb'			=> 'git://github.com/ichikaway/cakephp-mongodb.git',
	'asset_mapper'		        => 'git://github.com/1Marc/cakephp-asset-mapper.git',
);

// acl plugins
$config['BakingPlate']['acl'] = array(
	'acl'                           => 'git://github.com/sams/alaxos_acl.git',
	'acl_extras'                    => 'git://github.com/markstory/acl_extras.git',
);

$config['BakingPlate']['ceeram'] = array(
	'clear_cache' 		        => 'git://github.com/ceeram/clear_cache.git',
);




$config['BakingPlate']['hyra'] = array(
	'phpunit' 			=> 'git://github.com/Hyra/PHPUnit-Cake2.git',
	'cloudfiles' 			=> 'git://github.com/Hyra/cloudfiles.git',
	'revision' 			=> 'git://github.com/Hyra/revision.git',
	'markdown'			=> 'git://github.com/Hyra/markdown.git',
	'less'				=> 'git://github.com/Hyra/less.git'
);

$config['BakingPlate']['bmcclure'] = array(
	'order'				=> 'git://github.com/bmcclure/CakePHP-Order-Plugin.git',
	'disqus'			=> 'git://github.com/bmcclure/CakePHP-Disqus-API-Plugin.git',
	'media'				=> 'git://github.com/bmcclure/CakePHP-Media-Plugin.git',
	'menu'				=> 'git://github.com/bmcclure/CakePHP-Menu-Plugin.git',
	'auto_asset'			=> 'git://github.com/bmcclure/CakePHP-AutoAsset-Plugin.git',
	'webmaster_tools'		=> 'git://github.com/bmcclure/CakePHP-WebmasterTools-Plugin.git',
	'blog'				=> 'git://github.com/bmcclure/CakePHP-Blog-Plugin.git'
);

$config['BakingPlate']['dereuromark'] = array(
	'upgrade' 			=> 'git://github.com/dereuromark/upgrade.git',
	'tools' 			=> 'git://github.com/dereuromark/tools.git',
	'linkable'			=> 'git://github.com/dereuromark/linkable.git',
	'phpunit'			=> 'git://github.com/dereuromark/PHPUnit-Cake2.git',
);

$config['BakingPlate']['ad7six'] = array(
        'completion'                    => 'git://github.com/AD7six/cakephp-completion.git'
);

$config['BakingPlate']['ndejong'] = array(
	'auto_cache'		        => 'git://github.com/ndejong/CakephpAutocacheBehavior.git'
);

$config['BakingPlate']['neilcrookes'] = array(
	'searchable'			=> 'git://github.com/neilcrookes/searchable.git',
	'rest'				=> 'git://github.com/neilcrookes/CakePHP-ReST-DataSource-Plugin.git',
	'twitter'			=> 'git://github.com/neilcrookes/CakePHP-Twitter-API-Plugin.git',
	'habtm_counter_cache'		=> 'git://github.com/neilcrookes/CakePHP-HABTM-Counter-Cache-Plugin.git',
	'blog'				=> 'git://github.com/neilcrookes/CakePHP-Blog-Plugin.git',
	'gdata'				=> 'git://github.com/neilcrookes/CakePHP-GData-Plugin.git',
	'yahoo_geo_planet'		=> 'git://github.com/neilcrookes/CakePHP-Yahoo-Geo-Planet-Plugin.git',
	'bitly'				=> 'git://github.com/neilcrookes/CakePHP-Bit.ly-Plugin.git',
	'queue'				=> 'git://github.com/neilcrookes/cakephp_queue.git',
	'export'			=> 'git://github.com/neilcrookes/export.git',
	'filter'			=> 'git://github.com/neilcrookes/filter.git',
	'sequence'			=> 'git://github.com/neilcrookes/sequence.git',
	'tree_counter_cache'		=> 'git://github.com/neilcrookes/tree_counter_cache.git',
);

$config['BakingPlate']['markstory'] = array(
	'acl_extras'			=> 'git://github.com/markstory/acl_extras.git',
	'acl_menu'			=> 'git://github.com/markstory/cakephp_menu_component.git',
	'asset_compress'		=> 'git://github.com/markstory/asset_compress.git',
	'geshi'				=> 'git://github.com/markstory/cakephp_geshi.git',
	'vcard'				=> 'git://github.com/markstory/cakephp_vcard.git',
);

$config['BakingPlate']['phally'] = array(
	'cached_acl'			=> 'git://github.com/Phally/cached_acl.git',
	'cache_engines'			=> 'git://github.com/Phally/cache_engines.git',
	'route_enhancements'		=> 'git://github.com/Phally/route_enhancements.git',
	'data_sort'			=> 'git://github.com/Phally/data_sort.git',
);

$config['BakingPlate']['davidpersson'] = array(
	'webmaster_tools'		=> 'git://github.com/davidpersson/webmaster_tools.git',
	'media'				=> 'git://github.com/davidpersson/media.git',
	'queue'				=> 'git://github.com/davidpersson/queue.git',
);

$config['BakingPlate']['jmcneese'] = array(
	'bitmasked'			=> 'git://github.com/jmcneese/bitmasked.git',
	'cacheable'			=> 'git://github.com/jmcneese/cacheable.git',
	'metadata'			=> 'git://github.com/jmcneese/metadata.git',
	'permissionable'		=> 'git://github.com/jmcneese/permissionable.git'
);

$config['BakingPlate']['joebeeson'] = array(
	'campfire'			=> 'git://github.com/joebeeson/campfire.git',
	'embellish'			=> 'git://github.com/joebeeson/embellish.git',
	'mailer'			=> 'git://github.com/joebeeson/mailer.git',
	'referee'			=> 'git://github.com/joebeeson/referee.git',
	'sassy'				=> 'git://github.com/joebeeson/sassy.git'
);

$config['BakingPlate']['milesj'] = array(
	'ajax_handler'			=> 'git://github.com/milesj/cake-ajax_handler.git',
	'auto_login'			=> 'git://github.com/milesj/cake-auto_login.git',
	'cache_kill'			=> 'git://github.com/milesj/cake-cache_kill.git',
	'data_kit'			=> 'git://github.com/milesj/cake-data_kit.git',
	'decoda'			=> 'git://github.com/milesj/cake-decoda.git',
	'feeds'				=> 'git://github.com/milesj/cake-feeds.git',
	'forum'				=> 'git://github.com/milesj/cake-forum.git',
	'spam_blocker'			=> 'git://github.com/milesj/cake-spam_blocker.git',
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
	'linkable'			=> 'git://github.com/ProLoser/linkable.git',
	'cacheable'			=> 'git://github.com/ProLoser/CakePHP-Cacheable.git',
	'supervalidateable'		=> 'git://github.com/ProLoser/cakephp-supervalidatable-behavior.git',
	'cart'				=> 'git://github.com/ProLoser/CakePHP-Cart.git',
	'github'			=> 'git://github.com/ProLoser/CakePHP-Github.git',
	'wizard'			=> 'git://github.com/ProLoser/wizard.git',
	'csv'				=> 'git://github.com/ProLoser/CakePHP-CSV.git',
	'geoip'				=> 'git://github.com/ProLoser/cakephp-geoip.git',
	'webservice'		        => 'git://github.com/ProLoser/webservice_plugin.git',
);

$config['BakingPlate']['sams'] = array(
	'acl'				=> 'git://github.com/sams/alaxos_acl.git',
	'contact'			=> 'git://github.com/sams/contact.git',
	'configuration'			=> 'git://github.com/sams/Configuration.git',
	'page_route'			=> 'git://github.com/sams/PageRoute.git',
	'webmaster_tools'			=> 'git://github.com/sams/webmaster_tools.git',
);

$config['BakingPlate']['mcurry'] = array(
	'ab_test'			=> 'git://github.com/mcurry/ab_test.git',
	'asset'				=> 'git://github.com/mcurry/asset.git',
	'builder'			=> 'git://github.com/mcurry/builder.git',
	'chat'				=> 'git://github.com/mcurry/chat.git',
	'click'				=> 'git://github.com/mcurry/click.git',
	'discogs'			=> 'git://github.com/mcurry/cakephp_datasource_discogs.git',
	'find'				=> 'git://github.com/mcurry/find.git',
	'js'				=> 'git://github.com/mcurry/js.git',
	'js_validate'			=> 'git://github.com/mcurry/js_validate.git',
	'layout_switcher'		=> 'git://github.com/mcurry/layout_switcher.git',
	'html_cache'			=> 'git://github.com/mcurry/html_cache.git',
	'interactive'			=> 'git://github.com/mcurry/interactive.git',
	'sql_log'			=> 'git://github.com/mcurry/sql_log.git',
	'pagination_recall'		=> 'git://github.com/mcurry/pagination_recall.git',
	'progress_bar'			=> 'git://github.com/mcurry/progress_bar.git',
	'seo'				=> 'git://github.com/mcurry/seo.git',
	'simplepie'			=> 'git://github.com/mcurry/simplepie.git',
	'sql_log'			=> 'git://github.com/mcurry/sql_log.git',
	'status'			=> 'git://github.com/mcurry/status.git',
	'tests'				=> 'git://github.com/mcurry/cakephp_tests.git',
	'update'            		=> 'git://github.com/mcurry/update.git',
	'url_cache'			=> 'git://github.com/mcurry/url_cache.git', // MCurry's fork seems to be broken
);

$config['BakingPlate']['lorenzo'] = array(
	'url_cache'			=> 'git://github.com/lorenzo/url_cache.git'
);

$config['BakingPlate']['petteyg'] = array(
	'wapl' 				=> 'git://github.com/petteyg/wapl.git'
);

$config['BakingPlate']['josegonzalez'] = array(
	'log'				=> 'git://github.com/josegonzalez/log.git',
	'purifiable'			=> 'git://github.com/josegonzalez/purifiable.git',
	'page_route'			=> 'git://github.com/josegonzalez/page_route.git',
	'retranslate'			=> 'git://github.com/josegonzalez/retranslatable-behavior.git',
	'gzip'				=> 'git://github.com/josegonzalez/gzip-component.git',
	'sitemap'			=> 'git://github.com/josegonzalez/sitemap-helper.git',
	'settings'			=> 'git://github.com/josegonzalez/settings.git',
	'trackable'			=> 'git://github.com/josegonzalez/trackable-behavior.git',
	'trimmable'			=> 'git://github.com/josegonzalez/trimmable-behavior.git',
	'upload_pack' 			=> 'git://github.com/josegonzalez/uploadpack.git',
	'webservice'			=> 'git://github.com/josegonzalez/webservice_plugin.git',
	'wysiwyg'			=> 'git://github.com/josegonzalez/cakephp-wysiwyg-helper.git',
	'sanction'			=> 'git://github.com/josegonzalez/sanction.git',
	'oh_the_repositories' 		=> 'git://github.com/josegonzalez/oh_the_repositories.git',
);

$config['BakingPlate']['webtechnick'] = array(
	'fileupload'			=> 'git://github.com/webtechnick/CakePHP-FileUpload-Plugin.git',
	'facebook'			=> 'git://github.com/webtechnick/CakePHP-Facebook-Plugin.git',
	'webtecknick'			=> 'git://github.com/webtechnick/CakePHP-Webtechnick-Plugin.git',
	'paypal_ipn'			=> 'git://github.com/webtechnick/CakePHP-Paypal-IPN-Plugin.git',
	'popup'				=> 'git://github.com/webtechnick/CakePHP-Popup-Plugin.git',
	'configuration'			=> 'git://github.com/webtechnick/CakePHP-Configuration-Plugin.git',
	'gigya'				=> 'git://github.com/webtechnick/CakePHP-Gigya-Plugin.git',
	'rake'				=> 'git://github.com/webtechnick/CakePHP-Rake-Plugin.git',
	'seo'				=> 'git://github.com/webtechnick/CakePHP-Seo-Plugin.git',
);

$config['BakingPlate']['cakedc'] = array(
	'bitly'				=> 'git://github.com/CakeDC/bitly.git',
	'categories'			=> 'git://github.com/CakeDC/categories.git',
	'comments'			=> 'git://github.com/CakeDC/comments.git',
	'favorites'			=> 'git://github.com/CakeDC/favorites.git',
	'i18n'				=> 'git://github.com/CakeDC/i18n.git',
	'markup_parsers'		=> 'git://github.com/CakeDC/markup_parsers.git',
	'migrations'			=> 'git://github.com/CakeDC/migrations.git',
	'problems'			=> 'git://github.com/CakeDC/problems.git',
	'ratings'			=> 'git://github.com/CakeDC/ratings.git',
	'recaptcha'			=> 'git://github.com/CakeDC/recaptcha.git',
	'search'			=> 'git://github.com/CakeDC/search.git',
	'tags'				=> 'git://github.com/CakeDC/tags.git',
	'templates'			=> 'git://github.com/CakeDC/templates.git',
	'tiny_mce'			=> 'git://github.com/CakeDC/TinyMCE.git',
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
	'mi_settings'			=> 'git://github.com/AD7six/mi_settings.git',
	'mi_email'			=> 'git://github.com/AD7six/mi_email.git',
	'mi_lists'			=> 'git://github.com/AD7six/mi_lists.git',
	'mi_data_buckets'		=> 'git://github.com/AD7six/mi_data_buckets.git',
	'mi_db'				=> 'git://github.com/AD7six/mi_db.git',
	'mi_pages'			=> 'git://github.com/AD7six/mi_pages.git',
	'mi_hummingbird'		=> 'git://github.com/AD7six/mi_hummingbird.git',
	'mi_maps'			=> 'git://github.com/AD7six/mi_maps.git',
	'mi_write'			=> 'git://github.com/AD7six/mi_write.git',
	'mi_js'				=> 'git://github.com/AD7six/mi_js.git',
	'mi_tags'			=> 'git://github.com/AD7six/mi_tags.git',
	'mi_queue'			=> 'git://github.com/AD7six/mi_queue.git',
);

$config['BakingPlate']['predominant'] = array(
	'twig_view'			=> 'git://github.com/predominant/TwigView.git',
	'cake_social'		        => 'git://github.com/predominant/cake_social.git',
	'woopra'			=> 'git://github.com/predominant/Woopra.git',
	'goodies'			=> 'git://github.com/predominant/goodies.git',
);


$config['BakingPlate']['jrbasso'] = array(
	'json_plugin' 			=> 'git://github.com/jrbasso/json_plugin.git'
);

$config['BakingPlate']['slywalker'] = array(
	'TwitterBootstrap' => 'git://github.com/slywalker/TwitterBootstrap.git'
);


$config['BakingPlate']['octobear'] = array(
	'environments' 			=> 'git://github.com/OctoBear/cakephp-environments.git'
);

$config['BakingPlate']['simkimsia'] = array(
    'utility_lib' 			=> 'git://github.com/simkimsia/UtilityLib.git'
);

// Commonly Used Vendors
$config['BakingPlate']['vendors'] = array(
	'php_arrays'			=> 'git://github.com/debuggable/php_arrays.git',
	'lessphp'			=> 'git://github.com/leafo/lessphp.git',
	'swift_mailer'			=> 'git://github.com/swiftmailer/swiftmailer.git',
	'phpunit'			=> 'git://github.com/sebastianbergmann/phpunit.git',
	'cssmin'			=> 'git://gist.github.com/911988.git',
	'jsmin'				=> 'git://github.com/rgrove/jsmin-php.git',
	'phpthumb'			=> 'git://github.com/masterexploder/PHPThumb.git',
	'http_socket_oauth'		=> 'git://github.com/neilcrookes/http_socket_oauth.git',
	'magic_mime'			=> 'git://github.com/davidpersson/mm.git'
);
