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
echo $this->Html->start(array('docType' => 'html4-trans'));
?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Plate->chromeFrame();
		
		echo $this->Html->meta('icon');
		//echo $this->Plate->siteIcons();
		//echo $this->Html->meta('author', '');

		echo $this->Plate->css();
		echo $this->Html->css('cake.generic');
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
	if(Configure::read('Site.footerCustomVars')) {
		echo $this->Plate->debugVars();
	}
	// only displays during debug - prevents sql log in debug kit
	if(Configure::read('Site.footerSqlDump')) {
		echo $this->element('sql_dump');
	}

	echo $this->Plate->jsLib();
	
	$this->AssetCompress->script(array('plugins','script'));
	echo $this->AssetCompress->includeJs();
	
	// footer extras google analytics and yahoo_profiling
	 echo $this->Plate->pngFix(array('img', '.png'));
	
	 echo $this->Plate->profiling();
	
	 echo $this->Plate->analytics();
  
?>
</body>
</html>