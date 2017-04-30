<?php
    Yii::app()->clientScript->registerScript(
       'myHideEffect',
       '$(".alert-success").animate({opacity: 1.0}, 2000).fadeOut("slow");',
       CClientScript::POS_READY
    );
?>
<?php
$this->breadcrumbs=array(
	'Usuarios'=>array('admin'),
        'Editar usuario',
	
);

$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');
$this->menu=array(
	array('label'=>'Opciones','url'=>array('index'),'icon'=>'fa fa-list-alt', 'items' => $menu)	
);
?>

<?php $box = $this->beginWidget(
    'booster.widgets.TbPanel',
    array(
        'title' => 'DNI: '.$model->dni,
        'headerIcon' => 'glyphicon glyphicon-pencil',
        'headerButtons' => array(
            array(
                'class' => 'booster.widgets.TbButtonGroup',
                'context' => 'success',
                // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'buttons' => $this->menu
            ),
        ) 
    )
);?>
		
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


    <!-- Formulario -->
    
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?php $form = $this->beginWidget(
            'booster.widgets.TbActiveForm',
            array(
                'id' => 'verticalForm',
//                'htmlOptions' => array('class' => 'well'), // for inset effect
            )
        );
         ?>    
    
    <?php echo $form->errorSummary($model); ?>   
    
                
    <div class="panel panel-default">
        <div class="panel-heading">Datos personales</div>
        <div class="panel-body">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col-lg-4">
                    <?php echo $form->textFieldGroup($model,'dni',array('maxlength'=>20)); ?>
                </div>
                <div class="col-lg-4">
                    <?php echo $form->textFieldGroup($model,'apellido',array('maxlength'=>20)); ?>
                </div>
                <div class="col-lg-4">
                    <?php echo $form->textFieldGroup($model,'nombre',array('maxlength'=>20)); ?>
                </div>
            </div>
            
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
                <div class="col-lg-2">
                    <?php echo $form->dropDownListGroup($model,	'sexo',
                        array(
                                'empty'=>'Seleccione sexo',
                                'wrapperHtmlOptions' => array(
                                ),
                                'widgetOptions' => array(
                                        'data' => array('Masculino'=>'Masculino', 'Femenino'=>'Femenino', 'Otro'=>'Otro'),
                                        'htmlOptions' => array(                                            
                                        ),
                                    ),
                                )
                        );
                     ?>
                </div>
                <div class="col-lg-3">
                    <?php echo $form->textFieldGroup($model,'email',array('maxlength'=>50)); ?>
                </div>
                <div class="col-lg-3">
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
                            'label'=>'Actualizar',
                    )); ?>
    </div>
    <div style="float:right;padding:10px">
        <?php $this->widget('booster.widgets.TbButton', array(
                            'url' => '',
                            'context'=>'default',
                            'label'=>'Cancelar',
                    )); ?>
    </div>
    
    <?php $this->endWidget(); ?>
</div>

<?php $this->endWidget(); ?> <!--TbPanel--!>