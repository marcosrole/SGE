<!DOCTYPE html>
<html lang="es">

<head>
   
</head>

<body>
    <?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>false, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
            'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
            'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
            'danger'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
        ),
    ));
    ?>
    
    
    <?php 

        $form = $this->beginWidget(
                    'bootstrap.widgets.TbActiveForm',
                    array(
                        'id' => 'verticalForm',
                //        'htmlOptions' => array('class' => 'well'), // for inset effect
                    )
                );
                 ?>

            <h4 class="text-info">Ingrese DNI y su correo electrónico</h4>

            <?php echo $form->errorSummary($model); ?>
    
                <div style="float:left;padding:10px">
                    <?php echo $form->textFieldRow($model,'dni',array('class'=>'span2','maxlength'=>20)); ?>
                </div>           
                <?php if($usuarioExistente){ ?>
                    <div style="float:left;padding:10px">
                        <?php echo $form->textFieldRow($model,'email',array('class'=>'span3','maxlength'=>20,'readonly' => true)); ?>
                    </div> 
                <?php }else{ ?>
                    <div style="float:left;padding:10px">
                        <?php echo $form->textFieldRow($model,'email',array('class'=>'span3','maxlength'=>20)); ?>
                    </div>
                <?php } ?>
                
                <br>
                <div style="padding:10px">
                    <?php $this->widget('bootstrap.widgets.TbButton', array(
                                        'buttonType'=>'submit',
                                        'type'=>'primary',
                                        'label'=>'Enviar',
                                )); ?>
                </div>
    
                <?php $this->endWidget(); ?>
    
</body>

</html>
