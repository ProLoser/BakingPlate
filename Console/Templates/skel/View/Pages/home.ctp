<?php $this->Html->css('cake.generic', null, array('inline' => false))?>
<iframe src="http://cakephp.org/bake-banner" width="830" height="160" style="overflow:hidden; border:none;">
	<p>For updates and important announcements, visit http://cakefest.org</p>
</iframe>
<h2>Sweet, "Baking Plate" got Baked by CakePHP!</h2>
<?php
App::uses('Debugger', 'Utility');
if (Configure::read('debug') > 0):
	Debugger::checkSecurityKeys();
endif;
?>
<p>
<?php
	if (version_compare(PHP_VERSION, '5.2.6', '>=')):
		echo '<span class="notice success">';
			echo __d('cake_dev', 'Your version of PHP is 5.2.6 or higher.');
		echo '</span>';
	else:
		echo '<span class="notice">';
			echo __d('cake_dev', 'Your version of PHP is too low. You need PHP 5.2.6 or higher to use CakePHP.');
		echo '</span>';
	endif;
?>
</p>
<p>
<?php
	if (is_writable(TMP)):
		echo '<span class="notice success">';
			echo __d('cake_dev', 'Your tmp directory is writable.');
		echo '</span>';
	else:
		echo '<span class="notice">';
			echo __d('cake_dev', 'Your tmp directory is NOT writable.');
		echo '</span>';
	endif;
?>
</p>
<p>
<?php
	$settings = Cache::settings();
	if (!empty($settings)):
		echo '<span class="notice success">';
				echo __d('cake_dev', 'The %s is being used for caching. To change the config edit APP/Config/core.php ', '<em>'. $settings['engine'] . 'Engine</em>');
		echo '</span>';
	else:
		echo '<span class="notice">';
			echo __d('cake_dev', 'Your cache is NOT working. Please check the settings in APP/Config/core.php');
		echo '</span>';
	endif;
?>
</p>
<p>
<?php
	$filePresent = null;
	if (file_exists(APP . 'Config' . DS . 'database.php')):
		echo '<span class="notice success">';
			echo __d('cake_dev', 'Your database configuration file is present.');
			$filePresent = true;
		echo '</span>';
	else:
		echo '<span class="notice">';
			echo __d('cake_dev', 'Your database configuration file is NOT present.');
			echo '<br/>';
			echo __d('cake_dev', 'Rename APP/Config/database.php.default to APP/Config/database.php');
		echo '</span>';
	endif;
?>
</p>
<?php
if (isset($filePresent)):
	App::uses('ConnectionManager', 'Model');
	try {
		$connected = ConnectionManager::getDataSource('default');
	} catch (Exception $e) {
		$connected = false;
	}
?>
<p>
	<?php
		if ($connected && $connected->isConnected()):
			echo '<span class="notice success">';
	 			echo __d('cake_dev', 'Cake is able to connect to the database.');
			echo '</span>';
		else:
			echo '<span class="notice">';
				echo __d('cake_dev', 'Cake is NOT able to connect to the database.');
			echo '</span>';
		endif;
	?>
</p>
<?php endif;?>
<?php
	App::uses('Validation', 'Utility');
	if (!Validation::alphaNumeric('cakephp')) {
		echo '<p><span class="notice">';
		__d('cake_dev', 'PCRE has not been compiled with Unicode support.');
		echo '<br/>';
		__d('cake_dev', 'Recompile PCRE with Unicode support by adding <code>--enable-unicode-properties</code> when configuring');
		echo '</span></p>';
	}
?>
<h3><?php echo __d('cake_dev', 'Editing this Page'); ?></h3>
<p>
<?php
	echo __d('cake_dev', 'To change the content of this page, edit: %s
		To change its layout, edit: %s
		You can also add some CSS styles for your pages at: %s',
		APP . 'View' . DS . 'Pages' . DS . 'home.ctp.<br />',  APP . 'View' . DS . 'Layouts' . DS . 'default.ctp.<br />', APP . 'webroot' . DS . 'css');
?>
</p>

<h3>What to do now</h3>
<p>Now that you're app has been generated, here are a few areas you should checkout to see some 'best practices' examples.</p>
<ul>
	<li>The BakingPlate Plugin! Read the documentation on the assorted helpers/components/views</li>
	<li>Controller/AppController.php</li>
	<li>Model/AppModel.php</li>
	<li>Lib/AppError.php</li>
	<li>Lib/AppException.php</li>
	<li>Config/bootstrap.php</li>
	<li>View/Layouts/default.ctp</li>
	<li>views/elements</li>
	<li>webroot/css</li>
	<li>webroot/js</li>
	<li>webroot/less</li>
	<li>Setup asset compression by running the following commands:
		<ul>
			<li><code>cake plate add jsmin</code></li>
			<li><code>cake plate add cssmin</code></li>
			<li><code>cake asset_compress build</code></li>
		</ul>
	</li>
</ul>
<p>Baking Plate is delete-key friendly. Just search the project for #!# to see different options you can enable.</p>