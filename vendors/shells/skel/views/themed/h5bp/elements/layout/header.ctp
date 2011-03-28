
<hgroup>
    <h1><?php echo isset($h1_for_layout)  ? $h1_for_layout : Configure::read('Site.Title'); ?></h1>
    <h2><?php echo isset($h2_for_layout)  ? $h2_for_layout : Configure::read('Site.subTitle'); ?></h2>
</hgroup>

<?php
    // prepare for navigation plugin use
        echo $this->Navigation->create('main', array());
?>