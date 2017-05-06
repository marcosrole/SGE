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
        <?php $form = $this->beginWidget(
                    'booster.widgets.TbActiveForm',
                    array(
                        'id' => 'verticalForm',
                //        'htmlOptions' => array('class' => 'well'), // for inset effect
                    )
                );
                 ?>

            <h4 class="text-info">Ingrese DNI y su correo electrónico</h4>

            <?php echo $form->errorSummary($model); ?>
    
                <div style="float:left;padding:10px">
                    <?php echo $form->textFieldGroup($model,'dni',array('class'=>'span2','maxlength'=>20)); ?>
                </div>   
                <div style="float:left;padding:10px">
                    <?php echo $form->textFieldGroup($model,'email',array('class'=>'span3','maxlength'=>20)); ?>
                </div>                
                
                <br>
                <div style="padding:10px">
                    <?php $this->widget('booster.widgets.TbButton', array(
                                        'buttonType'=>'submit',
                                        'context'=>'primary',
                                        'label'=>'Enviar',
                                )); ?>
                </div>
    
                <?php $this->endWidget(); ?>
    </div>    
        
</body>

</html>
