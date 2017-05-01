<!DOCTYPE html>
<html lang="es">

<head>
   
</head>

<body>
    <?php $this->widget('booster.widgets.TbAlert', array(
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
            'info'=>array('fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
            'warning'=>array('fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
            'error'=>array('fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
            'danger'=>array('fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
        ),
    ));
    ?>
    
    <div class="container">
        <div class="row">
                <?php $form = $this->beginWidget(
                    'booster.widgets.TbActiveForm',
                    array(
                        'id' => 'verticalForm',
                //        'htmlOptions' => array('class' => 'well'), // for inset effect
                    )
                );
                 ?>

                 <?php if($flagConToken == false) { ?>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-md-offset-4 col-lg-offset-4">
                        <h4 class="text-info">Ingrese DNI y su correo electrónico</h4> 
                        <div class="col-lg-12">
                            <div class="col-lg-3">
                                <?php echo $form->textFieldGroup($model,'dni',array('class'=>'span2','maxlength'=>20)); ?>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="col-lg-3">
                                <?php echo $form->textFieldGroup($model,'email',array('class'=>'span3','value'=>'', 'maxlength'=>20)); ?>
                            </div>
                        </div>
                        
                        <div class="col-lg-12">
                            <div class="col-lg-3 text-right">
                                <?php $this->widget('booster.widgets.TbButton', array(
                                                'buttonType'=>'submit',
                                                'context'=>'primary',
                                                'label'=>'Enviar',
                                        )); ?>
                            </div>
                        </div>
                    </div>
            
                 <?php }else{ ?>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-md-offset-4 col-lg-offset-4">
                            <h4 class="text-info">Recupara contraseña</h4>                             
                            <div class="col-lg-12">
                                <div class="col-lg-3">
                                    <?php echo $form->labelEx($model,'Nueva contraseña'); ?>
                                    <?php echo $form->passwordFieldGroup($model,'passwordNew',array('labelOptions' => array("label" => false), 'class'=>'span2','maxlength'=>20)); ?>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="col-lg-3">
                                    <?php echo $form->passwordFieldGroup($model,'passwordAgain',array('class'=>'span2','maxlength'=>20)); ?>
                                </div>
                            </div>  
                            
                            <div class="col-lg-12">
                                <div class="col-lg-3 text-right">
                                     <?php $this->widget('booster.widgets.TbButton', array(
                                                    'buttonType'=>'submit',
                                                    'context'=>'primary',
                                                    'label'=>'Enviar',
                                            )); ?>
                                </div>
                            </div>
                            
                        </div>
                 <?php } ?>
                <?php $this->endWidget(); ?>
        </div>        
    </div>    
        
</body>

</html>
