<?php

require_once __DIR__.'/includes/config.php';

use \includes\clases\productos\formularioEditarEvento as FormularioEditarEvento;

$form = new FormularioEditarEvento();
$htmlFormEditarEvento = $form->gestiona();

$tituloPagina = 'Editar un evento';

$contenidoPrincipal = <<<EOS
    <div class="body-editarEvento">
        <div class="form-container">
            <h2>Editar un evento</h2>
            $htmlFormEditarEvento
        </div>
    </div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';