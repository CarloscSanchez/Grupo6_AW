<?php

require_once __DIR__.'/includes/config.php';

use \includes\clases\productos\formularioSubirLibro as FormularioSubirLibro;

$form = new FormularioSubirLibro();
$htmlFormSubirLibro = $form->gestiona();

$tituloPagina = 'Subir un libro';

$contenidoPrincipal = <<<EOS
    <div class="body-subirLibro">
        <div class="form-container">
            <h2>Subir un libro</h2>
            $htmlFormSubirLibro
        </div>
    </div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
