<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
echo $this->Html->docType();
echo $this->Plate->html();
?>
<head>
	<?php echo $this->Html->charset(); ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>
		<?php echo $title_for_layout; ?> 
	</title>
	
	<!-- in some cases we have empty description meta - keywords are of debatable worth-->
	<meta name="description" content="<?php if (!empty($description_for_layout)) echo $description_for_layout; ?>">
	<meta name="keywords" content="<?php if (!empty($keywords_for_layout)) echo $keywords_for_layout; ?>">
	<meta name="author" content="CakePHP with Baking Plate">
	
	<meta name="viewport" content="width=device-width">
	
	<?php echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon')); ?> 
	<?php echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon', 'rel' => 'shortcut icon')); ?> 
	<?php echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon', 'rel' => 'apple-touch-icon')); ?> 

	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css(array('style.css'));
		#!# echo $this->AssetCompress->css('style.css');
		#!# echo $this->AssetCompress->includeCss();
		echo $this->Html->script('libs/modernizr-2.5.3.min', array('type' => false));
	?>
</head>
<body>
	<?php $this->element('common/browsehappy'); ?>
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
	echo $this->Plate->lib('jquery', array('compressed' => true));
	echo $this->Html->script(array('plugins', 'script'));
	#!# echo $this->AssetCompress->script('script');
	
	#!# echo $this->AssetCompress->includeJs();
	echo $scripts_for_layout;

	echo $this->Plate->analytics();
	echo $this->Plate->chrome();
?>
</body>
</html>
