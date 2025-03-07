<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir la configuración de la base de datos
include 'config.php';

// Crear la conexión
$conn = new mysqli(BD_HOST, BD_USER, BD_PASS, BD_NAME);

// Verificar la conexión
if ($conn->connect_errno) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

$id_libro = $_GET["id"] ?? null;
$libro = null;

// Consulta para obtener el libro
if ($id_libro) {
    $stmt = $conn->prepare("SELECT * FROM libros LEFT JOIN usuarios ON usuarios.idusuario = libros.idpropietario  WHERE idlibro = ?");
    $stmt->bind_param("i", $id_libro);
    $stmt->execute();
    $libro = $stmt->get_result()->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Libro - BookSwap</title>
    <link rel="stylesheet" href="CSS/estilos.css"> <!-- Archivo CSS externo -->
    <link rel="icon" href="img/logo_icono.ico" type="image/x-icon">
</head>
<body>
    <div class="body-verLibro">
        <div class="libro-container">
            <?php

            // Verificar si se ha encontrado el libro
            if ($libro) {
                // Mostrar la información del libro
                echo ' <div class="libro">
                <img src="' . $libro["imagen"] . '" alt="' . $libro["titulo"] . '">
                <h1>' . $libro["titulo"] . '</h1>
                <p><strong>Autor:</strong> ' . $libro["autor"] . '</p>
                <p><strong>Propietario:</strong>' . $libro["nombre"] . '</p>
                <p>' . $libro["descripcion"] . '</p>
                <div class="generos">';
                echo '<span> Género: ' . $libro["genero"] . '</span>'
                . '<span> Editorial: ' . $libro["editorial"] . '</span>'
                . '<span> Estado: ' . $libro["estado"] . '</span>'
                . '<span> Idioma: ' . $libro["idioma"] . '</span>';


                // Mostrar las distintas acciones según el usuario que esté viendo el libro
                if(isset($_SESSION['usuario'])){
                    if($libro["nombre"] == $_SESSION['usuario']){
                        echo '</div>
                        <div class="acciones">
                            <button class="editar" onclick="window.location.href=\'editarLibro.php?id=' . $libro["idlibro"] . '\'">Editar</button>
                            <button class="borrar" onclick="window.location.href=\'procesar_borrado_libro.php?id=' . $libro["idlibro"] . '\'">Borrar</button>
                        </div>';
                    } else {
                        echo '</div>
                        <div class="acciones">
                            <button class="intercambiar" onclick="window.location.href=\'intercambiarLibro.php?id=' . $libro["idlibro"] . '\'">Intercambiar</button>
                        </div>';
                    }
                } else {
                    echo '<p>No puedes intercambiar un libro si no has iniciado sesión</p>';
                }
                
            } else {
                echo '<p>Libro no encontrado.</p>';
            }

            ?>
        </div>
    </div>
</body>
</html>