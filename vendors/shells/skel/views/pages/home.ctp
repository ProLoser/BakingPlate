<h2>Sweet, "Baking Plate" got Baked by CakePHP!</h2>

<?php

$this->Plate->start('sidebar');
?>
<h3>What to do now</h3>
<div>
	<p>Your app is baked - various features can be enabled by reviewing the code generated and  (re)moving markers</p>
	<p>Just as Html5 Boilerplate is delete-key friendly so is BakingPlate - lines/blocks your not using can be removed</p>
</div>

<h4>Markers</h4>
<dl>
	<dt>A single line markers</dt>
	<dd><code>#delete-me#</code></dd>
	<dd><code>#move-me#</code></dd>
	<dt>A multi line marker</dt>
	<dd><code>[delete-me]</code></dd>
	
</dl>
</div><?php
$this->Plate->stop();


if (Configure::read() > 0):
	Debugger::checkSecurityKeys();
endif;
?>
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
