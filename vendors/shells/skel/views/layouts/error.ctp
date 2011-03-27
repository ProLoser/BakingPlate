<?php
/**
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('CakePHP: the rapid development php framework:'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<style type="text/css">
		.admin, .regularuser {}
		.admin  { border:1px solid red }
		.regularuser { border:1px solid blue }
		.admin p { color: #030303;}
		.regularuser p { color: #ededed; }
		.regUsr, .gstUsr { display: block; width: 250px; position: absolute; right: .3em;top:.2em; }
		
		#header h1,
		#header .nav {float: left}
		#header .nav {clear: left; margin-bottom:.4em}
		#header .nav li {float: left; display: inline}
		#header .nav a {display: block}
		#header a:link,
		#header a:active,
		#header a:visited  { color: white}
		#header a:hover  { color: blue}
	</style>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');

		echo $scripts_for_layout;
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo $this->Html->link(__('CakePHP: the rapid development php framework', true), 'http://cakephp.org'); ?></h1>
			<div class="nav">
				<ul>
					<li><a href="/auth">home</a></li>
					<li><a href="/auth/about">about</a></li>
					<li><a href="/auth/posts">posts</a></li>
					<li><a href="/auth/contact">contact</a></li>
				</ul>
			</div>
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $content_for_layout; ?>

		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt'=> __('CakePHP: the rapid development php framework', true), 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
	<p><?php echo Security::hash('admin', null, TRUE); ?></p>
	<p><?php echo Security::hash('leons1', null, TRUE); ?></p>
	<p><?php echo Security::hash('jimmy7', null, TRUE); ?></p>
	<p><?php echo Security::hash('password', null, TRUE); ?></p>
</body>
</html>