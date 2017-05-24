<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'inscripcionmateria-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	// 'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

<div class="content">
    <div class="row">
        <div class="col-lg-4">
            <strong>Mesa de Examen: </strong> <?php echo $mesaExamen{'periodo'}; ?> - Año: <?php echo $mesaExamen{'anio'}; ?>
        </div>
        <div class="col-lg-4">
            <strong>Cantidad de Turnos: </strong> <?php echo $mesaExamen{'cantTurnos'}; ?>
        </div>
    </div>    
    <div class="row">
        <div class="col-lg-4">
            <strong>Inicio de Inscripcion</strong> <?php echo date("d/M/Y",strtotime($mesaExamen{'fechaInicio'})) ; ?>
        </div>
        <div class="col-lg-4">
            <strong>Finalización de Inscripción</strong> <?php echo date("d/M/Y",strtotime($mesaExamen{'fechaFin'})) ; ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-12">
            <strong>Carrera: </strong> <?php echo $carrera{'plan'} . " - " . $carrera{'nombre'}; ?>
        </div>
    </div>
    
    <div class="col-md-12">
       <?php $this->widget('booster.widgets.TbGridView',array(
            'id'=>'inscripcionmateria-grid',
            'dataProvider'=>$materias->search(),
            'filter'=>$materias,
            'type' => 'striped hover', //bordered condensed
            'columns'=>array(                    
                    array(
                    'header' => 'Año',
                    'name'=> 'anio',
                    'type'=>'raw',
                    'value' => '($data->anio) . "º año"',
                    'htmlOptions'=>array('width'=>'100px'),    
                     ),
                     array(
                    'header' => 'Materia',
                    'name'=> 'nombre',
                    'type'=>'raw',
                    'value' => 'CHtml::link("$data->nombre","view/id/".CHtml::encode($data->id))',
                     ),

            ),
    )); ?> 
                
    </div>


<?php $this->endWidget(); ?>
