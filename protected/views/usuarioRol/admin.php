<?php
/* @var $this UsuarioRolController */
/* @var $model UsuarioRol */

$this->breadcrumbs=array(
	'Administracion de Roles',
);

$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');
$this->menu=array(
	array('label'=>'Opciones','url'=>array('index'),'icon'=>'fa fa-list-alt', 'items' => $menu)	
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#usuario-rol-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'Roles de usuarios',
        'headerIcon' => 'icon- fa fa-tasks',
        'headerButtons' => array(
            array(
                'class' => 'bootstrap.widgets.TbButtonGroup',
                'type' => 'success',
                // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'buttons' => $this->menu
            ),
        ) 
    )
);?>		<?php $this->widget('bootstrap.widgets.TbAlert', array(
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



<?php echo CHtml::beginForm(array('export')); ?>
<?php               
                    $this->widget('bootstrap.widgets.TbGridView', array(
                        'id' => 'sucursal-grid',
                        'dataProvider'=>$model->search(), 
                        'columns' => array(                                                       
                            array(
                                'name' => 'rol_nombre',
                                'value'=>'$data->rol->nombre',
                                'header'=>'Rol',                                
                            ),
                            array(
                                'name' => 'usuario_dni',
                                'value'=>'$data->usuario->dni',
                                'header'=>'DNI',                                
                            ),
                            array(
                                'name' => 'usuario_apellido',
                                'value'=>'$data->usuario->apellido',
                                'header'=>'Apellido',                                
                            ),
                            array(
                                'name' => 'usuario_nombre',
                                'value'=>'$data->usuario->nombre',
                                'header'=>'Nombre',                                
                            ),
                            array(
                                'name' => 'usuario_email',
                                'value'=>'$data->usuario->email',
                                'header'=>'E-mail',                                
                            ),                            
                                                       
                            
                            array(
                                'class' => 'bootstrap.widgets.TbButtonColumn',
                                'template' => '{edit}', // botones a mostrar
                                'buttons' => array(   
                                    'edit' => array
                                    (    
                                            'url' => '$data->id',              
                                            'icon' => 'icon-pencil',
                                            'label' => 'Editar rol',
                                            'click' => 'function(){
                                                    data=$(this).attr("href").split("|")
                                                    $("#myModalHeader").html(data[1]);
                                                            $("#myModalBody").load("'.$this->createUrl('view').'?id="+data[0]+"&asModal=true");
                                                    $("#myModal").modal();
                                                    return false;
                                            }', 
                                    ),                                                                                          
                                ),
                                ),
                            
                        ),

                    ));
                ?>

<?php echo CHtml::endForm(); ?>

<?php $this->endWidget(); ?>

<?php  $this->beginWidget(
    'bootstrap.widgets.TbModal',
    array('id' => 'myModal')
); ?>
 
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4 id="myModalHeader">Modificar Rol</h4>
    </div>
 
    <div class="modal-body" id="myModalBody">
        
        <?php 
            $form = $this->beginWidget(
                'bootstrap.widgets.TbActiveForm',
                array(
                    'id' => 'verticalForm',
                )
            );
             ?>
         <?php echo $form->errorSummary($model); ?>                         
                <div style="float:left;padding:10px">
                    <?php echo $form->textFieldRow($model,'usuario_dni',array('class'=>'span2','maxlength'=>20, 'value'=>'custom value')); ?>
                </div> 
                <div style="float:left;padding:10px">
                    <?php echo $form->textFieldRow($model,'usuario_apellido',array('class'=>'span3','maxlength'=>20, 'value'=>'custom value')); ?>
                </div>    
        <?php $this->endWidget(); ?>
    </div>
 
    <div class="modal-footer">
        
    </div>
 
<?php  $this->endWidget(); ?>

