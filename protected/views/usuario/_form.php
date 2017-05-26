
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

                         
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-lg-2">
                <?php echo $form->textFieldGroup($model,'dni',array('class'=>'span2','maxlength'=>20)); ?>            
            </div>
            <div class="col-lg-3">
                <?php echo $form->textFieldGroup($model,'apellido',array('class'=>'span3','maxlength'=>20)); ?>  
            </div>
            <div class="col-lg-3">
                 <?php echo $form->textFieldGroup($model,'nombre',array('class'=>'span3','maxlength'=>20)); ?>
            </div>
            <div class="col-lg-2">
                <?php echo $form->checkboxGroup($model,'isDocente',array('class'=>'span3','maxlength'=>20)); ?>
            </div>    
             <div class="col-lg-2">
                <div style="float: left">
                    <?php $this->widget('booster.widgets.TbButton', array(
                                            'buttonType'=>'submit',
                                            'context'=>'primary',
                                            'label'=>$model->isNewRecord ? 'Guardar' : 'Guardar',
                                    )); ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            
        </div>
        
       
                    
                
               
	


<?php $this->endWidget(); ?>
