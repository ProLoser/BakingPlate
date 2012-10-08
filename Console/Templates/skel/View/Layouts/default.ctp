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
	    <?php echo $this->fetch('title'); ?>
	    
	</title>
	
	<meta name="description" content="<?php if (!empty($description_for_layout)) echo $description_for_layout; ?>">
	<meta name="author" content="CakePHP with Baking Plate">
	
	<meta name="viewport" content="width=device-width">
	
	<?php echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon')); ?> 
	<?php echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon', 'rel' => 'shortcut icon')); ?> 
	<?php echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon', 'rel' => 'apple-touch-icon')); ?> 

	<?php
	    echo $this->fetch('meta');
	    $this->Html->css(array('normalize', 'main'), null, array('inline' => false));
	    #!# $this->AssetCompress->css('main.css', array('inline' => false, 'block' => 'css'));
	    
	    echo $this->fetch('css');
	    #!# $this->AssetCompress->includeCss();
	    
	    $this->Html->script(array('plugins', 'main'), array('inline' => false));
	    #!# $this->AssetCompress->script('main', array('inline' => false));
	    
	    $this->Html->script('vendor/modernizr-2.6.2.min', array('type' => false, 'inline' => false, 'block' => 'headscript'));
	    #!# $this->AssetCompress->script('headscript', array('type' => false, 'inline' => false, 'block' => 'headscript'));
      
	    echo $this->fetch('headscript');
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

	    <?php echo $this->fetch('content'); ?>
	  </div>
	  <footer>
	    <?php echo $this->element('layout/footer'); ?>
	  </footer>
      </div>
<?php
      echo $this->Plate->lib('jquery', array('compressed' => true, 'version' => '1.7.1', 'fallback' => 'vendor/jquery-1.7.1.min.js'));
      echo $this->fetch('script');
	  #!# echo $this->AssetCompress->includeJs();
      
      echo $this->Plate->analytics();
      #!# echo $this->Plate->chrome();
?>

</body>
</html>