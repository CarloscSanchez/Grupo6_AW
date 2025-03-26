<?php
require_once __DIR__.'/../../Formulario.php';
require_once __DIR__.'/Libro.php';
require_once __DIR__.'/../usuarios/Usuario.php';

class FormularioEditarLibro extends Formulario
{
    public function __construct() {
        parent::__construct(
            'formEditarLibro',[
                'urlRedireccion' => 'perfil.php', 
                'enctype' => 'multipart/form-data'
            ]
        );
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $titulo = $datos['titulo'] ?? '';
        $autor = $datos['autor'] ?? '';
        $genero = $datos['genero'] ?? '';
        $estado = $datos['estado'] ?? '';
        $idioma = $datos['idioma'] ?? '';
        $descripcion = $datos['descripcion'] ?? '';
        $editorial = $datos['editorial'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['titulo', 'autor', 'genero', 'estado', 'idioma', 'descripcion', 'editorial', 'foto'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <div class="input-group">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" value="$titulo" required>
                {$erroresCampos['titulo']}
            </div>

            <div class="input-group">
                <label for="autor">Autor:</label>
                <input type="text" id="autor" name="autor" value="$autor" required>
                {$erroresCampos['autor']}
            </div>

            <div class="input-group">
                <label for="genero">Género:</label>
                <select id="genero" name="genero" required>
                    <option value="">Selecciona un género</option>
                    <option value="Poesía" {$this->selected($genero, 'Poesía')}>Poesía</option>
                    <option value="Aventuras" {$this->selected($genero, 'Aventuras')}>Aventuras</option>
                    <option value="Ciencia ficción" {$this->selected($genero, 'Ciencia ficción')}>Ciencia ficción</option>
                    <option value="Romance" {$this->selected($genero, 'Romance')}>Romance</option>
                    <option value="Misterio" {$this->selected($genero, 'Misterio')}>Misterio</option>
                    <option value="Fantasía" {$this->selected($genero, 'Fantasía')}>Fantasía</option>
                    <option value="Histórico" {$this->selected($genero, 'Histórico')}>Histórico</option>
                </select>
                {$erroresCampos['genero']}
            </div>

            <div class="input-group">
                <label for="estado">Estado:</label>
                    <select id="estado" name="estado" required>
                        <option value="">Selecciona un estado</option>
                        <option value="nuevo" {$this->selected($estado, 'nuevo')}>Nuevo</option>
                        <option value="bueno" {$this->selected($estado, 'bueno')}>Bueno</option>
                        <option value="aceptable" {$this->selected($estado, 'aceptable')}>Aceptable</option>
                        <option value="deteriorado" {$this->selected($estado, 'deteriorado')}>Deteriorado</option>
                    </select>
                {$erroresCampos['estado']}  
            </div>

            <div class="input-group">
                <label for="idioma">Idioma:</label>
                <input type="text" id="idioma" name="idioma" value="$idioma" required>
                {$erroresCampos['idioma']}
            </div>

            <div class="input-group">
                <label for="descripcion">Descripción:</label>
                <input type="text" id="descripcion" name="descripcion" value="$descripcion" required>
                {$erroresCampos['descripcion']}
            </div>

            <div class="input-group">
                <label for="editorial">Editorial:</label>
                <input type="text" id="editorial" name="editorial" value="$editorial" required>
                {$erroresCampos['editorial']}
            </div>

            <div class="input-group">
                <label for="foto">Foto del libro (opcional):</label>
                <input type="file" id="foto" name="foto" accept="image/*">
                {$erroresCampos['foto']}
            </div>

            <div>
                <button type="submit" class="btn-submit">Editar libro</button>
                <button class="btn-cancel" type="button" onclick="window.location.href='perfil.php'">Cancelar</button>
            </div>
        </fieldset>
        EOF;

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        // Validar campos
        $titulo = htmlspecialchars(trim($datos['titulo'] ?? ''));
        $autor = htmlspecialchars(trim($datos['autor'] ?? ''));
        $genero = htmlspecialchars(trim($datos['genero'] ?? ''));
        $estado = htmlspecialchars(trim($datos['estado'] ?? ''));
        $idioma = htmlspecialchars(trim($datos['idioma'] ?? ''));
        $descripcion = htmlspecialchars(trim($datos['descripcion'] ?? ''));
        $editorial = htmlspecialchars(trim($datos['editorial'] ?? ''));

        if (!$titulo) $this->errores['titulo'] = 'El título no puede estar vacío.';
        if (!$autor) $this->errores['autor'] = 'El autor no puede estar vacío.';
        if (!$genero) $this->errores['genero'] = 'El género no puede estar vacío.';
        if (!$estado) $this->errores['estado'] = 'El estado no puede estar vacío.';
        if (!$idioma) $this->errores['idioma'] = 'El idioma no puede estar vacío.';
        if (!$descripcion) $this->errores['descripcion'] = 'La descripción no puede estar vacía.';
        if (!$editorial) $this->errores['editorial'] = 'La editorial no puede estar vacía.';

        // Validar imagen
        $ruta_imagen = null;
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $nombre_imagen = basename($_FILES['foto']['name']);
            $ruta_imagen = 'img/' . $nombre_imagen; // Ruta completa al directorio de imágenes
            if (!move_uploaded_file($_FILES['foto']['tmp_name'], $ruta_imagen)) {
                $this->errores['foto'] = 'Error al mover la imagen al directorio de destino.';
            }
        } else {
            $this->errores['foto'] = 'Debes seleccionar una imagen válida.';
        }
        // Si no hay errores, delegar la creación del libro a la clase Libro
        if (count($this->errores) === 0) {
            $idUsuario = null; 
            $usuario = Usuario::buscaUsuario($_SESSION['nombre']);
            if ($usuario) {
                $idUsuario = $usuario->getId();
            }
            $libro = Libro::crea($titulo, $autor, $genero, $editorial, $idioma, $estado, $descripcion, $ruta_imagen, $idUsuario);
            if (!$libro) {
                $this->errores[] = "Error al editar el libro.";
            }
        }
    }

    private function selected($value, $option) {
        return $value === $option ? 'selected' : '';
    }
}