<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	 
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-responsive.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css">            
        <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/SGEicon.png" type="image/x-icon" />
       
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<?php
$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');

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
