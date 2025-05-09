<?php
require_once __DIR__ . '/includes/config.php';

use \includes\clases\usuarios\usuario;
use \includes\clases\usuarios\formularioUsuario;
$usuario = Usuario::buscaUsuario($_SESSION['nombre']);

$form = new FormularioUsuario($usuario);
$htmlForm = $form->gestiona();

$tituloPagina = 'Editar Perfil';
$contenidoPrincipal = <<<EOS
    <div class="body-subirLibro">
        <div class="form-container">
            <h2>Editar Perfil</h2>
            $htmlForm
        </div>
    </div>

    <script src="JS/jquery-3.7.1.min.js"></script>
    <script src="JS/validarRegistro.js"></script>
EOS;

require __DIR__ . '/includes/vistas/plantillas/plantilla.php';