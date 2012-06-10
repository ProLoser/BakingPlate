<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.console.libs.templates.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
$plugins = App::objects('plugin');

if (!function_exists('clean')) {
  	function clean($field) {
		return !in_array($field, array('lft', 'rght'));
	}
}

$fields = array_filter($fields, 'clean');
?>
<header>
	<hgroup>
		<h1><?php echo "<?php echo __('{$pluralHumanName}');?>";?></h1>
	</hgroup>
	<ul class="actions">
		<li><?php echo "<?php echo \$this->Html->link(__('New " . $singularHumanName . "'), array('action' => 'add')); ?>";?></li>
	<?php
	$done = array();
	foreach ($associations as $type => $data) {
		foreach ($data as $alias => $details) {
			if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
				echo "\t\t<li><?php echo \$this->Html->link(__('List " . Inflector::humanize($details['controller']) . "'), array('controller' => '{$details['controller']}', 'action' => 'index')); ?> </li>\n";
				echo "\t\t<li><?php echo \$this->Html->link(__('New " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'add')); ?> </li>\n";
				$done[] = $details['controller'];
			}
		}
	}
	?>
	</ul>
</header>
<article class="<?php echo $pluralVar;?> index">
	<header>
		<h3>
		<?php echo "<?php
		echo \$this->Paginator->counter(array(
		'format' => __('Showing %start% to %end% out of %count% total')
		));
		?>";?>
		</h3>
		<ul class="paging">
			<?php echo "<?php echo \$this->Paginator->prev('&laquo; ' . __('previous'), array('escape' => false, 'tag' => 'li'), null, array('escape' => false, 'tag' => 'li', 'class'=>'disabled'));?>\n";?>
			<?php echo "<?php echo \$this->Paginator->numbers(array('separator' => false, 'tag' => 'li'));?>"?>
			<?php echo "<?php echo \$this->Paginator->next(__('next') . ' &raquo;', array('escape' => false, 'tag' => 'li'), null, array('escape' => false, 'tag' => 'li', 'class' => 'disabled'));?>\n";?>
		</ul>
	</header>
	<?php if (in_array('Batch', $plugins)) echo "<?php echo \$this->Batch->create('{$modelClass}')?>"?>
	<table cellpadding="0" cellspacing="0">
	<tr>
	<?php  foreach ($fields as $field):?>
		<th><?php echo "<?php echo \$this->Paginator->sort('{$field}');?>";?></th>
	<?php endforeach;?>
		<th class="actions"><?php echo "<?php echo __('Actions');?>";?></th>
	</tr>
	<?php
	echo "<?php";
	if (in_array('Batch', $plugins)) {
		$filterFields = "'" . implode("',\n\t\t\t'", $fields) . "'";
		$filterFields = str_replace("_id'", "_id' => array('empty' => '-- None --')", $filterFields);
		$filterFields = str_replace(array("'id'", "'created'", "'modified'", "'lft'", "'rght'"), 'null', $filterFields);
		echo "
		echo \$this->Batch->filter(array(
			{$filterFields}
		));";
	}
	echo "
	\$i = 0;
	foreach (\${$pluralVar} as \${$singularVar}):
		\$class = null;
		if (\$i++ % 2 == 0) {
			\$class = ' class=\"altrow\"';
		}
	?>\n";
	echo "\t<tr<?php echo \$class;?>>\n";
		foreach ($fields as $field) {
			$isKey = false;
			if (!empty($associations['belongsTo'])) {
				foreach ($associations['belongsTo'] as $alias => $details) {
					if ($field === $details['foreignKey']) {
						$isKey = true;
						echo "\t\t<td>\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t</td>\n";
						break;
					}
				}
			}
			if ($isKey !== true) {
				if ($schema[$field]['type'] === 'datetime') {
					echo "\t\t<td><?php if (!empty(\${$singularVar}['{$modelClass}']['{$field}'])) echo \$this->Time->niceShort(\${$singularVar}['{$modelClass}']['{$field}']); ?>&nbsp;</td>\n";
				} elseif($schema[$field]['type'] === 'date') {
					echo "\t\t<td><?php if (!empty(\${$singularVar}['{$modelClass}']['{$field}'])) echo \$this->Time->timeAgoInWords(\${$singularVar}['{$modelClass}']['{$field}']); ?>&nbsp;</td>\n";
				} elseif($schema[$field]['type'] === 'boolean') {
					echo "\t\t<td><?php echo (\${$singularVar}['{$modelClass}']['{$field}']) ? __('Yes') : __('No'); ?>&nbsp;</td>\n";
				} else {
					echo "\t\t<td><?php echo \${$singularVar}['{$modelClass}']['{$field}']; ?>&nbsp;</td>\n";
				}
			}
		}

		echo "\t\t<td class=\"actions\">\n";
		echo "\t\t\t<?php echo \$this->Html->link(__('View'), array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'view')); ?>\n";
	 	echo "\t\t\t<?php echo \$this->Html->link(__('Edit'), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'edit')); ?>\n";
	 	echo "\t\t\t<?php echo \$this->Html->link(__('Delete'), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'delete'), sprintf(__('Are you sure you want to delete # %s?'), \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
		if (in_array('Batch', $plugins))
		 	echo "\t\t\t<?php echo \$this->Batch->checkbox(\${$singularVar}['{$modelClass}']['{$primaryKey}']); ?>\n";
		echo "\t\t</td>\n";
	echo "\t</tr>\n";

	echo "\t<?php endforeach;";
	if (in_array('Batch', $plugins))
		echo "\n\t\techo \$this->Batch->batch(array(
			{$filterFields}
		));";
	echo "?>";
	?>
	</table>
	<?php if (in_array('Batch', $plugins)) echo "<?php echo \$this->Batch->end()?>"?>
	<footer>
		<h3>Records:</h3>
		<p class="limit">
			<?php echo "<?php echo \$this->Paginator->limit(array(10,20,50,100));?>\n"?>
		</p>
		<ul class="paging">
			<?php echo "<?php echo \$this->Paginator->prev('&laquo; ' . __('previous'), array('escape' => false, 'tag' => 'li'), null, array('escape' => false, 'tag' => 'li', 'class'=>'disabled'));?>\n";?>
			<?php echo "<?php echo \$this->Paginator->numbers(array('separator' => false, 'tag' => 'li'));?>"?>
			<?php echo "<?php echo \$this->Paginator->next(__('next') . ' &raquo;', array('escape' => false, 'tag' => 'li'), null, array('escape' => false, 'tag' => 'li', 'class' => 'disabled'));?>\n";?>
		</ul>
	</footer>
</article>
