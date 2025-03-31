<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/clases/productos/formularioEditarLibro.php';

$form = new FormularioEditarLibro();
$htmlFormSubirLibro = $form->gestiona();

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
