<?php
require_once __DIR__.'/../../formulario.php';
require_once __DIR__.'/usuario.php';

class FormularioRegistro extends Formulario
{
    public function __construct() {
        parent::__construct('formRegistro', ['urlRedireccion' => 'index.php']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $nombreUsuario = $datos['nombreUsuario'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombreUsuario', 'email', 'password', 'password2'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>    
            <div class="input-group">
                <label for="nombreUsuario">Nombre de Usuario</label>
                <input type="text" id="nombreUsuario" name="nombreUsuario" value="$nombreUsuario" required>
            $erroresCampos[nombreUsuario]
            </div>

            <div class="input-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" required>   
                {$erroresCampos['email']} 
            </div>

            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
                {$erroresCampos['password']}
            </div>
            <div class="input-group">
                <label for="password2">Repetir Contraseña</label>
                <input type="password" id="password2" name="password2" required>
                {$erroresCampos['password2']}
            </div>

            <div>
                <button type="submit" class="btn-login">Registrarse</button>
            </div>

        </fieldset>
        EOF;
        
        return $html;
    }
    

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $nombreUsuario = trim($datos['nombreUsuario'] ?? '');
        $nombreUsuario = filter_var($nombreUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombreUsuario || mb_strlen($nombreUsuario) < 5) {
            $this->errores['nombreUsuario'] = 'El nombre de usuario tiene que tener una longitud de al menos 5 caracteres.';
        }

        $correo = trim($_POST['email'] ?? '');
        $correo = filter_var($correo, FILTER_SANITIZE_EMAIL);
        if ( ! $correo ) {
            $this->errores['email'] = 'El correo electrónico no es válido';
        }

        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $password || mb_strlen($password) < 5 ) {
            $this->errores['password'] = 'El password tiene que tener una longitud de al menos 5 caracteres.';
        }

        $password2 = trim($datos['password2'] ?? '');
        $password2 = filter_var($password2, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $password2 || $password != $password2 ) {
            $this->errores['password2'] = 'Los passwords deben coincidir';
        }

        if (count($this->errores) === 0) {
            $usuario = Usuario::buscaUsuario($nombreUsuario, $correo);
            $usuarioCorreo = Usuario::buscarPorCorreo($correo);
            if ($usuario || $usuarioCorreo) {
                $this->errores[] = "El usuario o el correo ya están registrados";
            } else {
                $usuario = Usuario::crea($nombreUsuario, $password, $correo, 'normal');
                $_SESSION['login'] = true;
                $_SESSION['nombre'] = $usuario->getNombre();
            }
        }
    }
}
