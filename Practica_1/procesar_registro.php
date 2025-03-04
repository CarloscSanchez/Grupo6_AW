<?php
session_start(); 

// Incluir la configuración de la base de datos
include 'config.php';

// Crear la conexión
$conn = new mysqli(BD_HOST, BD_USER, BD_PASS, BD_NAME);

// Verificar la conexión
if ($conn->connect_errno) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = htmlspecialchars(trim($_POST['usuario']));    // Sanitizar el nombre de usuario
    $correo = htmlspecialchars(trim($_POST['email']));      // Sanitizar el correo
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];

    // Validaciones básicas
    if (strlen($nombre) < 3 || strlen($nombre) > 20) {
        die("El nombre de usuario debe tener entre 3 y 20 caracteres.");
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        die("Correo electrónico no válido.");
    }

    if ($password !== $repassword) {
        die("Las contraseñas no coinciden.");
    }

    if (strlen($password) < 6) {
        die("La contraseña debe tener al menos 6 caracteres.");
    }

    // Verificar si el usuario o el email ya existen
    $check = $conn->prepare("SELECT idUsuario FROM usuarios WHERE nombre = ? OR correo = ?");
    if (!$check) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    $check->bind_param("ss", $nombre, $correo);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $check->close();
        die("El nombre de usuario o el correo electrónico ya están registrados.");
    }
    $check->close();

    // Calcular el hash de la contraseña
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // Insertar el nuevo usuario
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, correo, contraseña) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    $stmt->bind_param("sss", $nombre, $correo, $passwordHash);

    if ($stmt->execute()) {
        //echo "Registro exitoso. <a href='login.php'>Inicia sesión</a>";
        $_SESSION['login'] = true;//Para que se quede iniciada la sesion al registrarse
        $_SESSION['usuario'] = $nombre;
        header("Location: index.php");
        exit();
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
