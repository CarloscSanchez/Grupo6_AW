<?php
require __DIR__.'/includes/config.php';

// Crear la conexión
$app = Aplicacion::getInstance();
$conn = $app->getConexionBD();

// Verificar la conexión
if ($conn->connect_errno) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

$id_libro = $_GET["id"] ?? null;
$libro = null;

// Consulta para obtener el libro
if ($id_libro) {
    $stmt = $conn->prepare("SELECT * FROM libros LEFT JOIN usuarios ON usuarios.idusuario = libros.idpropietario WHERE idlibro = ?");
    $stmt->bind_param("i", $id_libro);
    $stmt->execute();
    $libro = $stmt->get_result()->fetch_assoc();
}

$tituloPagina = 'Ver Libro - BookSwap';

if ($libro) {
    $acciones = '';
    if (isset($_SESSION['nombre'])) {
        if ($libro["nombre"] == $_SESSION['nombre']) {
            $acciones = <<<EOS
            <div class="acciones">
                <button class="editar" onclick="window.location.href='editarLibro.php?id={$libro["idlibro"]}'">Editar</button>
                <button class="borrar" onclick="window.location.href='procesar_borrado_libro.php?id={$libro["idlibro"]}'">Borrar</button>
            </div>
            EOS;
        } else {
            $acciones = <<<EOS
            <div class="acciones">
                <button class="intercambiar" onclick="window.location.href='intercambiarLibro.php?id={$libro["idlibro"]}'">Intercambiar</button>
            </div>
            EOS;
        }
    } else {
        $acciones = '<p>No puedes intercambiar un libro si no has iniciado sesión</p>';
    }

    $contenidoPrincipal = <<<EOS
    <div class="body-verLibro">
        <div class="libro-container">
            <div class="libro">
                <img src="{$libro["imagen"]}" alt="{$libro["titulo"]}">
                <h1>{$libro["titulo"]}</h1>
                <p><strong>Autor:</strong> {$libro["autor"]}</p>
                <p><strong>Propietario:</strong> {$libro["nombre"]}</p>
                <p>{$libro["descripcion"]}</p>
                <div class="generos">
                    <span> Género: {$libro["genero"]}</span>
                    <span> Editorial: {$libro["editorial"]}</span>
                    <span> Estado: {$libro["estado"]}</span>
                    <span> Idioma: {$libro["idioma"]}</span>
                </div>
                $acciones
            </div>
        </div>
    </div>
    EOS;
} else {
    $contenidoPrincipal = '<p>Libro no encontrado.</p>';
}

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
?>