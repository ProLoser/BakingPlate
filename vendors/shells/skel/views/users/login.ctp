<?php echo $this->Session->flash('auth')?>
<div class="users login">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php __('Login')?></legend>
	<?php
		echo $this->Form->input('username', array('tabindex' => 1, 'after' => 
			$this->Html->link(__('Need to Register?', true), array('controller' => 'users', 'action' => 'register'))
		));
		echo $this->Form->input('password', array('tabindex' => 2, 'after' => 
			$this->Html->link(__('Forgotton Password?', true), array('controller' => 'users', 'action' => 'reset')),			
		));
		if (isset($rememberMe) && $rememberMe) {
			echo $this->Form->input('remember_me', array('type' => 'checkbox'));
		}
	?>
	</fieldset>
<?php echo $this->Form->end(__('Login', true));?>
</div>