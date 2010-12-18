<h1>Add Configuration</h1>
<div class="configurations form">
<?php echo $form->create('Configuration');?>
	<fieldset>
	<?php
		echo $form->input('name');
		echo $form->input('value');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>