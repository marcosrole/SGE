<?php
$currController 	= Yii::app()->controller->id;
$currControllers	= explode('/', $currController);
$currAction			= Yii::app()->controller->action->id;
$currRoute 			= Yii::app()->controller->getRoute();
$currRoutes			= explode('/', $currRoute);

$menu=array();
if(in_array($currAction,array('index','view','create','admin', 'update','calendar','import')))
$menu[]=array('label'=>'Usuarios','url'=>array('usuario/admin'),'icon'=>'tasks','active'=>($currAction=='admin')?true:false);

if(in_array($currAction,array('index','view','update','admin','calendar','import', 'admin')))
$menu[]=array('label'=>'Nuevo Usuario','url'=>array('usuario/create'),'icon'=>'plus','active'=>($currAction=='create')?true:false);


