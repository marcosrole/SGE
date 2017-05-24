<?php
/* @var $this InscripcionmateriaController */
/* @var $model Inscripcionmateria */

$this->breadcrumbs=array(
	'Inscripcionmaterias'=>array('index'),
	'Manage',
);

$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');
$this->menu=array(
	array('label'=>'Inscribirme','url'=>array('create'),'icon'=>'fa fa-list-alt')	
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#inscripcionmateria-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $box = $this->beginWidget(
    'booster.widgets.TbPanel',
    array(
        'title' => 'Mis Inscripciones',
        'headerIcon' => 'icon- fa fa-tasks',
        'headerButtons' => array(
            array(
            	'class' => 'booster.widgets.TbButton',
                'label' => 'Inscribirme',
                'context' => 'success',
                'buttonType' => 'link',
                'icon' => 'icon- fa fa-tasks',
                'url' => $this->createUrl('inscripcionmateria/create'),
            )
        ) 
    )
);?>		<?php $this->widget('booster.widgets.TbAlert', array(
		    'fade'=>true, // use transitions?
		    'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
		    'alerts'=>array( // configurations per alert type
		        'success'=>array( 'fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
		        'info'=>array('fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
		        'warning'=>array('fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
		        'error'=>array('fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
		        'danger'=>array('fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
		    ),
		));
		?>


<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->


<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'inscripcionmateria-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'responsiveTable' => true,
	'type' => 'striped hover', //bordered condensed
	'columns'=>array(
		array('header'=>'No','value'=>'($this->grid->dataProvider->pagination->currentPage*
					 $this->grid->dataProvider->pagination->pageSize
					)+ ($row+1)',
				'htmlOptions' => array('style' =>'width: 25px; text-align:center;'),
		),
                    array(
		        'header' => 'Ticket',
		        'name'=> 'ticket',
		        'type'=>'raw',
		        'value' => '($data->ticket)',
                        'headerHtmlOptions' => array('style' => 'text-align:center;'),
		    ),
                    array(
		        'header' => 'DNI',
		        'name'=> 'usuario_dni',
		        'type'=>'raw',
		        'value' => '($data->usuario->dni)',
                        'headerHtmlOptions' => array('style' => 'text-align:center;'),
                        'visible' => Yii::app()->user->getState('rolUsuario') == "admin"
		    ),
                    array(
		        'header' => 'Appelido y Nombre',
		        'name'=> 'fullNombre',
		        'type'=>'raw',
		        'value' => '($data->getFullNombre())',
                        'headerHtmlOptions' => array('style' => 'text-align:center;'),
                        'visible' => Yii::app()->user->getState('rolUsuario') == "admin"
		    ),
			
			array(
		        'header' => 'Materia',
		        'name'=> 'materia_nombre',
		        'type'=>'raw',
		        'value' => '$data->materia->nombre',
                        'headerHtmlOptions' => array('style' => 'text-align:center;'),
		    ),
                    array(
		        'header' => 'Periodo',
		        'name'=> 'fullPeriodo',
		        'type'=>'raw',
		        'value' => '$data->getFullPeriodo()',
                        'headerHtmlOptions' => array('style' => 'text-align:center;'),
		    ),
                    array(
		        'header' => 'Fecha de Inscripcion',
		        'name'=> 'created',
		        'type'=>'raw',
		        'value' => 'date("d/m/Y   H:i",strtotime($data->created))',
                        
                        'headerHtmlOptions' => array('style' => 'text-align:center;'),
		    ),
					
		
                    array(
                        'class'=>'booster.widgets.TbButtonColumn',
                        'template' => '{view} {delete}', // botones a mostrar
                        'buttons'=>array(
                            'view' => array(    
                                    'url' => '$data->id."|".$data->id_usuario',              
                                    'click' => 'function(){
                                            data=$(this).attr("href").split("|")
                                            $("#myModalHeader").html(data[1]);
                                                    $("#myModalBody").load("'.$this->createUrl('view').'&id="+data[0]+"&asModal=true");
                                            $("#myModal").modal();
                                            return false;
                                    }', 
                            ),
                            'delete' => array(
                            'label' => 'Borrar',
                            'icon'=>'glyphicon glyphicon-trash',
                            'click' => 'function(){return confirm("¿Desea eliminar la Inscripción?");}',
                            'url'=> 'Yii::app()->createUrl("inscripcionmateria/delete", array("id"=> ' . '$data["id"])) ',
                        ),
                    )
                        ),
	),
)); ?>

<?php $this->endWidget(); ?>
<?php  $this->beginWidget(
    'booster.widgets.TbModal',
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
            'booster.widgets.TbButton',
            array(
                'label' => 'Close',
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )
        ); ?>
    </div>
 
<?php  $this->endWidget(); ?>
