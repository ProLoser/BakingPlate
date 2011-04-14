<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('username');
		echo $this->Form->input('slug');
		echo $this->Form->input('passwd');
		echo $this->Form->input('password_token');
		echo $this->Form->input('email');
		echo $this->Form->input('email_authenticated');
		echo $this->Form->input('email_token');
		echo $this->Form->input('email_token_expires');
		echo $this->Form->input('tos');
		echo $this->Form->input('active');
		echo $this->Form->input('last_login');
		echo $this->Form->input('last_activity');
		echo $this->Form->input('is_admin');
		echo $this->Form->input('role');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Users', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Profiles', true), array('controller' => 'profiles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Profile', true), array('controller' => 'profiles', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Articles', true), array('controller' => 'articles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Article', true), array('controller' => 'articles', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Details', true), array('controller' => 'details', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Detail', true), array('controller' => 'details', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Favorites', true), array('controller' => 'favorites', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Favorite', true), array('controller' => 'favorites', 'action' => 'add')); ?> </li>
	</ul>
</div>