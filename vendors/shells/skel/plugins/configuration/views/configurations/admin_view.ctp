<div class="configurations view">
<h1><?php  __('Configuration');?></h1>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $configuration['Configuration']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $configuration['Configuration']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Value'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $configuration['Configuration']['value']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Configuration', true), array('action'=>'edit', $configuration['Configuration']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Configuration', true), array('action'=>'delete', $configuration['Configuration']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $configuration['Configuration']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Configurations', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Configuration', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
