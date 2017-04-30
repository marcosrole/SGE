
<?php


/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */



$this->pageTitle=Yii::app()->name . ' - Login';

?>

                <nav class="navbar">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-12 text-center padding-top-20 padding-bottom-20">
						<img >
					</div>
				</div>
				<div class="row">
					<div class="tp-gradiente-colores"></div>
				</div>
			</div>
		</nav>

		<div class="container">
			<div class="row text-center">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<H2 style="font-size: 28px; margin: 15px;">Ingreso al Sistema</H2>
				</div>
			</div>
			<div class="row" >
				<div
					class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-md-offset-4 col-lg-offset-4 margin-top-20">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<span class="tpicon tpicon-perfil"></span> Bienvenido
							</h4>
						</div>
						

                                                <div class="panel-body">
                                                        <?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
                                                                'id'=>'login',	
                                                                'enableAjaxValidation'=>false,
                                                        )); ?>
                                                                <div>
                                                                    <?php echo $form->textFieldGroup($model,'username',array('class'=>'span3','maxlength'=>20),  array('label'=>'Usuario')); ?>

                                                                    <?php echo $form->passwordFieldGroup($model,'password',array('class'=>'span3','maxlength'=>20), array('label'=>'Contraseña')); ?>
                                                                </div>     
                                                                
                                                        
                                                </div>

                                                <div class="panel-footer">
                                                        <a href="" >Olvidé mi contraseña</a>
                                                        <div class="text-right">
                                                                <?php $this->widget(
                                                                    'booster.widgets.TbButton',
                                                                        array('buttonType' => 'submit',
                                                                            'context' => 'success', 
                                                                            'label' => 'Entrar')
                                                                ); ?>	
                                                            
                                                            <?php $this->endWidget(); ?>
                                                        </div>
                                                </div>
					</div>
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
				</div>
			</div>



<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/booster.min.css">