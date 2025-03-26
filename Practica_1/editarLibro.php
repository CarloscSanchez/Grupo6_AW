<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/clases/productos/FormularioEditarLibro.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';

if (!$id) {
    die("ID de libro no proporcionado.");
}

$form = new FormularioEditarLibro($id);
$htmlFormEditarLibro = $form->gestiona();

$tituloPagina = 'Editar un libro';

$contenidoPrincipal = <<<EOS
    <div class="body-subirLibro">
        <div class="form-container">
            <h2>Edita tu libro</h2>
            $htmlFormEditarLibro
        </div>
    </div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';