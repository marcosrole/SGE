<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

			<?php echo $form->textFieldRow($model,'nombre',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'apellido',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'dni',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'estado',array('class'=>'span5','maxlength'=>13)); ?>

		<?php echo $form->textFieldRow($model,'hased_paswword',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'last_login',array('class'=>'span5')); ?>

			<?php echo $form->textFieldRow($model,'last_update',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
