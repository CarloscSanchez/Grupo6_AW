<?php
require __DIR__.'/includes/config.php';

$tituloPagina = 'Gracias - BookSwap';

$contenidoPrincipal = <<<EOS
<div class="gracias-container">
    <h1 class="gracias-titulo">¡Gracias por contactarnos!</h1>
    <p class="gracias-mensaje">Hemos recibido tu consulta y nos pondremos en contacto contigo lo antes posible.</p>
    <a href="index.php" class="gracias-boton">Volver al inicio</a>
</div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';