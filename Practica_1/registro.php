<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/clases/usuarios/FormularioRegistro.php';

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

EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
