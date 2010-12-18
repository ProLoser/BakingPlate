
  <!--[if lt IE 7 ]>
    <script> 
      // More information on tackling transparent PNGs for IE goo.gl/mZiyb
      //fix any <img> or .png_bg background-images
      // todo: don't use getscript
      $.getScript("<?php echo $this->Html->url('/h5bp/js/libs/dd_belatedpng.js'); ?>",function(){ DD_belatedPNG.fix('<?php echo $classes ?>'); });
    </script>
  <![endif]-->