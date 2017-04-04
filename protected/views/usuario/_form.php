
<?php 

$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id' => 'verticalForm',
//        'htmlOptions' => array('class' => 'well'), // for inset effect
    )
);
 ?>

	<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

                         
                <div style="float:left;padding:10px">
                    <?php echo $form->textFieldRow($model,'dni',array('class'=>'span2','maxlength'=>20)); ?>
                </div> 
                <div style="float:left;padding:10px">
                    <?php echo $form->textFieldRow($model,'apellido',array('class'=>'span3','maxlength'=>20)); ?>
                </div>                 
                <div style="float:left;padding:10px">
                     <?php echo $form->textFieldRow($model,'nombre',array('class'=>'span3','maxlength'=>20)); ?>
                </div>
                <div style="float:left;padding:10px">
                     <?php echo $form->labelEx($model, 'Administrador'); ?>
                     <?php echo $form->checkbox($model, 'esAdmin'); ?>
                </div>
        


<div style="float:right;padding:10px">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Guardar' : 'Guardar',
		)); ?>
</div>
	


<?php $this->endWidget(); ?>
