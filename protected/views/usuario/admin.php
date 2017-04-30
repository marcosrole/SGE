<?php
    Yii::app()->clientScript->registerScript(
       'myHideEffect',
       '$(".alert-success").animate({opacity: 1.0}, 2000).fadeOut("slow");',
       CClientScript::POS_READY
    );
?>
<style>
    .usuario_bloqueado{
        color: red;
    } 
    .usuario_deshabilitado{
        color: orange;
    } 
</style>
<?php
/* @var $this UsuarioController */
/* @var $model Usuario */

$this->breadcrumbs=array(
	'Usuarios',
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
        'title' => 'Usuarios',
        'headerIcon' => 'icon- fa fa-tasks',
        'headerButtons' => array(
            array(
                'class' => 'booster.widgets.TbButtonGroup',
                'context' => 'success',
                // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'buttons' => $this->menu
            ),
        ) 
    )
);?>		<?php $this->widget('booster.widgets.TbAlert', array(
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



<?php echo CHtml::beginForm(array('export')); ?>
 <div style="float:left;padding:12px">
    <select name="fileType" style="width:150px;">
            <option value="Excel5">EXCEL 5 (xls)</option>
            <option value="Excel2007">EXCEL 2007 (xlsx)</option>
            <option value="HTML">HTML</option>
            <option value="PDF">PDF</option>
            <option value="WORD">WORD (docx)</option>
    </select>
</div>
<div style="float:left;padding-top:15px">
  <?php 
      $this->widget('booster.widgets.TbButton', array(
              'buttonType'=>'submit', 'icon'=>'print','label'=>'', 'context'=> 'default'));
      ?>
</div>

<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'usuario-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'type' => 'striped hover', //bordered condensed
        'rowCssClassExpression' => '($data->estado == "DESHABILITADO") ? "usuario_deshabilitado" : (($data->estado == "BLOQUEADO") ? "usuario_bloqueado" : "") ',
	'columns'=>array(
		array('header'=>'No','value'=>'($this->grid->dataProvider->pagination->currentPage*
					 $this->grid->dataProvider->pagination->pageSize
					)+ ($row+1)',
				'htmlOptions' => array('style' =>'width: 25px; text-align:center;'),
		),
                
			
                array(
                'header' => 'Apellido',
                'name'=> 'apellido',
                'type'=>'raw',
                'value' => '($data->apellido)',
                    ),
            
		array(
                'header' => 'Nombre',
                'name'=> 'nombre',
                'type'=>'raw',
                'value' => '($data->nombre)',
		    ),
            
                array(
                'header' => 'DNI',
                'name'=> 'dni',
                'type'=>'raw',
                'value' => '($data->dni)',                
		    ),
			
                array(
                'header' => 'Email',
                'name'=> 'email',
                'type'=>'raw',
                'value'=>'$data->email=="null@null.com" ? "Esperando habiltación" : $data->email',                   
		    ),
			
                array(
                'header' => 'Estado',
                'name'=> 'estado',
                'type'=>'raw',                
                'value' => '($data->estado)',
		    ),				
		
	    array(
                'class' => 'booster.widgets.TbButtonColumn',
                    'template' => '{editar} {bloquear} {desbloquear}', // botones a mostrar
                    'buttons' => array(                        
                       'bloquear' => array(
                            'label' => 'Bloquear',
                            'visible'=> '($data->estado=="DESHABILITADO" || $data->estado=="ACTIVO") ? true : false',     
                            'icon'=>'glyphicon glyphicon-remove',
                             'click' => 'function(){return confirm("¿Desea Bloquear el usuario?");}',
                            'url'=> 'Yii::app()->createUrl("usuario/bloquear", array("id"=> ' . '$data["id"])) ',
                        ),
                        'desbloquear' => array(
                            'label' => 'Desbloquear',
                            'icon'=>'glyphicon glyphicon-ok',
                            'click' => 'function(){return confirm("Desea Desbloquear el usuario?");}',
                            'visible'=> '($data->estado=="BLOQUEADO") ? true : false',     
                            'url'=> 'Yii::app()->createUrl("usuario/bloquear", array("id"=> ' . '$data["id"])) ',
                        ),
                        'editar' => array(
                            'label' => 'Editar',
                            'icon'=>'glyphicon glyphicon-pencil',    
                            'url'=> 'Yii::app()->createUrl("usuario/update", array("id"=> ' . '$data["id"])) ',
                        ),
                        
                        'view' => array
                        (    
                                'url' => '$data->id."|".$data->nombre',              
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
                'label' => 'Cerrar',
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )
        ); ?>
    </div>
 
<?php  $this->endWidget(); ?>
