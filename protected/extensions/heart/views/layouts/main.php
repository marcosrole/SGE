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
    
        <?php // if(in_array($currAction, $validateControllerAndView{$currController})){?>
    
<!--         Latest compiled and minified CSS 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
         Optional theme 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
         Latest compiled and minified JavaScript 
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>-->

        <?php // } ?>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/sge.css">        
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
