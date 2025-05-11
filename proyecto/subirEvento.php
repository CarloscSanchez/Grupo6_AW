<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__ . '/includes/clases/productos/formularioCrearEvento.php'; 


use \includes\clases\productos\formularioCrearEvento;

$form = new FormularioCrearEvento();
$htmlFormCrearEvento = $form->gestiona();

$tituloPagina = 'Crear un evento';

$contenidoPrincipal = <<<EOS
    <div class="body-subirEvento">
        <div class="form-container">
            <h2>Crear un evento</h2>
            $htmlFormCrearEvento
        </div>
    </div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
