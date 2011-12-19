<?php $this->Html->css('cake.generic', null, array('inline' => false))?>
<iframe src="http://cakephp.org/bake-banner" width="830" height="160" style="overflow:hidden; border:none;">
	<p>For updates and important announcements, visit http://cakefest.org</p>
</iframe>
<h2>Sweet, "Baking Plate" got Baked by CakePHP!</h2>
<?php
App::uses('Debugger', 'Utility');
if (Configure::read() > 0):
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
	<li>Controller/AppController.php - base functions here to buidl upon flesh out</li>
	<li>Model/AppModel.php</li>
	<li>Lib/AppError.php</li>
	<li>Lib/AppException.php</li>
	<li>Config/bootstrap.php - CakePlugin::loadAll(); is called at bottom of this file</li>
	<li>View/Layouts/default.ctp</li>
	<li>View/Elements/layout - collection place for elements used in layouts to group them apaprt from plugin override elements</li>
	<li>webroot/css</li>
	<li>webroot/js</li>
	<li>
		<h4>Plugins</h4>
		<ul>
			<li>By default 3 plugins are added <?php echo $this->Html->link('DebugKit', 'http://github.com/cakephp/debug_kit/'); ?>, <?php echo $this->Html->link('Linkable', 'http://github.com/dereuromark/linkable/'); ?> &amp; <?php echo $this->Html->link('Batch', 'http://github.com/ProLoser/Cakephp-Batch/'); ?></li>
		        <li><code>cake BakingPlate.plate browse -h</code> browse Plugins indexed by BakingPlate</li>
			<li><code>cake BakingPlate.plate add -h</code> browse Plugins indexed by BakingPlate</li>
			<li><code>cake BakingPlate.plate search TERM</code> Search <?php echo $this->Html->link('cakepakackages.com', 'http://www.cakepakages.com/'); ?> for code<li>
		</ul>
		<h4>Themes</h4>
		<ul>
		        <li>Make a dir in View/Themed/MyName uncomment property in Controller/AppController</li>
			<li>A start Admin theme exists in View/Themed/Admin it is switched to by default if prefix is admin<li>

		</ul>
		<h4>Adding less (plugins for Cake Sass exist but you can of course compile using node to appropriate dir)</h4>
		<ul>
			<li>mkdir webroot/less</li>
			<li>a) <code>cake plate add lessphp -g vendors</code></li>
			<li>b) <code>cake plate add less -g hyra</code></li>
			<li>c) enable AssetCompress and make a less filter</li>

		</ul>
		<h4>Setup asset compression by running the following commands:</h4>
		<ul>
			<li><code>cake plate add jsmin</code></li>
			<li><code>cake plate add cssmin</code></li>
			<li><code>cake plate add asset_compress -g markstory</code> switch out comments to enable the plugin</li>
			<li><code>cake asset_compress build</code></li>
		</ul>
	</li>
	<li>
		<h5>This skel is Html5 based upon <?php echo $this->Html->link('Html5Boilerplate', 'http://html5boilerplate.com'); ?> by Paul Irish &amp; Divya Manian  (and many others); Paul &amp; Divya are working <?php echo $this->Html->link('Html5 Please', 'http://html5please.github.com'); ?></h5>
	</li>
</ul>
<p>Baking Plate is delete-key friendly. Just search the project for #!# to see different options you can enable.</p>
