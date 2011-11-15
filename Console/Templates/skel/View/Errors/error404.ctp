<article>

	<h1><?php echo __('File not Found');  ?> <span frown>:(</span></h1>

	<div>
		<p><?php if (isset($message)) echo $message; ?></p>
		<p>It looks like this was the result of either:</p>
		<ul>
			<li>a mistyped address</li>
			<li>an out-of-date link</li>
		</ul>
	</div>

	<script>
	var GOOG_FIXURL_LANG = (navigator.language || '').slice(0,2),
	GOOG_FIXURL_SITE = location.host;
	</script>
	<script src="http://linkhelp.clients.google.com/tbproxy/lh/wm/fixurl.js"></script>
</article>
