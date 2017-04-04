<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';

?>

<?php $this->widget('bootstrap.widgets.TbAlert', array(
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

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'login',	
	'enableAjaxValidation'=>false,
	
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

        <div>
            <?php echo $form->textFieldRow($model,'username',array('class'=>'span2','maxlength'=>20),  array('label'=>'Usuario')); ?>
            <?php echo $form->textFieldRow($model,'password',array('class'=>'span2','maxlength'=>20), array('label'=>'Contraseña')); ?>
        </div>                   
        
        <div>
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                                'buttonType'=>'submit',
                                'type'=>'primary',
                                'label'=>'Iniciar',
                        )); ?>
        </div>
            


            
        
<?php $this->endWidget(); ?>
