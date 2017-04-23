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
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'Usuarios',
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
      $this->widget('bootstrap.widgets.TbButton', array(
              'buttonType'=>'submit', 'icon'=>'print','label'=>'', 'type'=> 'default'));
      ?>
</div>
<?php $this->widget('bootstrap.widgets.TbGridView',array(
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
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'headerHtmlOptions' => array('style' => 'text-align:center'),
                            'editable' => array(
                                    'type'    => 'textarea',
                                    'url'     => $this->createUrl('editable'),
                                    'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
                            )
		    ),
		array(
                'header' => 'Nombre',
                'name'=> 'nombre',
                'type'=>'raw',
                'value' => '($data->nombre)',
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'headerHtmlOptions' => array('style' => 'text-align:center'),
                            'editable' => array(
                                    'type'    => 'textarea',
                                    'url'     => $this->createUrl('editable'),
                                    'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
                            )
		    ),
            
                array(
                'header' => 'DNI',
                'name'=> 'dni',
                'type'=>'raw',
                'value' => '($data->dni)',
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'headerHtmlOptions' => array('style' => 'width: 100px; text-align:center'),
                            'editable' => array(
                                    'type'    => 'textarea',
                                    'url'     => $this->createUrl('editable'),
                                    'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
                            )
		    ),
			
                array(
                'header' => 'Email',
                'name'=> 'email',
                'type'=>'raw',
                'value'=>'$data->email=="null@null.com" ? "Esperando habiltación" : $data->email',     
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'headerHtmlOptions' => array(
                            'style' => 'text-align:center'),
                            'editable' => array(
                                    'type'    => 'textarea',
                                    'url'     => $this->createUrl('editable'),
                                    'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
                            )
		    ),
			
                array(
                'header' => 'Estado',
                'name'=> 'estado',
                'type'=>'raw',                
                'value' => '($data->estado)',
		    ),				

//                array(
//                'header' => 'Último acceso ',
//                'name'=> 'last_login',
//                'type'=>'raw',                    
//                'value' => '($data->last_login=="") ? "" : Yii::app()->dateFormatter->format("dd/MM/yyyy HH:mm:ss",strtotime($data->last_login))',
//                ),		
	    array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                   // 'htmlOptions' => array('width' => '10'), //ancho de la columna
                    'template' => '{view} {bloquear} {desbloquear}', // botones a mostrar
                    'buttons' => array(                        
                       'bloquear' => array(
                            'label' => 'Bloquear',
                            'visible'=> '($data->estado=="DESHABILITADO" || $data->estado=="ACTIVO") ? true : false',     
                            'icon'=>'icon-lock',
                             'click' => 'function(){return confirm("¿Desea Bloquear el usuario?");}',
//                            'click' => 'function(){return confirm("Desea bloquear el usuario?");}',
                            'url'=> 'Yii::app()->createUrl("usuario/bloquear", array("id"=> ' . '$data["id"])) ',
                        ),
                        'desbloquear' => array(
                            'label' => 'Desbloquear',
                            'icon'=>'icon-ok',
                            'click' => 'function(){return confirm("Desea Desbloquear el usuario?");}',
                            'visible'=> '($data->estado=="BLOQUEADO") ? true : false',     
//                            'click' => 'function(){return confirm("Desea bloquear el usuario?");}',
                            'url'=> 'Yii::app()->createUrl("usuario/bloquear", array("id"=> ' . '$data["id"])) ',
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
                'label' => 'Cerrar',
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )
        ); ?>
    </div>
 
<?php  $this->endWidget(); ?>
