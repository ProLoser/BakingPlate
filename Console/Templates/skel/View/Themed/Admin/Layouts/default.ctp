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
echo $this->Plate->iecc('<html class="ie">', '<9');
echo $this->Plate->iecc('<html>', false); ?>
?>

  <head>
	<?php echo $this->Html->charset(); ?>
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>
		<?php echo __('Admin'); ?>:
	    <?php echo $this->fetch('title'); ?>

	</title>
	
	<meta name="viewport" content="width=device-width">
	
	<?php echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon')); ?> 
	<?php echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon', 'rel' => 'shortcut icon')); ?> 
	<?php echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon', 'rel' => 'apple-touch-icon')); ?> 

	<?php
	    echo $this->fetch('meta');
		echo $this->Html->css(array(
			'layout',
			'/batch/css/batch',
		));
		echo $this->fetch('css');
		echo $this->Html->script('vendor/modernizr-2.6.2.min');
	?>

  </head>
  <body>
	<aside id="sidebar">
		<?php echo $this->element('layout/navigation'); ?>
	</aside>

	<section id="main">

		<?php echo $this->Session->flash(); ?>
		<?php echo $this->Session->flash('email'); ?>
		<?php echo $this->fetch('content'); ?>

		<div class="spacer"></div>
	</section>
<?php
	echo $this->Plate->lib('jquery', array('compressed' => true, 'version' => '1.7.1', 'fallback' => 'vendor/jquery-1.7.1.min'));
	echo $this->Html->script(array(
		'jquery.equalHeight',
		'/batch/js/jquery',
		'script',
	));
	echo $this->fetch('scripts');
?>
</body>
</html>