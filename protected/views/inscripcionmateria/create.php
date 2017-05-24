<?php
/* @var $this InscripcionmateriaController */
/* @var $model Inscripcionmateria */

$this->breadcrumbs=array(
	'Inscripcion a Mesa de Examen',
);

$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');
$this->menu=array(
	array('label'=>'Mis Inscripciones','url'=>array('index'),'icon'=>'fa fa-list-alt'),	
);
?>

<?php $box = $this->beginWidget(
    'booster.widgets.TbPanel',
    array(
        'title' => 'Inscripción a Mesa de Examen' ,
        'headerIcon' => '',
        
        'headerButtons' => array(
        	array(
            	'class' => 'booster.widgets.TbButton',
                'label' => 'Mis Inscripciones',
                'context' => 'primary',
                'buttonType' => 'link',
                'icon' => 'icon- fa fa-tasks',
                'url' => $this->createUrl('inscripcionmateria/admin'),
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
		        'warning'=>array( 'fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
		        'error'=>array('fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
		        'danger'=>array('fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
		    ),
		));
		?>		

<?php echo $this->renderPartial('_form', array(
    'mesaExamen'=>$mesaExamen,
    'carrera' => $carrera,
    'materias' => $materias,
    )); ?>

<?php $this->endWidget(); ?>