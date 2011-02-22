<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if lt IE 7 ]> <html xmlns="http://www.w3.org/1999/xhtml" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html xmlns="http://www.w3.org/1999/xhtml" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html xmlns="http://www.w3.org/1999/xhtml" class="no-js ie8"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html xmlns="http://www.w3.org/1999/xhtml" class="no-js"> <!--<![endif]-->
<head>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
<?php
	echo $this->element('extras/chrome_frame.ctp');
	echo $this->Html->meta('description', array('content' => $description_for_layout));
	echo $this->Html->meta('keywords', array('content' => $keywords_for_layout));
	echo $this->Html->meta('author', array('content' => Configure::read('site.Author')));
	echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon'));
	echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon', 'rel' => 'shortcut icon'));
	echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon', 'rel' => 'apple-touch-icon'));

	$this->AssetCompress->css(array(
		'style',
	));		
	echo $this->AssetCompress->includeCss();
	echo $this->Html->css(array('handheld'), null, array('media' => 'handheld'));
	
	//Example of how to use google webfonts - see webroot/css/custom.css (this is from Cakeplate see that for info)
	//echo $this->Html->css('http://fonts.googleapis.com/css?family=Lobster',NULL,array('inline'=>true));
	
	echo $this->Html->script('libs/modernizr-1.6.min.js');
?>
</head>
<body lang="en">
	<div id="container">
		<div id="header">
			<?php echo $this->element('layout/header'); ?>
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $content_for_layout; ?>

		</div>
		<div id="footer">
			<?php echo $this->element('layout/footer'); ?>
		</div>
	</div>
<?php
	// TODO: REALLY need to implement CDN fallback in helper. A snippet is just too messy. Args: api, fallback (path), version = null, compressed = true
	$this->AssetCompress->script(array(
		'plugins',
		'script',
	));
	echo $this->AssetCompress->includeJs();
	
	// todo: debug or admin
	echo $this->element('extras/dd_png');
	echo $this->element('extras/yahoo_profiler');
	echo $this->element('extras/google_analytics');
?>
</body>
</html>