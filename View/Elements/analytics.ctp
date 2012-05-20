<?php if (strpos(strtoupper($code), 'UA-') === false) $code = 'UA-' . $code;  ?>
<script type="text/javascript">
    var _gaq = _gaq || [];
	_gaq.push(['_setAccount', '<?php echo $code; ?>']);
	<?php if (!empty($domain)): ?>
	_gaq.push(['_setDomainName', '<?php echo $domain; ?>']);
	<?php endif; ?>
	<?php if (!empty($linker) && $linker): ?>
	_gaq.push(['_setAllowLinker', true]);
	<?php endif; ?>
	_gaq.push(['_trackPageview']);
      (function(d, t) {
      var g = d.createElement(t),
          s = d.getElementsByTagName(t)[0];
      g.async = true;
      g.src = 'http://www.google-analytics.com/ga.js';
      s.parentNode.insertBefore(g, s);
    })(document, 'script');
</script>