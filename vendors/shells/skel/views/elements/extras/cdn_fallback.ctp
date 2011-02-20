<?php
    // set lib if not set - could do same for min overkill? -this means you can switch to mootools, prototype etc
    $lib = (!isset($lib)) ? 'jquery' : $lib;
?>  <script src="//ajax.googleapis.com/ajax/libs/<?php echo $lib; ?>/<?php echo $version; ?>/jquery.min.js"></script>
  <script>!window.jQuery && document.write(unescape('%3Cscript src="<?php echo $this->Html->url('libs/'.$lib.'-'.$version.'.min.js'); ?>"%3E%3C/script%3E'))</script>
