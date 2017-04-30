<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<div class="container">
    <div class="jumbotron">
        <h1>Bienvenido</h1>
        <p style="color: #337ab7;"><?php echo Yii::app()->user->getState('fullName'); ?></p>
    </div>
</div>

