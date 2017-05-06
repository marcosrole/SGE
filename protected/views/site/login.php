<head>
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/SGEicon.png" type="image/x-icon" />
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo Yii::app()->request->baseUrl; ?>/images/ico/apple-touch-icon-144-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" sizes="114x114"  href="<?php echo Yii::app()->request->baseUrl; ?>/images/ico/apple-touch-icon-144-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo Yii::app()->request->baseUrl; ?>/images/ico/apple-touch-icon-72-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" href="<?php echo Yii::app()->request->baseUrl; ?>/images/ico/apple-touch-icon-57-precomposed.png" />
        
    <?php
        $cs = Yii::app()->clientScript;
//        $cs->registerCssFile('/SGE/css/login/form-elements.css');
//        $cs->registerCssFile('/SGE/css/login/style.css');
     ?>
</head>

<body>
    <?php $this->pageTitle=Yii::app()->name . ' - Login';?>

<!-- Top content -->
        <div class="top-content">        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><strong>Sistema de Gestión del Estudiante</strong></h1> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
<!--                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Bienvenido</h3>
                            		<p>Ingrese su usuario y contraseña:</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-key"></i>
                        		</div>
                                        
                                </div>-->
                            <div class="form-bottom">
                                <h3>Bienvenido</h3>
                                <?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
                                                                'id'=>'login',	
                                                                'enableAjaxValidation'=>false,
                                                        )); ?>
                                
                                    <form class="login-form">
                                        <div class="form-group">
                                                <?php echo $form->textFieldGroup($model,'username',array('class'=>'span3','maxlength'=>20),  array('label'=>'Usuario')); ?>
                                        </div>
                                        <div class="form-group">
                                                <?php echo $form->passwordFieldGroup($model,'password',array('class'=>'span3','maxlength'=>20),  array('label'=>'Contraseña')); ?>
                                        </div>
                                        <?php $this->widget(
                                            'booster.widgets.TbButton',
                                                array('buttonType' => 'submit',
                                                    'context' => 'success', 
                                                    'label' => 'Entrar')
                                        ); ?>
                                         <a href="<?php echo $this->createUrl( 'site/Olvidemicontrasenia'); ?>">Olvidé mi constraseña</a>                                                       
                                         
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
                                         
                                         
                                    </form>
                                 <?php $this->endWidget(); ?>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>   
        </div>    
</body>



