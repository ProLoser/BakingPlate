<?php if (strpos(strtoupper($code), 'UA-') === false) $code = 'UA-' . $code;  ?>
<script>
	var _gaq=[['_setAccount','<?php echo $code; ?>'],['_trackPageview'],['_trackPageLoadTime']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
</script>
