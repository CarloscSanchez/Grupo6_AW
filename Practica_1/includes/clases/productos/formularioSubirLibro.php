<?php

namespace includes\clases\productos;

use \includes\formulario as Formulario;
use \includes\clases\libros\libro;

// require_once __DIR__.'/../usuarios/usuario.php';
use includes\clases\usuarios\Usuario;

class FormularioSubirLibro extends Formulario
{
    public function __construct() {
        parent::__construct(
            'formSubirLibro',[
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
                        <option value="Novela" {$this->selected($genero, 'Novela')}>Novela</option>
                        <option value="Cuento" {$this->selected($genero, 'Cuento')}>Cuento</option>
                        <option value="Ciencia ficción" {$this->selected($genero, 'Ciencia ficción')}>Ciencia ficción</option>
                        <option value="Fantasía" {$this->selected($genero, 'Fantasía')}>Fantasía</option>
                        <option value="Terror" {$this->selected($genero, 'Terror')}>Terror</option>
                        <option value="Misterio y suspenso" {$this->selected($genero, 'Misterio y suspenso')}>Misterio y suspenso</option>
                        <option value="Romance" {$this->selected($genero, 'Romance')}>Romance</option>
                        <option value="Aventura" {$this->selected($genero, 'Aventura')}>Aventura</option>
                        <option value="Histórica" {$this->selected($genero, 'Histórica')}>Histórica</option>
                        <option value="Drama" {$this->selected($genero, 'Drama')}>Drama</option>
                        <option value="Realismo mágico" {$this->selected($genero, 'Realismo mágico')}>Realismo mágico</option>
                        <option value="Distopía" {$this->selected($genero, 'Distopía')}>Distopía</option>
                        <option value="Biografía y autobiografía" {$this->selected($genero, 'Biografía y autobiografía')}>Biografía y autobiografía</option>
                        <option value="Ensayo" {$this->selected($genero, 'Ensayo')}>Ensayo</option>
                        <option value="Historia" {$this->selected($genero, 'Historia')}>Historia</option>
                        <option value="Filosofía" {$this->selected($genero, 'Filosofía')}>Filosofía</option>
                        <option value="Psicología" {$this->selected($genero, 'Psicología')}>Psicología</option>
                        <option value="Ciencia y divulgación científica" {$this->selected($genero, 'Ciencia y divulgación científica')}>Ciencia y divulgación científica</option>
                        <option value="Autoayuda y desarrollo personal" {$this->selected($genero, 'Autoayuda y desarrollo personal')}>Autoayuda y desarrollo personal</option>
                        <option value="Política" {$this->selected($genero, 'Política')}>Política</option>
                        <option value="Economía" {$this->selected($genero, 'Economía')}>Economía</option>
                        <option value="Viajes y exploración" {$this->selected($genero, 'Viajes y exploración')}>Viajes y exploración</option>
                        <option value="Religión y espiritualidad" {$this->selected($genero, 'Religión y espiritualidad')}>Religión y espiritualidad</option>
                        <option value="Infantil y juvenil" {$this->selected($genero, 'Infantil y juvenil')}>Infantil y juvenil</option>
                        <option value="Cuentos infantiles" {$this->selected($genero, 'Cuentos infantiles')}>Cuentos infantiles</option>
                        <option value="Literatura juvenil (Young Adult - YA)" {$this->selected($genero, 'Literatura juvenil (Young Adult - YA')}>Literatura juvenil (Young Adult - YA)</option>
                        <option value="Fábulas y cuentos clásicos" {$this->selected($genero, 'Fábulas y cuentos clásicos')}>Fábulas y cuentos clásicos</option>
                        <option value="Libros ilustrados" {$this->selected($genero, 'Libros ilustrados')}>Libros ilustrados</option>
                        <option value="Poesía y teatro" {$this->selected($genero, 'Poesía y teatro')}>Poesía y teatro</option>
                        <option value="Poesía lírica" {$this->selected($genero, 'Poesía lírica')}>Poesía lírica</option>
                        <option value="Dramaturgia" {$this->selected($genero, 'Dramaturgia')}>Dramaturgia</option>
                        <option value="Teatro clásico y contemporáneo" {$this->selected($genero, 'Teatro clásico y contemporáneo')}>Teatro clásico y contemporáneo</option>
                        <option value="Cómics y novelas gráficas" {$this->selected($genero, 'Cómics y novelas gráficas')}>Cómics y novelas gráficas</option>
                        <option value="Manga" {$this->selected($genero, 'Manga')}>Manga</option>
                        <option value="Superhéroes" {$this->selected($genero, 'Superhéroes')}>Superhéroes</option>
                        <option value="Historieta europea" {$this->selected($genero, 'Historieta europea')}>Historieta europea</option>
                        <option value="Novela gráfica independiente" {$this->selected($genero, 'Novela gráfica independiente')}>Novela gráfica independiente</option>
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
                <button type="submit" class="btn-submit">Publicar libro</button>
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
                $this->errores[] = "Error al guardar el libro.";
            }
        }
    }

    private function selected($value, $option) {
        return $value === $option ? 'selected' : '';
    }
}
