<?php
$currController 	= Yii::app()->controller->id;
$currControllers	= explode('/', $currController);
$currAction			= Yii::app()->controller->action->id;
$currRoute 			= Yii::app()->controller->getRoute();
$currRoutes			= explode('/', $currRoute);

if(!Yii::app()->user->isGuest){
    $menu=
	array(
		array('label'=>'Inicio', 'url'=>array('/site/index'), 'icon'=>'home','active'=>($currController=='site' and $currAction=='index' )),
                array('label'=>'Usuarios', 'url'=>array('/usuario/admin'), 'icon'=>'glyphicon glyphicon-user','active'=>($currController=='usuario' and $currAction=='admin' ), 'visible'=>in_array("admin", Yii::app()->user->getState('rol'))),
                array('label'=>'Inscripciones', 'url'=>'#', 'icon'=>'glyphicon glyphicon-open-file' , 'visible'=>in_array("alumno", Yii::app()->user->getState('rol')) , 'items'=>array(
			array('label'=>'Mesa de Examen', 'icon'=>'glyphicon glyphicon-list-alt', 'url'=>array('/inscripcionMateria/create'),'visible'=> Yii::app()->user->getState('rolUsuario') == 'alumno'),
			array('label'=>'Mesa de Examen', 'icon'=>'glyphicon glyphicon-list' ,'url'=>array(''),'visible'=>in_array("admin", Yii::app()->user->getState('rol'))) ,
			//'---',
			//array('label'=>'NAV HEADER'),
		)),
//		array('label'=>'Admin', 'url'=>'#', 'icon'=>'', 'visible'=>!Yii::app()->user->isGuest, 'active'=> false ,'items'=>array(
//			array('label'=>'Generator Code', 'url'=>array('/gii/heart'), 'icon'=>'fa fa-refresh fa-fw', 'visible'=>!Yii::app()->user->isGuest),
//			//'---',
//			//array('label'=>'NAV HEADER'),
//		)),
//		array('label'=>'Pages', 'url'=>'#', 'icon'=>'fa fa-sitemap' , 'active'=>($currController=='site' and $currAction!='index') , 'items'=>array(
//			array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about'),'active'=>($currController=='site' and $currAction=='page' )),
//			array('label'=>'Contact', 'url'=>array('/site/contact'),'active'=>($currController=='site' and $currAction=='contact' )),
//			//'---',
//			//array('label'=>'NAV HEADER'),
//		)),
	);	
}

?>	