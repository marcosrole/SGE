<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

			<?php echo $form->textFieldGroup($model,'id_usuario',array('class'=>'span5')); ?>

		<?php echo $form->textFieldGroup($model,'id_materia',array('class'=>'span5')); ?>

			<?php echo $form->textFieldGroup($model,'last_update',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'submit',
			'context'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
