<script>
    $('#buttonStateful').click(function() {
    var btn = $(this);
    alert("asas");
    btn.button('loading'); // call the loading function
    setTimeout(function() {
        btn.button('reset'); // call the reset function
    }, 3000);
});
</script>

<?php
/* @var $this InscripcionmateriaController */
/* @var $model Inscripcionmateria */

$this->breadcrumbs=array(
	'Inscripcion a Mesa de Examen'=>array('create'),
        'Confirmación de Inscripcion',
	
);

$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');


$menu2=array(
	array('label'=>'Mis Inscripciones','url'=>array('index'),'icon'=>'fa fa-list-alt'),
);

?>

<?php $box = $this->beginWidget(
    'booster.widgets.TbPanel',
    array(
        'title' => 'Confirmación de Inscripción',
        'headerIcon' => 'icon- fa fa-eye',
        'headerButtons' => array(
            array(
                'class' => 'booster.widgets.TbButtonGroup',
                'context' => 'primary',
                // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'buttons' => $menu2
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
<?php $this->widget('booster.widgets.TbDetailView',array(
	'data'=>$materia,
	'attributes'=>array(
                 array(
                    'name'=> 'Carrera',
                    'type'=>'raw',
                    'value' => Carrera::model()->findByPk($materia->id_carrera)->nombre,
                    ),
                array(
                    'name'=> 'Materia',
                    'type'=>'raw',
                    'value' => "(" . $materia->anio . "º año) " . $materia->nombre,
                    ),
		

	    
	),
)); ?>
<div class="row text-center">
<?php 
    $this->widget(
    'booster.widgets.TbButton',
    array(
        'label' => 'Rechazar',
        'context' => 'danger',
        'buttonType' => 'link',
        'size' => 'small',
        'icon' => 'glyphicon glyphicon-remove',
        'url' => $this->createUrl('inscripcionmateria/create'),
        'htmlOptions' => array(
		'name'=>'ActionButton',
		'confirm' => '¿Desea rechazar la Inscripción?',
	),
            
    )
); echo ' ';
?>    
    

<?php 
    $this->widget(
    'booster.widgets.TbButton',
    array(
        'label' => 'Confirmar',
        'context' => 'success',
        'buttonType' => 'link',
        'size' => 'small',
        'icon' => 'ok',
        'url' => $this->createUrl('inscripcionmateria/ConfirmarInscripcion') . '/idMateria/' . $materia{'id'},
            
    )
); echo ' ';
?>
</div>

<?php
$this->endWidget();
?>