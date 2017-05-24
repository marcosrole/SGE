<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

			<?php echo $form->textFieldRow($model,'cantTurnos',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'fechaInicio',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'fechaFin',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'periodo',array('class'=>'span5','maxlength'=>30)); ?>

		<?php echo $form->textFieldRow($model,'anio',array('class'=>'span5')); ?>

			<?php echo $form->textFieldRow($model,'last_update',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
