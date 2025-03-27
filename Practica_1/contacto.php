<?php
require __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/clases/FormularioContacto.php';

$tituloPagina = 'Contacto - BookSwap';

$formulario = new FormularioContacto();
$htmlFormulario = $formulario->gestiona();

$contenidoPrincipal = <<<EOS
<div class="contacto-container">
    <h1 class="contacto-titulo">Contacto</h1>
    <p class="contacto-descripcion">¿Tienes alguna pregunta o sugerencia? Rellena el formulario y nos pondremos en contacto contigo lo antes posible.</p>
    $htmlFormulario
</div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';