<article>

	<h1><?php __('File not Found');  ?> <span frown>:(</span></h1>

	<div>
		<p><?php if (isset($message)) echo "<p>", $message, "</p>"; ?></p>
		<p>It looks like this was the result of either:</p>
		<ul>
			<li>a mistyped address</li>
			<li>an out-of-date link</li>
		</ul>
	</div>


	<?php  /*  search box element could be placed here  */  ?>
	<p class="sitemap"><?php echo $this->Html->link('sitemap', array('plugin' => 'webmaster_tools', 'controller' => 'webmaster_tools', 'action' => 'sitemap')); ?></p>

	<script>
	var GOOG_FIXURL_LANG = (navigator.language || '').slice(0,2),
	GOOG_FIXURL_SITE = location.host;
	</script>
	<script src="http://linkhelp.clients.google.com/tbproxy/lh/wm/fixurl.js"></script>
</article>
