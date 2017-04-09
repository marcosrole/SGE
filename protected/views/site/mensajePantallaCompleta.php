<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        
        <div class="panel panel-success">
            <div class="panel-body">
              <div class="col-xs-12 col-sm-12 col-md-6 col-lg-8 col-md-offset-2 text-center">
                    <h3>Se envió un mail a la casilla de corre electrónico.</h3>
                        <?php echo CHtml::button('Aceptar', array('submit' => array('site/Logout'))); ?>
              </div>
            </div>
        </div>        
    </body>
</html>
