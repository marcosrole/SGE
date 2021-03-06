<?php
/* @var $this MesaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Mesas',
);

$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');
$this->menu=array(
	array('label'=>'Mesa','url'=>array('index'),'icon'=>'fa fa-list-alt', 'items' => $menu)	
);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('mesa-grid', {
			data: $(this).serialize()
		});
		return false;
	});
");

Yii::app()->clientScript->registerScript('refreshGridView', "
	// automatically refresh grid on 5 seconds
	//setInterval(\"$.fn.yiiGridView.update('mesa-grid')\",5000);
");

?>

<?php $box = $this->beginWidget(
    'booster.widgets.TbPanel',
    array(
        'title' => 'List Mesas' ,
        'headerIcon' => 'icon- fa fa-list-ol',
        'headerButtons' => array(
            array(
                'class' => 'booster.widgets.TbButtonGroup',
                'type' => 'success',
                // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'buttons' => $this->menu
            ),
        ) 
    )
);?>
<?php /** $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); **/ ?>
		<?php $this->widget('booster.widgets.TbAlert', array(
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
		?><p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
		&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php echo CHtml::beginForm(array('export')); ?>
<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'mesa-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'type' => 'striped hover', //bordered condensed
	'columns'=>array(
		array('header'=>'No','value'=>'($this->grid->dataProvider->pagination->currentPage*
					 $this->grid->dataProvider->pagination->pageSize
					)+
					array_search($data,$this->grid->dataProvider->getData())+1',
				'htmlOptions' => array('style' =>'width: 25px; text-align:center;'),
		),
		array(
	        'name'=> 'cantTurnos',
	        'value' => '($data->cantTurnos)',
	        'headerHtmlOptions' => array('style' => 'text-align:center;'),
	    ),
		
		array(
	        'name'=> 'fechaInicio',
	        'value' => '($data->fechaInicio)',
	        'headerHtmlOptions' => array('style' => 'text-align:center;'),
	    ),
		
		array(
	        'name'=> 'fechaFin',
	        'value' => '($data->fechaFin)',
	        'headerHtmlOptions' => array('style' => 'text-align:center;'),
	    ),
		
		array(
	        'name'=> 'periodo',
	        'value' => '($data->periodo)',
	        'headerHtmlOptions' => array('style' => 'text-align:center;'),
	    ),
		
		array(
	        'name'=> 'anio',
	        'value' => '($data->anio)',
	        'headerHtmlOptions' => array('style' => 'text-align:center;'),
	    ),
		
		//'created',
		array(
	        'name'=> 'last_update',
	        'value' => '($data->last_update)',
	        'headerHtmlOptions' => array('style' => 'text-align:center;'),
	    ),
		

		/*
		//Contoh
		array(
	        'header' => 'Level',
	        'name'=> 'ref_level_id',
	        'type'=>'raw',
	        'value' => '($data->Level->name)',
	        // 'value' => '($data->status)?"on":"off"',
	        // 'value' => '@Admin::model()->findByPk($data->createdBy)->username',
	    ),
	    */
		array(
			'class'=>'booster.widgets.TbButtonColumn',
			'template'=>'{view}',
			'buttons'=>array
            (
                'view' => array
                (    
                	'url' => '$data->id."|".$data->cantTurnos',              
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

<select name="fileType" style="width:150px;">
	<option value="Excel5">EXCEL 5 (xls)</option>
	<option value="Excel2007">EXCEL 2007 (xlsx)</option>
	<option value="HTML">HTML</option>
	<option value="PDF">PDF</option>
	<option value="WORD">WORD (docx)</option>
</select>
<br>

<?php 
$this->widget('booster.widgets.TbButton', array(
	'buttonType'=>'submit', 'icon'=>'fa fa-print','label'=>'Export', 'type'=> 'primary'));
?>
<?php echo CHtml::endForm(); ?>
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
