<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if lt IE 7 ]> <html xmlns="http://www.w3.org/1999/xhtml" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html xmlns="http://www.w3.org/1999/xhtml" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html xmlns="http://www.w3.org/1999/xhtml" class="no-js ie8"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html xmlns="http://www.w3.org/1999/xhtml" class="no-js"> <!--<![endif]-->
<head>
	<?php
	 if(Configure::read('site.ChromeFrame')):
		echo $this->element('extras/chrome_frame.ctp');
	 endif;
	?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php if(isset($description_for_layout)) echo $this->Html->meta('description', array('content' => $description_for_layout)); ?>
	<meta name="author" content="<?php echo Configure::read('site.Author'); ?>" />
	<?php
	// If your app is not in root or site or your not using the favicon and apple touch there set the cfg in config/bootstrap.php
	if(Configure::read('site.FavIconUrl')): ?>
	<link rel="shortcut icon" href="<?php echo $this->Html->url(Configure::read('faviconUrl')); ?>" />
	<?php endif; if(Configure::read('site.AppleIconUrl')): ?>
	<link rel="apple-touch-icon" href="<?php echo $this->Html->url(Configure::read('appleiconUrl')); ?>" />
	<?php endif;
  
	// we are using asset compress - alternatives exist too but this plugin is the nuts
	$this->AssetCompress->css(array('style'));		
	echo $this->AssetCompress->includeCss();
	
	//Don't include handheld in asset because it needs media="handheld"
	echo $this->Html->css(array('handheld'),null,array('media'=>'handheld'));	
	
	//Example of how to use google webfonts - see webroot/css/custom.css (this is from Cakeplate see that for info)
	//echo $this->Html->css('http://fonts.googleapis.com/css?family=Lobster',NULL,array('inline'=>true));
  ?>
  
  <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
  <?php echo $this->Html->script('libs/modernizr-1.6.min.js'); ?>
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
	/**
	 * you can set
	 * `site.JsLib.lib` to mootools if you like or prototype default is jquery since its the nuts
	 * `site.JsLib.version` the version is 1.5.0 (make sure you also set this if you change the lib)
	 */
	if(Configure::read('site.JsLib.version'))	{
		echo $this->element('extras/cdn_fallback', compact(Configure::read('site.JsLib')));
	}	

	$this->AssetCompress->script(array('plugins','script'));
	echo $this->AssetCompress->includeJs();

	// footer extras google analytics and yahoo_profiling
	if(Configure::read('site.DrewDillerPng'))	{
		echo $this->element('extras/dd_png', array('dd_png' => Configure::read('site.DrewDillerPng')));
	}
	// todo: debug or admin
	if(Configure::read('site.YahooProfiler'))	{
		echo $this->element('extras/yahoo_profiler');
	}
	if(!Configure::read('debug') && Configure::read('site.GoogleAnalytics'))	{
		echo $this->element('extras/google_analytics', array('google_analytics' => $siteExtras['google_analytics']));
	}
?>

</body>
</html>