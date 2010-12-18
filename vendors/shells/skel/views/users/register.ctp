<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php __('Register')?></legend>
	<?php
		echo $this->Form->hidden('locale_id', array('value' => $this->Session->read('Config.locale')));
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('confirm_password', array('type' => 'password'));
		if (isset($captcha)) {
			echo $this->Form->input('captcha');	
		}
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>