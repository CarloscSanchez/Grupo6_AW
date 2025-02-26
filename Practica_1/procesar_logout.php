<?php
// Iniciar la sesión (siempre al principio del script)
session_start();

// Eliminar las variables de sesión
if (isset($_SESSION['login'])) {
    unset($_SESSION['login']);
}
if (isset($_SESSION['nombre'])) {
    unset($_SESSION['nombre']);
}
if (isset($_SESSION['esAdmin'])) {
    unset($_SESSION['esAdmin']);
}

// Destruir la sesión
session_destroy();

// Redirigir a la página principal con sesión destruida
header("Location: index.php");
exit();
?>
