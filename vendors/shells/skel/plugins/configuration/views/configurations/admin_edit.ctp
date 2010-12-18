<h1>Edit Configuration</h1>
<div class="configurations form">
<?php echo $form->create('Configuration');?>
	<fieldset>
	<?php
		echo $form->input('id');
		echo $form->input('name');
		echo $form->input('value');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Configuration.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Configuration.id'))); ?></li>
		<li><?php echo $html->link(__('List Configurations', true), array('action'=>'index'));?></li>
	</ul>
</div>