<?php
/* @var $this UsuarioRolController */
/* @var $model UsuarioRol */

$this->breadcrumbs=array(
	'Usuario Rols'=>array('index'),
	'Manage',
);

$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');
$this->menu=array(
	array('label'=>'UsuarioRol','url'=>array('index'),'icon'=>'fa fa-list-alt', 'items' => $menu)	
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
        'title' => 'Manage Usuario Rols',
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
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'usuario-rol-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'type' => 'striped hover', //bordered condensed
	'columns'=>array(
		array('header'=>'No','value'=>'($this->grid->dataProvider->pagination->currentPage*
					 $this->grid->dataProvider->pagination->pageSize
					)+ ($row+1)',
				'htmlOptions' => array('style' =>'width: 25px; text-align:center;'),
		),
			array(
		        'header' => 'Rol',
		        'name'=> 'id_rol',
		        'type'=>'raw',
		        'value' => '($data->id_rol)',		        
		    ),
			
			array(
		        'header' => 'Usuario',
		        'name'=> 'id_usuario',
		        'type'=>'raw',
		        'value' => '($data->id_usuario)',
		    ),
			
		//'created',
			array(
		        'header' => 'última modificación',
		        'name'=> 'last_update',
		        'type'=>'raw',
		        'value' => '($data->last_update)',
		    ),
			
		/*
		//Contoh
		array(
	        'header' => 'Level',
	        'name'=> 'ref_level_id',
	        'type'=>'raw',
	        'value' => '($data->Level->name)',
	        // 'value' => '($data->status)?"on":"off"',
	    ),
	    */
	    array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'buttons'=>array
            (
                'view' => array
                (    
                	'url' => '$data->id."|".$data->id_rol',              
                	'click' => 'function(){
                		data=$(this).attr("href").split("|")
                		$("#myModalHeader").html(data[1]);
	        			$("#myModalBody").load("'.$this->createUrl('view').'&id="+data[0]+"&asModal=true");
                		$("#myModal").modal();
                		return false;
                	}', 
                ),
            )
		),
	),
)); ?>

<?php echo CHtml::endForm(); ?>

<?php $this->endWidget(); ?>
