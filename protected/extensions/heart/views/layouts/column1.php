<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div id="content">
	<?php 
	$currController 	= Yii::app()->controller->id;
	$currAction			= Yii::app()->controller->action->id;
        
	if($currController=='site' && $currAction!='login'){
		$box = $this->beginWidget(
		    'bootstrap.widgets.TbBox',
		    array(
		        'title' => ($currAction=='enviarmailactivacion')?'Envío de mail de activacion':(($currAction=='contact')?'Contact Us':'Home'),
		        'headerIcon' => 'icon-envelope'
		    )
		);
	}
	?>
	
	<?php echo $content; ?>

	<?php
	if($currController=='site' && $currAction!='login'){
		$this->endWidget();
	}
	?>
</div><!-- content -->
<?php $this->endContent(); ?>