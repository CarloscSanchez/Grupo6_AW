<?php
// Incluir la configuración de la base de datos
include 'config.php';

require __DIR__.'/includes/config.php';


// Crear la conexión
$conn = new mysqli(BD_HOST, BD_USER, BD_PASS, BD_NAME);

// Verificar la conexión
if ($conn->connect_errno) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $nombre = $_SESSION['usuario'];

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
    $stmt = $conn->prepare("DELETE FROM libros WHERE idLibro = ?");
    if (!$stmt) {
        die("Error en la preparación del borrado: " . $conn->error);
    }
    $stmt->bind_param("s", $id);


    if ($stmt->execute()) {
        echo "Borrado exitoso. <a href='login.php'>Inicia sesión</a>";
    } else {
        echo "Error al borrar. Detalles: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    
    header("Location: perfil.php");
    exit();
} else{
    die("Error: No se ha proporcionado un ID de libro.");
}

?>
