<?php
/**
 * Copyright 2005-2010, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2005-2010, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<?php include(dirname(dirname(__FILE__)) . DS .  'common_params.php'); ?>
<div class="<?php echo $pluralVar;?> index">
<h2><?php echo "<?php __('{$pluralHumanName}');?>";?></h2>
<p>
<?php echo "<?php
echo \$this->Paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?>";?>
</p>

<?php echo "<?php\n";?>
	echo $this->Form->create('<?php echo $modelClass;?>', array(
		'url' => array_merge(array('action' => 'find'), $this->params['pass'])
		));
	//echo $this->Form->input('title', array('div' => false));
	echo $this->Form->submit(__('Search', true), array('div' => false));
	echo $this->Form->end();
<?php echo '?>';?>

<table cellpadding="0" cellspacing="0">
<tr>
<?php  foreach ($fields as $field):?>
	<th><?php echo "<?php echo \$this->Paginator->sort('{$field}');?>";?></th>
<?php endforeach;?>
	<th class="actions"><?php echo "<?php __('Actions');?>";?></th>
</tr>
<?php
echo "<?php
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
				echo "\t\t<td>\n\t\t\t<?php echo \${$singularVar}['{$modelClass}']['{$field}']; ?>\n\t\t</td>\n";
			}
		}

		$idKeyPK = $idKey = "\${$singularVar}['{$modelClass}']['{$primaryKey}']";
		if ($slugged) {
			$idKey = "\${$singularVar}['{$modelClass}']['slug']";
		}
		
		echo "\t\t<td class=\"actions\">\n";
		echo "\t\t\t<?php echo \$this->Html->link(__('View', true), array('action' => 'view', {$idKey})); ?>\n";
	 	echo "\t\t\t<?php echo \$this->Html->link(__('Edit', true), array('action' => 'edit', {$idKeyPK})); ?>\n";
	 	echo "\t\t\t<?php echo \$this->Html->link(__('Delete', true), array('action' => 'delete', {$idKeyPK})); ?>\n";
		echo "\t\t</td>\n";
	echo "\t</tr>\n";

echo "<?php endforeach; ?>\n";
?>
</table>
<?php echo "<?php echo \$this->element('paging',array('plugin'=>'templates')); ?>\n";?>
</div>

<div class="actions">
	<ul>
		<li><?php echo "<?php echo \$this->Html->link(__('New {$singularHumanName}', true), array('action' => 'add'{$additionalParams})); ?>";?></li>
<?php
	$done = array();
	foreach ($associations as $type => $data) {
		foreach ($data as $alias => $details) {
			if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
				echo "\t\t<li><?php echo \$this->Html->link(__('List " . Inflector::humanize($details['controller']) . "', true), array('controller' => '{$details['controller']}', 'action' => 'index')); ?> </li>\n";
				echo "\t\t<li><?php echo \$this->Html->link(__('New " . Inflector::humanize(Inflector::underscore($alias)) . "', true), array('controller' => '{$details['controller']}', 'action' => 'add')); ?> </li>\n";
				$done[] = $details['controller'];
			}
		}
	}
?>
	</ul>
</div>
