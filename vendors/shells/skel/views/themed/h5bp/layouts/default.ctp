<?php
/**
 *
 * PHP 5.2+
 *
 * TODO: Write readme, start wiki make drawing board plans
 * TODO: Implement HTML5 Boilerplate methods here (check that its inline with Paul, Divya et als work)
 * TODO: Implement Initial Changes to code that this projects bakes based on
 * changes made to my fork of cakeplate
 * TODO: add more things
 * 
 */
$isDebug = Configure::read('debug');
$siteExtras = Configure::read('Site.extras');
// first flush here
?><!doctype html>  
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
	<meta charset="utf-8">
	<?php /* todo: make this optional */ ?>
	<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
	<title>
		<?php __('BakingPlate: Html5 Boilerplate Theme'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php /* todo: a description var will be set to set within the beforeRender operation of the app */ ?>
	<meta name="description" content="">
	<?php /* todo: make an option to fill this from some source */ ?>
	<meta name="author" content="<?php echo $siteExtras['author']; ?>">
	<?php
	// todo: make this output other icons eg apple
		echo $this->Html->meta('icon');
	// todo: change styling control initially projects will use import
	// based sheet one that is compat with AssetCompress
		echo $this->Html->css('style');
	
		// media handheld
		echo $this->Html->css('handheld', null, array('media' => 'handheld'));
	?>
 
  <!-- todo: make this use helper - make it find js from theme
	 All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
  <?php echo $this->Html->script('libs/modernizr-1.6.min'); ?>
</head>
<?php
	/* todo: body id & class or not inline with vanilla concept of bakingplate */
	/* todo: phpied flush twice first before body */
?>
<body>
	<div id="container">
		<header id="header">
			<?php echo $this->element('header'); ?>
		</header>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $content_for_layout; ?>

		</div>
		<footer id="footer">
			<?php echo $this->element('footer'); ?>
		</footer>
	</div>
	<?php
		// some helpers here that output footer code will use 
		// asset compress normally but will offer options for
		// not instances of this project to bake with options 
		// pertaining to cake, html5 boilerplate best practices
		// 
	?>

  <!--  todo: make this element/helper or what
	Grab Google CDN's jQuery. fall back to local if necessary -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.js"></script>
  <script>!window.jQuery && document.write(unescape('%3Cscript src="<?php echo $this->Html->url('/h5bp/js/libs/jquery-1.4.4.js'); ?>"%3E%3C/script%3E'))</script>
  
	<?php
		// todo: make this use asset compress
		echo $this->Html->script(array('plugins', 'script'));
	
		// footer extras google analytics and yahoo_profiling
		if($siteExtras['dd_png'])	{
			echo $this->element('extras/dd_png', array('dd_png' => $siteExtras['dd_png']));
		}
		// todo: debug or admin
		if($isDebug)	{
			echo $this->element('extras/yahoo_profiling');
		}
		if(!$isDebug && $siteExtras['google_analytics'])	{
			echo $this->element('extras/google_analytics', array('google_analytics' => $siteExtras['google_analytics']));
		}
	?>

</body>
</html>
<?php
	// final flush
?>
