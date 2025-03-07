<?php
// Incluir la configuración de la base de datos
include 'config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
    $nombre = $_SESSION['usuario'];

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
    
    // Verificar si el libro ya existe
    $check = $conn->prepare("SELECT titulo FROM usuarios LEFT JOIN libros ON usuarios.idusuario = libros.idpropietario WHERE usuarios.idusuario = ? AND libros.titulo = ? AND libros.autor = ? AND libros.editorial = ?");
    if (!$check) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    $check->bind_param("isss", $idUsuario, $titulo, $autor, $editorial);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $check->close();                
        header("Location: subirLibro.php?error=1");
        exit();
    }
    $check->close();


    // Preparar la consulta para insertar el nuevo libro
    $stmt = $conn->prepare("INSERT INTO libros (titulo, autor, genero, editorial, idioma, estado, descripcion, imagen, idpropietario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    $stmt->bind_param("ssssssssi", $titulo, $autor, $genero, $editorial, $idioma, $estado, $descripcion, $ruta_imagen, $idUsuario);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: perfil.php");
        exit();
    } else {
        die("Error al subir el libro. Detalles: " . $stmt->error);
    }

 
} else {
    echo "Método de solicitud no válido.";
}

?>
