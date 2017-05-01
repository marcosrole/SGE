<?php 
$url = "http://localhost/SGE/site/olvidemicontrasenia?token=";
?>   
<p class="nota text-center"> 
    <strong>
        <h3>¡Hola!</h3>
        <h2>Recibiste este email porque desde el sitio de Sistema de Gestion del Estudiante, solicitaste recuperar tu contraseña.</h2>
    </strong>
    <br>
    <button type="button" class="btn btn-default btn-lg">
            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
            <a href=" <?php echo $url . $token;?>">Recuperar contraseña</a>
    </button>
</p>

<div class="text-center">
    En caso de no ver el botón, hacé click <a href=" <?php echo $url . $token;?>">aquí</a>
    
    <br>
    <h3>¡Muchas Gracias!</h3>
</div>



<br>
<br>
<address>
    <h5>Este es un mensaje generado automáticamente. Por favor, no lo respondas.</h5>
</address>
 