<div id="logo">
	<?php echo $this->Html->link($this->Html->image('layout/logo2.png', array('style' => 'width:220px;height:40px')), '/', array('escape' => false))?>
</div>
<div id="search">
	<form action="dashboard.html" id="search_form" name="search_form" method="get">
		<input type="text" id="q" name="q" title="Search" class="search noshadow"/>
	</form>
</div>
<div id="account_info">
	<?php echo $this->Html->image('icon_online.png', array('alt' => 'Online', 'class' => 'mid_align'))?>
	Hello <?php echo $this->Html->link($this->Session->read('Auth.User.username'), array('staff' => false, 'controller' => 'users', 'action' => 'index'))?> | <?php echo $this->Html->link('Settings', array('staff' => false, 'controller' => 'users', 'action' => 'edit'))?> | <?php echo $this->Html->link('Logout', array('staff' => false, 'controller' => 'users', 'action' => 'logout'))?>
</div>