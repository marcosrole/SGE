<?php
/* @var $this UsuarioRolController */
/* @var $model UsuarioRol */

$this->breadcrumbs=array(
	'Usuarios'=>array('index'),
	$model->id,
);

$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');


$menu2=array(
	array('label'=>'Usuario','url'=>array('index'),'icon'=>'fa fa-list-alt', 'items' => $menu)	
);

if(!isset($_GET['asModal'])){
?>
<?php $box = $this->beginWidget(
    'booster.widgets.TbPanel',
    array(
        'title' => 'View Usuarios #'.$model->id,
        'headerIcon' => 'icon- fa fa-eye',
        'headerButtons' => array(
            array(
                'class' => 'booster.widgets.TbButtonGroup',
                'type' => 'success',
                // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'buttons' => $menu2
            ),
        ) 
    )
);?>
<?php
}
?>
		
<?php $this->widget('booster.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
            array(
                        
                        'name'=> 'Rol Actual',
                        'type'=>'raw',
                        'value' => $model->rol_nombre,
		    ),
            array(
                        'name'=> 'Apellido',
                        'type'=>'raw',
                        'value' => $model->usuario_apellido,
		    ),
            array(
                        'name'=> 'Nombre',
                        'type'=>'raw',
                        'value' => $model->usuario_nombre,
		    ),
            array(
                        'name'=> 'Email',
                        'type'=>'raw',
                        'value' => $model->usuario_email,
		    ),            			
		
	),
)); ?>

            <?php /** @var TbActiveForm $form */
            $form = $this->beginWidget(
                    'booster.widgets.TbActiveForm',
                    array(
                            'id' => 'horizontalForm',
                            'type' => 'horizontal',
                    )
            ); ?>

                        <?php echo $form->radioButtonListRow(
                            $model,
                            'isAdmin',
                            array(
                                'Administrador',
                                'Alumno',
                            )
                        ); ?>

                <div style="float:right; margin-left: 5px">
                    <?php $this->widget('booster.widgets.TbButton', array(
                                        'buttonType'=>'submit',
                                        'type'=>'success',
                                        'label'=>'Guardar',
                                )); ?>
                </div>
                <div style="float:right">
                    <?php $this->widget('booster.widgets.TbButton', array(
                                        'type'=>'default',
                                        'label'=>'Cerrar',
                                        'url' => '#',
                                        'htmlOptions' => array('data-dismiss' => 'modal'),
                                )); ?>
                </div>

            <?php 
                $this->endWidget();
                ?>


<?php
if(!isset($_GET['asModal'])){
	$this->endWidget();}
?>