<?php

require_once __DIR__.'/includes/config.php';

use \includes\clases\productos\formularioEditarLibro as FormularioEditarLibro;

$form = new FormularioEditarLibro();
$htmlFormEditarLibro = $form->gestiona();

$tituloPagina = 'Editar un libro';

$contenidoPrincipal = <<<EOS
    <div class="body-editarLibro">
        <div class="form-container">
            <h2>Editar un libro</h2>
            $htmlFormEditarLibro
        </div>
    </div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
