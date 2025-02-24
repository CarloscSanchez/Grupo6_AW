<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$usuarios_validos = [
    "user" => ["password" => "userpass", "nombre" => "Usuario"],
    "admin" => ["password" => "adminpass", "nombre" => "Administrador", "esAdmin" => true]
];

// Obtener los datos del formulario
$username = isset($_POST['usuario']) ? trim($_POST['usuario']) : "";
$password = isset($_POST['password']) ? trim($_POST['password']) : "";


// Verificar si el usuario es válido
if (array_key_exists($username, $usuarios_validos) && $usuarios_validos[$username]['password'] === $password) {
    // Iniciar sesión con los datos del usuario
    $_SESSION['login'] = true;
    $_SESSION['usuario'] = $usuarios_validos[$username]['nombre'];

    // Si es administrador, agregar variable adicional
    if (isset($usuarios_validos[$username]['esAdmin'])) {
        $_SESSION['esAdmin'] = true;
    }

    // Redirigir a la página principal con sesión iniciada     
    header("Location: index.php");
    exit();
} else {
    // Redirigir a login.php con mensaje de error
    header("Location: login.php?error=1");
    exit();
}

?>
