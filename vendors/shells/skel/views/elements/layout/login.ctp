<div class="users form">
		<?php
			$model = Configure::read('App.UserClass');
			echo $this->Form->create($model, array('url' => array('action' =>  'login')));
			echo $this->Form->input('email', array('label' => __d('users', 'Email', true)));
			echo $this->Form->input('passwd',  array('label' => __d('users', 'Password', true)));
			echo $this->Form->input('AppUser.remember_me', array('type' => 'checkbox', 'label' => __d('users', 'Remember Me', true)));
			echo $this->Form->hidden('AppUser.return_to', array('value' => (isset($return_to) ? $return_to : '/')));
			echo $this->Form->end(__d('users', 'Submit', true));
		?>
</div>