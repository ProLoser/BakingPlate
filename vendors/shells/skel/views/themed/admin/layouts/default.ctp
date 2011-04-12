<!DOCTYPE HTML>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('Admin'); ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('print', null, array('media' => 'print'));
		echo $this->Html->css(array(
			'green/screen',
			'green/datepicker',
			'../js/visualize/visualize',
			'../js/jwysiwyg/jquery.wysiwyg',
			'../js/fancybox/jquery.fancybox-1.3.0',
			'tipsy',
		));
		echo "<!--[if IE]>{$this->Html->css('ie')}{$this->Html->script('excanvas')}<![endif]-->";
		echo $this->Html->script(array(
			'jquery',
			'jquery-ui',
			'jquery.img.preload',
			'hint',
			'visualize/jquery.visualize',
			'jwysiwyg/jquery.wysiwyg',
			'fancybox/jquery.fancybox-1.3.0',
			'jquery.tipsy',
			'custom_green',
		));
		echo $scripts_for_layout;
	?>
</head>
<body>
	<div class="content_wrapper">
		<div id="header">
			<?php echo $this->element('layout/header');?>
		</div>
		<?php echo $this->element('layout/sidepanel');?>
		<div id="content">
			<div class="inner">
				<?php echo $this->Session->flash(); ?>
				<?php echo $this->Session->flash('email'); ?>
				<?php echo $content_for_layout; ?>
			</div>
			<div id="footer">
				<?php echo $this->element('layout/footer');?>
			</div>
		</div>
	</div>
</body>
</html>