<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php echo "<?php \$form=\$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl(\$this->route),
	'method'=>'get',
)); ?>\n"; ?>

<?php foreach ($this->tableSchema->columns as $column): ?>
	<?php
	$field = $this->generateInputField($this->modelClass, $column);
	if (strpos($field, 'password') !== false) {
		continue;
	}

	if (in_array($column->name, 
		array('id','created','createdBy','modified','modifiedBy', 'deleted', 'deletedBy'))) 
		continue;
	?>
	<?php echo "<?php echo " . $this->generateActiveRow($this->modelClass, $column) . "; ?>\n"; ?>

<?php endforeach; ?>
	<div class="form-actions">
		<?php echo "<?php \$this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>\n"; ?>
	</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>