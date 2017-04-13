
<?php


/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */



$this->pageTitle=Yii::app()->name . ' - Login';

?>
<body class="margin-top-0">
	<div class="generic-container">
		
		<div class="container">
			<div class="row text-center"">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<H2 style="font-size: 28px; margin: 15px;">Ingreso al sistema</H2>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-md-offset-4 col-lg-offset-4 margin-top-20">
					<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                                                'id'=>'login',	
                                                'enableAjaxValidation'=>false,
                                        )); ?>
                                                <div>
                                                    <?php echo $form->textFieldRow($model,'username',array('class'=>'span3','maxlength'=>20),  array('label'=>'Usuario')); ?>
                                                    <br>
                                                    <?php echo $form->labelEx($model,'password'); ?>
                                                    <?php echo $form->passwordField($model,'password',array('class'=>'span3','maxlength'=>20), array('label'=>'Contraseña')); ?>
                                                </div>                   

                                                <div>
                                                    <?php $this->widget('bootstrap.widgets.TbButton', array(
                                                                        'buttonType'=>'submit',
                                                                        'type'=>'primary',
                                                                        'label'=>'Iniciar',
                                                                )); ?>
                                                </div>
                                        <?php $this->endWidget(); ?>
                                    
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
						
				</div>
			</div>
                </div>
        </div>
</body>




<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css">