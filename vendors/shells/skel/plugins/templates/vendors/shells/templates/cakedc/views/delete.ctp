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
<?php echo "<h2><?php echo sprintf(__('Delete {$singularHumanName} \"%s\"?', true), \${$singularVar}['{$modelClass}']['title']); ?></h2>\n";?>
<p>	
<?php echo "\t<?php __('Be aware that your {$singularHumanName} and all associated data will be deleted if you confirm!'); ?>\n";?>
</p>
<?php echo "<?php\n";?>
	echo $this->Form->create('<?php echo $modelClass;?>', array(
		'url' => array(
			'action' => 'delete',
			$<?php echo $singularVar;?>['<?php echo $modelClass;?>']['id'])));
	echo $form->input('confirm', array(
		'label' => __('Confirm', true),
		'type' => 'checkbox',
		'error' => __('You have to confirm.', true)));
	echo $form->submit(__('Continue', true));
	echo $form->end();
<?php echo "?>";?>
