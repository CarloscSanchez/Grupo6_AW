<?php
// Incluir la configuración de la base de datos
require __DIR__.'/includes/config.php';


// Crear la conexión
$conn = new mysqli(BD_HOST, BD_USER, BD_PASS, BD_NAME);

// Verificar la conexión
if ($conn->connect_errno) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $titulo = htmlspecialchars(trim($_POST['titulo']));    // Sanitizar el título
    $autor = htmlspecialchars(trim($_POST['autor']));      // Sanitizar el autor
    $genero = htmlspecialchars(trim($_POST['genero']));     // Sanitizar el género
    $editorial = htmlspecialchars(trim($_POST['editorial']));  // Sanitizar la editorial
    $estado = isset($_POST['estado']) ? htmlspecialchars(trim($_POST['estado'])) : null;  // Sanitizar el estado
    $idioma = isset($_POST['idioma']) ? htmlspecialchars(trim($_POST['idioma'])) : null;  // Sanitizar el idioma
    $descripcion = isset($_POST['descripcion']) ? htmlspecialchars(trim($_POST['descripcion'])) : null;  // Sanitizar la descripción
    
    // Obtener el nombre de usuario que tiene la sesión iniciada
    $nombre = $_SESSION['nombre'];

    if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0){
        $nombre_imagen = basename($_FILES['foto']['name']);
        $ruta_imagen = 'img/' . $nombre_imagen;
        move_uploaded_file($_FILES['foto']['tmp_name'], $ruta_imagen);
    }
    else
        $ruta_imagen = NULL;

    // Verificar si el usuario existe
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


    // Verificar que el libro pertenece al usuario antes de editarlo
    $checkLibro = $conn->prepare("SELECT idLibro FROM libros WHERE idLibro = ? AND idpropietario = ?");
    if (!$checkLibro) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    // Obtener el id del libro que se va a editar
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $checkLibro->bind_param("ii", $id , $idUsuario);
    $checkLibro->execute();
    $checkLibro->store_result();

    if ($checkLibro->num_rows === 0) {
        die("Error: No tienes permiso para editar este libro.");
    }

    $checkLibro->close();

    // Preparar la consulta para actualizar el libro
    $stmt = $conn->prepare("UPDATE libros SET titulo = ?, autor = ?, genero = ?, editorial = ?, idioma = ?, descripcion = ?, estado = ? WHERE idLibro = $id");
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    $stmt->bind_param("sssssss", $titulo, $autor, $genero, $editorial, $idioma, $estado, $descripcion);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        header("Location: verLibro.php?id=" . $id);
        exit();
    } else {
        die("Error al actualizar el libro. Detalles: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Método de solicitud no válido.";
}

?>