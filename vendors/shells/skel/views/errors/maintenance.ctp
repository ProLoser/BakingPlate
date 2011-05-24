<?php
  $this->set('title_for_layout', __('Down for a while', true));
  // set a different layout for maintenace
  $this->layout = 'maintenance';
?>
<article>
  <h1><?php __('Maintenance in progress'); ?></h1>
  <?php echo $message; ?>
</article>
