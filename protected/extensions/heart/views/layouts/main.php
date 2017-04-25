<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <?php
        $cs        = Yii::app()->clientScript;
        $themePath = Yii::app()->theme->baseUrl;

        /**
         * StyleSHeets
         */
        $cs->registerCssFile('/SGE/css/bootstrap.css');
        $cs->registerCssFile('/SGE/css/bootstrap-theme.css');

        /**
         * JavaScripts
         */
        $cs->registerCoreScript('jquery', CClientScript::POS_END);
        $cs->registerCoreScript('jquery.ui', CClientScript::POS_END);
        $cs->registerScriptFile('/SGE/js/bootstrap.min.js', CClientScript::POS_END);
        $cs->registerScript('tooltip', "$('[data-toggle=\"tooltip\"]').tooltip();$('[data-toggle=\"popover\"]').tooltip()", CClientScript::POS_READY);
        ?>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="<?php
        echo Yii::app()->theme->baseUrl . '/SGE/js/html5shiv.js';
        ?>"></script>
            <script src="<?php
        echo Yii::app()->theme->baseUrl . '/SGE/js/respond.min.js';
        ?>"></script>
        <![endif]-->
	<?php 
            $currController = Yii::app()->controller->id;
            $currAction= Yii::app()->controller->action->id;   
//            
//            $validateControllerAndView = array(
//                'site'=>array('login',),);
            
        ?> 
                      
        <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/SGEicon.png" type="image/x-icon" />
       
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<?php
$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');

$actionNoShow = array('login','enviarMailActivacion', 'activarUsuario');
$controllerNoShow = array('site');
if( !(in_array($currController, $controllerNoShow) && in_array($currAction, $actionNoShow))){   
    $this->widget('bootstrap.widgets.TbNavbar', array(
            'type'=>null, // null or 'inverse'
            'brand'=>'Inicio',
            'brandUrl'=>'#',
            'collapse'=>true, // requires bootstrap-responsive.css
            'fixed' => false,
            'fluid' => true,
            'items'=>array(
                    array(
                            'class'=> 'bootstrap.widgets.TbMenu',
                            'items'=> $menu,				
                    ),
                    array(
                            'class'=>'bootstrap.widgets.TbMenu',
                            'htmlOptions'=>array('class'=>'pull-right'),
                            'items'=>array(
                                    array('label'=>'Iniciar Sesión', 'url'=>array('/site/login'), 'icon'=>'unlock', 'visible'=>Yii::app()->user->isGuest),
                                    //'---',
                                    array('label'=>'', 'url'=>'#', 'icon'=>'user', 'itemOptions' => array('class' => 'user'), 'visible'=>!Yii::app()->user->isGuest, 'items'=>array(
                                            array('label'=>'Ver perfil', 'url'=>array('site/logout'), 'icon'=>'icon-attach',),
                                            array('label'=>'Cerrar sesión ('.Yii::app()->user->name.')', 'url'=>array('site/logout'), 'icon'=>'icon-off',),

                                    )),
                            ),
                    ),
            ),
    ));
}
?>

<div class="container" id="page">
	<?php 
	if(isset($this->breadcrumbs)){
		$this->widget('bootstrap.widgets.TbBreadcrumbs', array(
		    'links'=>$this->breadcrumbs,
		));
	}	
	?>
	<?php echo $content; ?>
	<div class="clearfix"></div>
        
</div><!-- page -->


</body>
    
</html>
