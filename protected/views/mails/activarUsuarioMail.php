<?php 
$url = "http://localhost/SGE/site/activarUsuario?tokenParam=";
?>   
<p class="nota text-center"> 
    <strong>
        <h2>¡Hola! Bienvenido al Sistema de Gestión del Estudiante</h2>
    </strong>
    <br>
    Para continuar con la inscripción al sistema, hacé click en <strong>Activar</strong>
    <br>
    <button type="button" class="btn btn-default btn-lg">
            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
            <a href=" <?php echo $url; ?><?php echo $token;?>">Activar</a>
    </button>
</p>

<div class="text-center">
    En caso de no ver el botón, hacé click <a href=" <?php echo $url; ?><?php echo $token;?>">aquí</a>
    
    <br>
    <h3>¡Muchas Gracias!</h3>
</div>



<br>
<br>
<address>
    <h5>Este es un mensaje generado automáticamente. Por favor, no lo respondas.</h5>
</address>
 