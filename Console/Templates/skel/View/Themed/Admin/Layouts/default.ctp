<!DOCTYPE HTML>
<?php echo $this->Plate->iecc('<html class="ie">', '<9'); ?>
<?php echo $this->Plate->iecc('<html>', false); ?>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo __('Admin'); ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css(array(
			'layout',
			'/batch/css/batch',
		));
		echo $this->fetch('css');
		echo $this->Html->script('libs/modernizr-1.7.min');
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
	echo $this->Plate->lib('jquery', array('fallback' => 'libs/jquery-1.5.0.min'));
	echo $this->Html->script(array(
		'jquery.equalHeight',
		'/batch/js/jquery',
		'script',
	));
	echo $this->fetch('scripts');
?>
</body>
</html>