<?php $this->Html->css('cake.generic', null, array('inline' => false))?>
<h2>Sweet, "Baking Plate" got Baked by CakePHP!</h2>
<?php
if (Configure::read() > 0):
	Debugger::checkSecurityKeys();
endif;
?>

<div class="url-rewrite">
	<p class="notice success" style="color: white"><?php __('URL rewriting is working properly.')?></p>
	<p style="color:red"><?php __('URL rewriting isn\'t working properly.')?></p>
	<ol>
		<li><a target="_blank" href="http://book.cakephp.org/view/917/Apache-and-mod_rewrite-and-htaccess"><?php __('Help me configure it')?></a></li>
		<li><a target="_blank" href="http://book.cakephp.org/view/931/CakePHP-Core-Configuration-Variables"><?php __('I don\'t / can\'t use URL rewriting')?></a></li>
	</ol>
</div>

<p>
<?php
	if (is_writable(TMP)):
		echo '<span class="notice success">';
			__('Your tmp directory is writable.');
		echo '</span>';
	else:
		echo '<span class="notice">';
			__('Your tmp directory is NOT writable.');
		echo '</span>';
	endif;
?>
</p>
<p>
<?php
	$settings = Cache::settings();
	if (!empty($settings)):
		echo '<span class="notice success">';
				printf(__('The %s is being used for caching. To change the config edit APP/config/core.php ', true), '<em>'. $settings['engine'] . 'Engine</em>');
		echo '</span>';
	else:
		echo '<span class="notice">';
				__('Your cache is NOT working. Please check the settings in APP/config/core.php');
		echo '</span>';
	endif;
?>
</p>
<p>
<?php
	$filePresent = null;
	if (file_exists(CONFIGS . 'database.php')):
		echo '<span class="notice success">';
			__('Your database configuration file is present.');
			$filePresent = true;
		echo '</span>';
	else:
		echo '<span class="notice">';
			__('Your database configuration file is NOT present.');
			echo '<br/>';
			__('Rename config/database.php.default to config/database.php');
		echo '</span>';
	endif;
?>
</p>
<?php
if (!empty($filePresent)):
	if (!class_exists('ConnectionManager')) {
		require LIBS . 'model' . DS . 'connection_manager.php';
	}
	$db = ConnectionManager::getInstance();
 	$connected = $db->getDataSource('default');
?>
<p>
<?php
	if ($connected->isConnected()):
		echo '<span class="notice success">';
 			__('Cake is able to connect to the database.');
		echo '</span>';
	else:
		echo '<span class="notice">';
			__('Cake is NOT able to connect to the database.');
		echo '</span>';
	endif;
?>
</p>
<?php endif;?>
<h3><?php __('Editing this Page') ?></h3>
<p>
<?php
	printf(__('To change the content of this page, edit: %s
		To change its layout, edit: %s
		You can also add some CSS styles for your pages at: %s', true),
		APP . 'views' . DS . 'pages' . DS . 'home.ctp.<br />',  APP . 'views' . DS . 'layouts' . DS . 'default.ctp.<br />', APP . 'webroot' . DS . 'css');
?>
</p>

<h3>What to do now</h3>
<p>Now that you're app has been generated, here are a few areas you should checkout to see some 'best practices' examples.</p>
<ul>
	<li>The BakingPlate Plugin! Read the documentation on the assorted helpers/components/views</li>
	<li>app_controller.php</li>
	<li>app_model.php</li>
	<li>app_error.php</li>
	<li>bootstrap.php</li>
	<li>views/layouts/default.ctp</li>
	<li>views/elements</li>
	<li>webroot/css</li>
	<li>webroot/js</li>
	<li>Setup asset compression by running the following commands:
		<ul>
			<li><code>cake plate add jsmin</code></li>
			<li><code>cake plate add cssmin</code></li>
			<li><code>cake asset_compress build</code></li>
		</ul>
	</li>
</ul>
<p>Baking Plate is delete-key friendly. Just search the project for #!# to see different options you can enable.</p>