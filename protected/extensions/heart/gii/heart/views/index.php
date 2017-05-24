<?php
$this->layout="ext.heart.gii.heart.views.layouts.generator";
?>
<?php $box = $this->beginWidget(
	'booster.widgets.TbPanel',
	array(
		'title' => 'Heart Generator',
		'headerIcon' => 'icon- fa fa-rocket'
	)
);?>

<?php $this->beginWidget(
    'booster.widgets.TbHeroUnit',
    array(
        'heading' => 'Heart Gii!',
    )
); ?>
 
    <p>Heart Generator is High Performance Generator Tools. It to easy create professional web application in minutes!!.</p>
 
    <p><?php $this->widget(
            'booster.widgets.TbButton',
            array(
                'context' => 'primary',
                'size' => 'large',
                'label' => 'Are You Ready?',
            )
        ); ?></p>
 
<?php $this->endWidget(); ?>

<?php $this->endWidget(); ?>

