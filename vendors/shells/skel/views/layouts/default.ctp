<?php
/**
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.console.libs.templates.skel.views.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?><!DOCTYPE HTML>
<?php echo $this->Plate->html(); ?>
<head>
	<?php echo $this->Html->charset(); ?> 
	<title>
		<?php echo $title_for_layout; ?> 
	</title>
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<!-- in some cases we have empty description meta - keywords are of debatable worth-->
	<meta name="description" content="<?php if (!empty($description_for_layout)) echo $description_for_layout; ?>">
	<meta name="keywords" content="<?php if (!empty($keywords_for_layout)) echo $keywords_for_layout; ?>">
	<meta name="author" content="Cakephp with Baking Plate">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<?php echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon')); ?> 
	<?php echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon', 'rel' => 'shortcut icon')); ?> 
	<?php echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon', 'rel' => 'apple-touch-icon')); ?> 

<?php 
	$this->AssetCompress->css(array(
		'style',
		'handheld',
	));
	echo $this->AssetCompress->includeCss();

	$this->AssetCompress->script(array(
		'plugins',
		'script',
	));

	$this->Html->script('libs/modernizr-1.7.min');
	echo $styles_for_layout;
?> 
</head>
<body>
	<div id="container">
		<header>
			<?php echo $this->element('layout/header'); ?>
		</header>
		<div id="main">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->Session->flash('auth'); ?>

			<?php echo $content_for_layout; ?>

		</div>
		<footer>
			<?php echo $this->element('layout/footer'); ?>
		</footer>
	</div>
<?php
	echo $this->Plate->lib('jquery');
	echo $this->AssetCompress->includeJs();
	echo $this->Plate->pngFix();
	echo $this->Plate->analytics();
	echo $scripts_for_layout;
?>
</body>
</html>
