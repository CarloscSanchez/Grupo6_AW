<?php
require_once __DIR__.'/includes/config.php';

$app = Aplicacion::getInstance();
$conn = $app->getConexionBd();

if ($conn->connect_errno) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? $_GET['id'] : '';

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM libros WHERE idlibro = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $libro = $stmt->get_result()->fetch_assoc();
    $stmt->close();
} else {
    die("ID de libro no proporcionado.");
}

$tituloPagina = 'Editar un libro';

$contenidoPrincipal = <<<EOS
    <div class="body-subirLibro">
        <div class="form-container">
            <h2>Edita tu libro</h2>
            <form action="procesar_editar_libro.php?id={$id}" method="post" enctype="multipart/form-data">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" value="{$libro['titulo']}" required>
                
                <label for="autor">Autor:</label>
                <input type="text" id="autor" name="autor" value="{$libro['autor']}" required>
                
                <label for="genero">Género:</label>
                <select id="genero" name="genero" required>
                    <option value="">Selecciona un género</option>
EOS;

$generos = ["Poesía", "Aventuras", "Ciencia ficción", "Romance", "Misterio", "Fantasía", "Histórico", "Terror", "Biografía", "Clásico"];
foreach ($generos as $genero) {
    $selected = ($libro['genero'] == $genero) ? 'selected' : '';
    $contenidoPrincipal .= "<option value=\"$genero\" $selected>$genero</option>";
}

$contenidoPrincipal .= <<<EOS
                </select>
                
                <label for="estado">Estado:</label>
                <select id="estado" name="estado">
                    <option value="">Selecciona un estado</option>
EOS;

$estados = ["nuevo", "bueno", "aceptable", "deteriorado"];
foreach ($estados as $estado) {
    $selected = ($libro['estado'] == $estado) ? 'selected' : '';
    $contenidoPrincipal .= "<option value=\"$estado\" $selected>$estado</option>";
}

$contenidoPrincipal .= <<<EOS
                </select>
                
                <label for="idioma">Idioma:</label>
                <input type="text" id="idioma" name="idioma" value="{$libro['idioma']}" required>
                
                <label for="descripcion">Descripción:</label>
                <input type="text" id="descripcion" name="descripcion" value="{$libro['descripcion']}">
                
                <label for="editorial">Editorial:</label>
                <input type="text" id="editorial" name="editorial" value="{$libro['editorial']}" required>
                
                <button class="btn-submit" type="submit">Actualizar libro</button>
                <button class="btn-cancel" type="button" onclick="window.location.href='perfil.php'">Cancelar</button>
            </form>
        </div>
    </div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
