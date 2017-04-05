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
                        'dataProvider' => $model,                        
                        'columns' => array(                                                       
                            array(
                                'name' => 'rol_nombre',
                                'header'=>'Rol',                                
                            ),
                            array(
                                'name' => 'usuario_dni',
                                'header'=>'DNI',                                
                            ),
                            array(
                                'name' => 'usuario_nombre',
                                'header'=>'Nombre',                                
                            ),
                            array(
                                'name' => 'usuario_apellido',
                                'header'=>'Apellido',                                
                            ),
                            array(
                                'name' => 'last_update',
                                'header'=>'Última modificación',                                
                            ),
                            
                            
                            array(
                                'class' => 'bootstrap.widgets.TbButtonColumn',
                                'template' => '{edit}', // botones a mostrar
                                'buttons' => array(   
                                    'edit' => array
                                    (    
//                                            'url' => '$data->id."|".$data->nombre',              
                                            'icon' => 'icon-pencil',
                                            'label' => 'Editar rol'
//                                            'click' => 'function(){
//                                                    data=$(this).attr("href").split("|")
//                                                    $("#myModalHeader").html(data[1]);
//                                                            $("#myModalBody").load("'.$this->createUrl('view').'&id="+data[0]+"&asModal=true");
//                                                    $("#myModal").modal();
//                                                    return false;
//                                            }', 
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
        <h4 id="myModalHeader">Modal header</h4>
    </div>
 
    <div class="modal-body" id="myModalBody">
        <p>One fine body...</p>
    </div>
 
    <div class="modal-footer">
        <?php  $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'label' => 'Close',
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )
        ); ?>
    </div>
 
<?php  $this->endWidget(); ?>

