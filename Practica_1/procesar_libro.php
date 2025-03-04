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
    $titulo = htmlspecialchars(trim($_POST['titulo']));    // Sanitizar el nombre de usuario
    $autor = htmlspecialchars(trim($_POST['autor']));      // Sanitizar el correo
    $genero = htmlspecialchars(trim($_POST['genero']));  
    $editorial = htmlspecialchars(trim($_POST['editorial']));

    $estado = isset($_POST['estado']) ? htmlspecialchars(trim($_POST['estado'])) : null;
    $idioma = isset($_POST['idioma']) ? htmlspecialchars(trim($_POST['idioma'])) : null;
    $descripcion = isset($_POST['descripcion']) ? htmlspecialchars(trim($_POST['descripcion'])) : null;
    

    $nombre = $_SESSION['usuario'];

    
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


    // Insertar el nuevo libro
    $stmt = $conn->prepare("INSERT INTO libros (titulo, autor, genero, editorial, idioma, estado, descripcion, idpropietario ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    $stmt->bind_param("sssssssi", $titulo, $autor, $genero, $editorial, $idioma, $estado, $descripcion, $idUsuario);


    if ($stmt->execute()) {
        echo "Registro exitoso. <a href='login.php'>Inicia sesión</a>";
    } else {
        echo "Error al registrar. Por favor, intenta nuevamente. Detalles: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Método de solicitud no válido.";
}

header("Location: index.php");
?>
