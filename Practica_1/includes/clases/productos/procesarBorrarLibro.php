<?php

namespace includes\clases\productos;

require __DIR__.'/includes/config.php';

use \includes\aplicacion as Aplicacion;

// Crear la conexión
$app = Aplicacion::getInstance();
$conn = $app->getConexionBD();

// Verificar la conexión
if ($conn->connect_errno) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $nombre = $_SESSION['nombre'];

    $check = $conn->prepare("SELECT idusuario FROM usuarios WHERE nombre = ?");
    if (!$check) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    $check->bind_param("s", $nombre);
    $check->execute();
    $check->store_result();
    $check->bind_result($idUsuario); 
    $check->fetch();    
    $check->close();

    // Verificar que el libro pertenece al usuario antes de eliminarlo
    $checkLibro = $conn->prepare("SELECT idLibro FROM libros WHERE idLibro = ? AND idpropietario = ?");
    if (!$checkLibro) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $checkLibro->bind_param("ii", $id , $idUsuario);
    $checkLibro->execute();
    $checkLibro->store_result();

    if ($checkLibro->num_rows === 0) {
        die("Error: No tienes permiso para eliminar este libro.");
    }

    $checkLibro->close();

    // Borrar el libro
    $libro->borra($id);

    
    header("Location: perfil.php");
    exit();
} else{
    die("Error: No se ha proporcionado un ID de libro.");
}

?>
