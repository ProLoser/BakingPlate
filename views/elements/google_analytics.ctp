<?php 
if (substr($code, 0, 3) != 'UA-')
	$code = 'UA-' . $code;
if (!Configure::read('debug')):?>
<script type="text/javascript">
   var _gaq = [['_setAccount', '<?php echo $code; ?>'], ['_trackPageview']];
   (function(d, t) {
    var g = d.createElement(t),
        s = d.getElementsByTagName(t)[0];
    g.async = true;
    g.src = ('https:' == location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g, s);
   })(document, 'script');
</script>
<?php endif;?>