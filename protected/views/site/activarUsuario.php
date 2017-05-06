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
     
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?php $form = $this->beginWidget(
            'booster.widgets.TbActiveForm',
            array(
                'id' => 'verticalForm',
//                'htmlOptions' => array('class' => 'well'), // for inset effect
            )
        );
         ?>
    
    <h3 class="text-info">Activación de usuario:</h3>
    <h3 class="text-info">DNI: <?php echo $model{'dni'}?> - <?php echo $model{'apellido'}?>, <?php echo $model{'nombre'}?> </h3>
    <h4 class="text-info"><?php echo $model{'email'}?></h4>
    <?php echo $form->errorSummary($model); ?>
    
    
    <div class="panel panel-default">
        <div class="panel-heading">Nueva Contraseña</div>
        <div class="panel-body">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col-lg-6">
                    <?php echo $form->passwordFieldGroup($model,'password',array('maxlength'=>20)); ?>
                </div>
                <div class="col-lg-6">
                    <?php echo $form->passwordFieldGroup($model,'passwordAgain',array('maxlength'=>20)); ?> 
                </div>                  
            </div>                    
        </div>
    </div>
                
    <div class="panel panel-default">
        <div class="panel-heading">Datos personales</div>
        <div class="panel-body">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col-lg-4">
                    <?php echo $form->datePickerGroup($model,'fecha_nacimiento',
                           array(
                                  'widgetOptions' => array(
                                           'options' => array(
                                                   'language' => Yii::app()->language,
                                                   'format'=>'dd/mm/yyyy'
                                           ),

                                   ),                      
                                   'hint' => ' ',
                                   'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
                           )
                   ); ?>
                </div>
                <div class="col-lg-4">
                    <?php echo $form->dropDownListGroup($model,	'sexo',
                        array(
                                'empty'=>'Seleccione sexo',
                                'wrapperHtmlOptions' => array(
                                ),
                                'widgetOptions' => array(
                                        'data' => array('MASCULINO'=>'Masculino', 'FEMENINO'=>'Femenino', 'OTRO'=>'Otro'),
                                        'htmlOptions' => array(                                            
                                        ),
                                    ),
                                )
                        );
                     ?>
                </div>
                <div class="col-lg-4">
                    <?php echo $form->textFieldGroup($model,'celular',array('maxlength'=>20)); ?>
                </div>
            </div>
            
            <div class="col-lg-12">
                <div class="col-lg-4">
                    <?php echo $form->textFieldGroup($model,'domicilio',array('class'=>'span3','maxlength'=>20)); ?>
                </div>
                <div class="col-lg-4">
                    <?php echo $form->dropDownListGroup($model,	'id_provincia',
                                array(
                                        'empty'=>'Seleccione una provincia',
                                        'wrapperHtmlOptions' => array(
                                                'class' => 'col-sm-5',
                                        ),
                                        'widgetOptions' => array(
                                                'data' => CHtml::listData(Provincia::model()->findAll(),'id','provincia'),
                                                'htmlOptions' => array(
                                                    'options' => array('22'=>array('selected'=>true)),
                                                    'ajax'=>array(
                                                    'type'=>'POST',
                                                    'url'=>CController::createUrl('Usuario/SelectLocalidad'),
                                                    'update'=>'#' . CHtml::activeId($model, 'id_localidad')
                                                ),
                                            ),
                                        )
                                )
                            ); ?>    
                </div>
                <div class="col-lg-4">
                     <?php echo $form->dropDownListGroup($model,	'id_localidad',
                                array(
                                        'empty'=>'Seleccione una localidad',
                                        'wrapperHtmlOptions' => array(
                                                'class' => 'col-sm-5',
                                        ),
                                        'widgetOptions' => array(
                                                'data' => CHtml::listData(Localidad::model()->findAll(),'id','localidad'),
                                                'htmlOptions' => array(
                                                    'options' => array('2177'=>array('selected'=>true)),                                            
                                                ),
                                            ),
                                        )
                                );
                             ?>   
                </div>
            </div>   
        </div>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-heading">Datos académicos</div>
        <div class="panel-body">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col-lg-12">
                    <?php echo $form->dropDownListGroup($model,	'id_carrera',
                        array(
                                'empty'=>'Seleccione una carrera',
                                'wrapperHtmlOptions' => array(
                                        'class' => 'col-sm-5',
                                ),
                                'widgetOptions' => array(
                                        'data' => CHtml::listData(Carrera::model()->findAll(),'id','fullname'),
                                        'htmlOptions' => array(                                            
                                        ),
                                    ),
                                )
                        );
                     ?>        
                </div>                    
            </div>              
        </div>
    </div>
    
               
                 
    <div style="float:right;padding:10px">
        <?php $this->widget('booster.widgets.TbButton', array(
                            'buttonType'=>'submit',
                            'context'=>'primary',
                            'label'=>'Activar',
                    )); ?>
    </div>
    
    <?php $this->endWidget(); ?>
</div>
    
            
    
</body>

</html>
