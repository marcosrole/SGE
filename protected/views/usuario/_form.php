
<?php 

$form = $this->beginWidget(
    'booster.widgets.TbActiveForm',
    array(
        'id' => 'verticalForm',
//        'htmlOptions' => array('class' => 'well'), // for inset effect
    )
);
 ?>

	<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

                         
                <div style="float:left;padding:10px">
                    <?php echo $form->textFieldGroup($model,'dni',array('class'=>'span2','maxlength'=>20)); ?>
                </div> 
                <div style="float:left;padding:10px">
                    <?php echo $form->textFieldGroup($model,'apellido',array('class'=>'span3','maxlength'=>20)); ?>
                </div>                 
                <div style="float:left;padding:10px">
                     <?php echo $form->textFieldGroup($model,'nombre',array('class'=>'span3','maxlength'=>20)); ?>
                </div>
                <div style="float:left;padding-top: 30px">
                    <?php $this->widget('booster.widgets.TbButton', array(
                                        'buttonType'=>'submit',
                                        'context'=>'primary',
                                        'label'=>$model->isNewRecord ? 'Guardar' : 'Guardar',
                                )); ?>
                </div>
	


<?php $this->endWidget(); ?>
