<div class="pages index">
<h2><?php __('Pages');?></h2>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('id');?></th>
	<th><?php echo $this->Paginator->sort('parent_id');?></th>
	<th><?php echo $this->Paginator->sort('url');?></th>
	<th><?php echo $this->Paginator->sort('title');?></th>
	<th><?php echo $this->Paginator->sort('draft');?></th>
	<th><?php echo $this->Paginator->sort('created');?></th>
	<th><?php echo $this->Paginator->sort('updated');?></th>
	<th><?php echo $this->Paginator->sort('user_id');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($pages as $page):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $this->Html->link($page['ParentPage']['title'], array('controller' => 'pages', 'action' => 'view', $page['ParentPage']['id'])); ?>
		</td>
		<td>
			<?php echo $page['Page']['url']; ?>
		</td>
		<td>
			<?php echo $page['Page']['title']; ?>
		</td>
		<td>
			<?php echo $page['Page']['draft']; ?>
		</td>
		<td>
			<?php echo $page['Page']['created']; ?>
		</td>
		<td>
			<?php echo $page['Page']['updated']; ?>
		</td>
		<td>
			<?php echo $this->Html->link($page['User']['id'], array('controller' => 'users', 'action' => 'view', $page['User']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $page['Page']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $page['Page']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $page['Page']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
<?php echo $this->element('paging',array('plugin'=>'templates')); ?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('New Page', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Pages', true), array('controller' => 'pages', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Root Page', true), array('controller' => 'pages', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
