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
echo $this->Html->start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if lt IE 7 ]> <html xmlns="http://www.w3.org/1999/xhtml" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html xmlns="http://www.w3.org/1999/xhtml" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html xmlns="http://www.w3.org/1999/xhtml" class="no-js ie8"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html xmlns="http://www.w3.org/1999/xhtml" class="no-js"> <!--<![endif]-->
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Plate->chromeFrame();
		echo $this->Html->meta('description', array('content' => $description_for_layout));
		echo $this->Html->meta('keywords', array('content' => $keywords_for_layout));
		echo $this->Html->meta('author', array('content' => Configure::read('site.Author')));
		echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon'));
		echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon', 'rel' => 'shortcut icon'));
		echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon', 'rel' => 'apple-touch-icon'));

		echo $this->Html->css(array('handheld'), null, array('media' => 'handheld'));
		$this->AssetCompress->css(array(
			'style',
		));
		echo $this->AssetCompress->includeCss();
		echo $this->Plate->modernizr();
		echo $scripts_for_layout;
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<?php echo $this->element('layout/header'); ?>
			<?php echo $this->element('layout/login'); ?>
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->Session->flash('auth'); ?>

			<?php
				if(isset($sidebar_for_layout)):
					// section could have a title string passed
					echo $sidebar_for_layout,
					$this->Html->section($content_for_layout);
				else:
					echo $content_for_layout;
				endif;
			?>

		</div>
		<div id="footer">
			<?php echo $this->element('layout/footer'); ?>
		</div>
	</div>
	<?php
	// DEBUG FOOTER
	// displays custom data in a table useful for simple debugging -- html displays in overlay, can display yep nope type results on cakephp env vars
	// can be used with ajax responses update this element. (you can style it to not interfere with your app)
	if (Configure::read('Site.footerCustomVars')) {
		echo $this->Plate->debugVars();
	}

	echo $this->Plate->jsLib();
	
	$this->AssetCompress->script(array(
		'plugins',
		'script',
	));
	echo $this->AssetCompress->includeJs();
	
	echo $this->Plate->pngFix(array('img', '.png'));
	echo $this->Plate->profiling();
	echo $this->Plate->analytics();
?>
</body>
</html>