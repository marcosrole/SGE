<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'mesa-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	// 'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model,'cantTurnos',array('class'=>'span5')); ?>
<?php echo $form->textFieldRow($model,'fechaInicio',array('class'=>'span5')); ?>
<?php echo $form->textFieldRow($model,'fechaFin',array('class'=>'span5')); ?>
<?php echo $form->textFieldRow($model,'periodo',array('class'=>'span5','maxlength'=>30)); ?>
<?php echo $form->textFieldRow($model,'anio',array('class'=>'span5')); ?>
<?php echo $form->textFieldRow($model,'last_update',array('class'=>'span5')); ?>


<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
