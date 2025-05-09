<?php

namespace includes\clases\usuarios;

use \includes\formulario as Formulario;
use \includes\clases\usuarios\usuario as Usuario;


class FormularioUsuario extends Formulario
{
    private $usuario;

    public function __construct($usuario)
    {
        parent::__construct('formUsuario', ['enctype' => 'multipart/form-data']);
        $this->usuario = $usuario;
    }

    protected function generaCamposFormulario(&$datos)
    {
        $nombreUsuario = $datos['nombreUsuario'] ?? $this->usuario->getNombre();
        $email = $datos['email'] ?? $this->usuario->getCorreo();

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombreUsuario', 'email', 'foto'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Editar Perfil</legend>

            <div class="input-group">
                <label for="nombreUsuario">Nombre de usuario:</label>
                <input type="text" id="nombreUsuario" name="nombreUsuario" value="$nombreUsuario" required>
                <span id="validUser"></span>
                {$erroresCampos['nombreUsuario']}
            </div>

            <div class="input-group">
                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" value="$email" required>
                <span id="validEmail"></span>
                {$erroresCampos['email']}
            </div>

            <div class="input-group">
                <label for="foto">Foto del libro (opcional):</label>
                <input type="file" id="foto" name="foto" accept="image/*">
                {$erroresCampos['foto']}
            </div>

            <div class="button-group">
                <button type="submit" class="btn-cambiarPerfil">Guardar cambios</button>
                <button class="btn-cancelarPerfil" type="button" onclick="window.location.href='perfil.php'">Cancelar</button>
            </div>
        </fieldset>
        EOF;

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $nombreUsuario = htmlspecialchars(trim($datos['nombreUsuario'] ?? ''));
        $email = htmlspecialchars(trim($datos['email'] ?? ''));

        if (!$nombreUsuario) {
            $this->errores['nombreUsuario'] = 'El nombre de usuario no puede estar vacío.';
        }

        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errores['email'] = 'El correo electrónico no es válido.';
        }

        // Validar y procesar la foto de perfil
        $rutaFoto = $this->usuario->getUrlImagen() ?? null; // Mantener la foto actual si no se sube una nueva

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $nombreFoto = basename($_FILES['foto']['name']);
            $rutaFoto = 'img/' . $nombreFoto; // Ruta completa al directorio de imágenes
            if (!move_uploaded_file($_FILES['foto']['tmp_name'], $rutaFoto)) {
                $this->errores['foto'] = 'Error al subir la foto de perfil.';
            }
        }

        // Si no hay errores, actualizar los datos del usuario
        if (count($this->errores) === 0) {
            $this->usuario->setNombre($nombreUsuario);
            $this->usuario->setCorreo($email);
            if ($rutaFoto) {
                $this->usuario->setUrlImagen($rutaFoto); // Actualizar la ruta de la foto
            }

            if (!Usuario::actualiza($this->usuario)) {
                $this->errores[] = 'Error al actualizar los datos del usuario.';
            } else {
                // Redirigir al perfil después de guardar los cambios
                $_SESSION['nombre'] =$nombreUsuario;
                header('Location: perfil.php');
                exit();
            }
        }
    }
}