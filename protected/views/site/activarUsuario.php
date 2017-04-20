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
                'htmlOptions' => array('class' => 'well'), // for inset effect
            )
        );
         ?>
    
    <h3 class="text-info">Activación de usuario:</h3>
    
    <?php echo $form->errorSummary($model); ?>
    
                <div style="float:left;padding:10px">
                    <?php echo $form->labelEx($model,'password'); ?>
                    <?php echo $form->passwordField($model,'password',array('class'=>'span2','maxlength'=>20)); ?>
                </div>
                <div style="float:left;padding:10px">
                    <?php echo $form->labelEx($model,'passwordAgain'); ?>
                    <?php echo $form->passwordField($model,'passwordAgain',array('class'=>'span2','maxlength'=>20)); ?>
                </div>
                
            <div class="clearfix"></div>
                    
                <div style="float:left;padding:10px">
                    <?php echo $form->textFieldRow($model,'dni',array('class'=>'span2','maxlength'=>20,'readonly' => true)); ?>
                </div> 
                <div style="float:left;padding:10px">
                    <?php echo $form->textFieldRow($model,'apellido',array('class'=>'span3','maxlength'=>20,'readonly' => true)); ?>
                </div> 
                <div style="float:left;padding:10px">
                    <?php echo $form->textFieldRow($model,'nombre',array('class'=>'span3','maxlength'=>20,'readonly' => true)); ?>
                </div> 
                <div style="float:left;padding:10px">
                    <?php echo $form->labelEx($model,'sexo'); ?>
                    <?php echo $form->dropDownList($model, 'sexo', array('MASCULINO'=>'Masculino', 'FEMENINO'=>'Femenino', 'OTRO'=>'Otro'), array('class'=>'span2','empty'=>array(NULL=>'-- Seleccione --'))); ?>                   
                </div> 
                                
            <div class="clearfix"></div>
            
                
                <div style="float:left;padding:10px">
                    <?php echo $form->labelEx($model,'fecha_nacimiento'); ?>
                    <?php  $this->widget('CMaskedTextField', array(
                             'mask'=>'99/99/9999',
                             'model'=>$model,
                             'attribute'=>'fecha_nacimiento',
                             )); ?>
                </div>
                
                <div style="float:left;padding:10px">
                    <?php echo $form->textFieldRow($model,'domicilio',array('class'=>'span3','maxlength'=>20)); ?>
                </div> 
                <div style="float:left;padding:10px">
                    <?php echo $form->labelEx($model,'id_provincia'); ?>
                    <?php echo $form->dropDownList($model,'id_provincia', 
                            CHtml::listData(Provincia::model()->findAll(),'id','provincia'),
                           array(
                               'options' => array('22'=>array('selected'=>true)),
                               'class'=>'span2',
                                'ajax'=>array(
                                    'type'=>'POST',
                                    'url'=>CController::createUrl('Usuario/SelectLocalidad'),
                                    'update'=>'#' . CHtml::activeId($model, 'id_localidad')
                                ),  'prompt'=>'-- Seleccione Provincia --'
                            ));
                            ?>                    
                </div> 
                <div style="float:left;padding:10px">
                    <?php echo $form->labelEx($model,'id_localidad'); ?>
                    <?php echo $form->dropDownList($model,'id_localidad', CHtml::listData(Localidad::model()->findAll(),'id','localidad'),
                            array(
                                'options' => array('2177'=>array('selected'=>true)),
                                'class'=>'span2',
                                'empty'=>array(NULL=>'-- Seleccione Localidad --'))); ?>                    
                </div> 
                
            <div class="clearfix"></div>
            
                <div style="float:left;padding:10px">
                    <?php echo $form->labelEx($model,'id_carrera'); ?>
                    <?php echo $form->dropDownList($model,'id_carrera', CHtml::listData(Carrera::model()->findAll(),'id','fullname'),array('class'=>'span2','empty'=>array(NULL=>'-- Seleccione --'))); ?>                    
                </div> 
            
                <div style="float:left;padding:10px">
                    <?php echo $form->textFieldRow($model,'celular',array('class'=>'span2','maxlength'=>20)); ?>
                </div> 
            
                <div style="float:left;padding:10px">
                    <?php echo $form->textFieldRow($model,'email',array('class'=>'span3','maxlength'=>20,'readonly' => true)); ?>                    
                </div>
            
            <div class="clearfix"></div>
            
                
                 
                <div style="padding:10px">
                    <?php $this->widget('bootstrap.widgets.TbButton', array(
                                        'buttonType'=>'submit',
                                        'type'=>'primary',
                                        'label'=>'Activar',
                                )); ?>
                </div>
    
                <?php $this->endWidget(); ?>
            
    
</body>

</html>
