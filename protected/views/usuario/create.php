<?php
    Yii::app()->clientScript->registerScript(
       'myHideEffect',
       '$(".alert-success").animate({opacity: 1.0}, 3000).fadeOut("slow");',
       CClientScript::POS_READY
    );
?>
 
<?php
/* @var $this UsuarioController */
/* @var $model Usuario */

$this->breadcrumbs=array(
	'Nuevo Usuario',
);

$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');
$this->menu=array(
	array('label'=>'Opciones','url'=>array('index'),'icon'=>'glyphicon glyphicon-cog', 'items' => $menu)	
);
?>

<?php $box = $this->beginWidget(
    'booster.widgets.TbPanel',
    array(
        'title' => 'Usuarios' ,
        'headerIcon' => '',
        'headerButtons' => array(
        	array(
            	'class' => 'booster.widgets.TbButtonGroup',
            	'context' => 'success',
            	// '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            	'buttons' => $this->menu
            )
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
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php $this->endWidget(); ?>