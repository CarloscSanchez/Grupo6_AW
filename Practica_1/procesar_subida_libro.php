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

    // Verificar si el usuario existe
    $check = $conn->prepare("SELECT idUsuario FROM usuarios WHERE nombre = ?");
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
    $check = $conn->prepare("SELECT titulo FROM usuarios LEFT JOIN libros ON usuarios.idUsuario = libros.idpropietario WHERE usuarios.idUsuario = ? AND libros.titulo = ? AND libros.autor = ? AND libros.editorial = ?");
    if (!$check) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    $check->bind_param("isss", $idUsuario, $titulo, $autor, $editorial);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $check->close();
        die("Ya tienes ese libro subido");
    }
    $check->close();


    // Preparar la consulta para insertar el nuevo libro
    $stmt = $conn->prepare("INSERT INTO libros (titulo, autor, genero, editorial, idioma, estado, descripcion, idpropietario ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    $stmt->bind_param("sssssssi", $titulo, $autor, $genero, $editorial, $idioma, $estado, $descripcion, $idUsuario);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        header("Location: perfil.php");
        exit()
    } else {
        header("Location: login.php?error=1");
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Método de solicitud no válido.";
}

header("Location: index.php");
?>
