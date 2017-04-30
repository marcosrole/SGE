<?php
$currController 	= Yii::app()->controller->id;
$currControllers	= explode('/', $currController);
$currAction			= Yii::app()->controller->action->id;
$currRoute 			= Yii::app()->controller->getRoute();
$currRoutes			= explode('/', $currRoute);

$menu=array();


if( in_array("admin", Yii::app()->user->getState('rol'))){
    if(in_array($currAction,array('index','view','create','update','calendar','import')))
    $menu[]=array('label'=>'Usuarios','url'=>array('admin'),'icon'=>'glyphicon glyphicon-tasks','active'=>($currAction=='admin')?true:false);
    
    if(in_array($currAction,array('index','view','update','admin','calendar','import')))
    $menu[]=array('label'=>'Nuevo Usuario','url'=>array('create'),'icon'=>'glyphicon glyphicon-plus','active'=>($currAction=='create')?true:false);
}

if( in_array("superadmin", Yii::app()->user->getState('rol'))){
    if(in_array($currAction,array('index','view','create','update','admin','calendar','import')))
    $menu[]=array('label'=>'Roles','url'=>array('usuarioRol/admin'),'icon'=>'glyphicon glyphicon-random','active'=>($currAction=='create')?true:false);
}



