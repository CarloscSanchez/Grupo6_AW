<?php

require_once __DIR__.'/includes/config.php';

// esto cambiarlo por namespace en un futuro
require_once __DIR__.'/includes/clases/usuarios/formularioLogin.php';

$form = new FormularioLogin();
$htmlFormLogin = $form->gestiona();

$tituloPagina = 'Login';

$contenidoPrincipal = <<<EOS
    <div class="login-body">
        <div class="login-container">
            <h2>Iniciar Sesión</h2>
            
            $htmlFormLogin

            <div class="extra-links">
                <a href="recuperar_contraseña.php">¿Has olvidado tu contraseña?</a>
                <br>
                <a href="registro.php">¿Todavía no tienes cuenta? Regístrate</a>
            </div>
        </div>
    </div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
?>
