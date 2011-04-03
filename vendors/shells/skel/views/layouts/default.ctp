<?php
/**
 * todo: make default non themed views use a html boilerplate of sorts (not html5)
 *
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
echo $this->Html->start(array('iecc' => true));
?>
	<title>
		<?php echo $title_for_layout; ?> 
	</title>
	<?php echo $this->Plate->chromeFrame(); ?> 
	<?php echo $this->Html->meta('description', array('content' => $description_for_layout)); ?> 
	<?php echo $this->Html->meta('keywords', array('content' => $keywords_for_layout)); ?> 
	<?php echo $this->Html->meta('author', array('content' => 'CakePHP Baking Plate')); ?> 
	<?php echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon')); ?> 
	<?php echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon', 'rel' => 'shortcut icon')); ?> 
	<?php echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon', 'rel' => 'apple-touch-icon')); ?> 
	<?php echo $this->Html->css(array('handheld'), null, array('media' => 'handheld')); ?> 
<?php $this->AssetCompress->css(array(
	'style',
)); ?>
	<?php echo $this->AssetCompress->includeCss(); ?> 
<?php $this->AssetCompress->script(array(
	'plugins',
	'script',
)); ?> 
	<?php echo $this->Plate->modernizr(); ?>
	<?php echo $scripts_for_layout; ?>
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
	echo $this->Plate->jsLib();
	echo $this->AssetCompress->includeJs();
	echo $this->Plate->pngFix();
	echo $this->Plate->profiling();
	echo $this->Plate->analytics();
?>
</body>
</html>