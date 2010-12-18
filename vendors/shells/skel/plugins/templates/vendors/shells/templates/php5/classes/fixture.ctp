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

/**
 * Fixture Template file
 *
 * Fixture Template used when baking fixtures with bake
 *
 */
?>
<?php echo '<?php' . "\n"; ?>
/* <?php echo $model; ?> Fixture generated on: <?php echo  date('Y-m-d H:m:s') . " : ". time(); ?> */
class <?php echo $model; ?>Fixture extends CakeTestFixture {
/**
 * Name
 *
 * @var string $name
 * @access public
 */
	public $name = '<?php echo $model; ?>';

<?php if ($table): ?>
/**
 * Table
 *
 * @var string $table
 * @access public
 */
	public $table = '<?php echo $table; ?>';

<?php endif; ?>
<?php if ($import): ?>
/**
 * Import table name
 *
 * @var string $import
 * @access public
 */
	public $import = <?php echo $import; ?>;

<?php endif; ?>

<?php if ($schema): ?>
/**
 * Fields
 *
 * @var array $fields
 * @access public
 */
	public $fields = <?php echo $schema; ?>;

<?php endif;?>

<?php if ($records): ?>
/**
 * Records
 *
 * @var array $records
 * @access public
 */
	public $records = <?php echo $records; ?>;

<?php endif;?>
}
<?php echo '?>'; ?>