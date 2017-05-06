<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    
    <?php 
            $currController = Yii::app()->controller->id;
            $currAction= Yii::app()->controller->action->id;   
//            
//            $validateControllerAndView = array(
//                'site'=>array('login',),);
            
        ?> 
   
    <?php
        $cs        = Yii::app()->clientScript;
        $themePath = Yii::app()->theme->baseUrl;

        /**
         * StyleSHeets
         */
        
        $cs->registerCssFile('/SGE/css/bootstrap.css');
        $cs->registerCssFile('/SGE/css/bootstrap-theme.css');
        $cs->registerCssFile('/SGE/css/font-awesome.css');
        
        
        if($currController=='site' && $currAction=='login'){
            $cs->registerCssFile('/SGE/css/login/style.css');
            $cs->registerCssFile('/SGE/css/login/form-elements.css');            
        }
        
       
       
        
        

        /**
         * JavaScripts
         */
        $cs->registerCoreScript('jquery', CClientScript::POS_END);
        $cs->registerCoreScript('jquery.ui', CClientScript::POS_END);
//        $cs->registerScriptFile('/SGE/js/bootstrap.min.js', CClientScript::POS_END);
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
    $this->widget('booster.widgets.TbNavbar', array(
            'type'=>'inverse', // null or 'inverse'
            'brand'=>'Sistema de Gestión del Estudiante',
            'brandUrl'=>'',
            'collapse'=>true, // requires bootstrap-responsive.css
            'fixed' => false,
            'fluid' => false,
            'items'=>array(
                    array(
                            'class'=> 'booster.widgets.TbMenu',
                            'type' => 'navbar',
                            'items'=> $menu,				
                    ),
               
            array(
                'class' => 'booster.widgets.TbMenu',
                'type' => 'navbar',
                'htmlOptions' => array('class' => 'pull-right'),
                'items' => array(
                    array('label'=>Yii::app()->user->name, 'url'=>'#', 'icon'=>'user', 'itemOptions' => array('class' => 'user'), 'visible'=>!Yii::app()->user->isGuest, 'items'=>array(
                                array('label'=>'Ver perfil', 'url'=>array('site/logout'), 'icon'=>'glyphicon glyphicon-list-alt',),
                                array('label'=>'Cerrar sesión ('.Yii::app()->user->name.')', 'url'=>array('site/logout'), 'icon'=>'glyphicon glyphicon-off',),

                        )),
                    array('label'=>'', 'url'=>array('site/logout'), 'icon'=>'glyphicon glyphicon-off','visible'=>!Yii::app()->user->isGuest),
                    ),
                    
                ),
            ),
    ));
}
?>

<div class="container" id="page">
	<?php 
	if(isset($this->breadcrumbs)){
		$this->widget('booster.widgets.TbBreadcrumbs', array(
		    'links'=>$this->breadcrumbs,
		));
	}	
	?>
	<?php echo $content; ?>
	<div class="clearfix"></div>
        
<!--        <div class="text-center bottom" style="font-family: initial; font-size: small;">
		Copyright &copy; <?php echo date('Y'); ?> by Marcos Rolé. <a href="mailto:smarcosrole@gmail.com?Subject=SGE" target="_top">marcosrole@gmail.com</a><br/>
	</div> footer -->
        
</div><!-- page -->

</body>
    
</html>
