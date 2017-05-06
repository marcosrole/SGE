<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div id="content">
	<?php 
	$currController 	= Yii::app()->controller->id;
	$currAction			= Yii::app()->controller->action->id;
        
	if($currController=='site' && ($currAction=='enviarMailActivacion' || $currAction=='activarUsuario')){
//		$box = $this->beginWidget(
//		    'booster.widgets.TbPanel',
//		    array(
//		        'title' => ($currAction=='enviarMailActivacion')?'Envío de mail de activacion':'Datos del usuario',
//		        'headerIcon' => 'icon-envelope'
//		    )
//		);
	}
	?>
	
	<?php echo $content; ?>

	<?php
	if($currController=='site' && ($currAction=='enviarMailActivacion' || $currAction=='activarUsuario')){
//		$this->endWidget();
	}
	?>
</div><!-- content -->
<?php $this->endContent(); ?>