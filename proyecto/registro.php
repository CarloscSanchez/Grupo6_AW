<?php

require_once __DIR__.'/includes/config.php';

use \includes\clases\usuarios\formularioRegistro;

$form = new FormularioRegistro();
$htmlFormRegistro = $form->gestiona();

$tituloPagina = 'Registro';

$contenidoPrincipal = <<<EOS
    <div class="login-body">
        <div class="login-container">  
            <h2>Crear una cuenta</h2>
                
            $htmlFormRegistro      

            <div class="extra-links">
                <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
            </div>
        </div>
    </div>

    <script  src="JS/jquery-3.7.1.min.js"></script>
    <script  src="JS/validarRegistro.js"></script>

EOS;


require __DIR__.'/includes/vistas/plantillas/plantilla.php';
