<?php

require_once __DIR__.'/includes/config.php';

use \includes\clases\usuarios\formularioLogin;

$form = new FormularioLogin();
$htmlFormLogin = $form->gestiona();

$tituloPagina = 'Login';

$contenidoPrincipal = <<<EOS
    <div class="login-body">
        <div class="login-container">
            <h2>Iniciar Sesión</h2>
            
            $htmlFormLogin

            <div class="extra-links">
                <br>
                <a href="registro.php">¿Todavía no tienes cuenta? Regístrate</a>
            </div>
        </div>
    </div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
?>
