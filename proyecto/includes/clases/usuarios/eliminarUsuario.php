<?php
require __DIR__.'/../../config.php';

use \includes\clases\usuarios\usuario as Usuario;

$id_usuario = $_GET["id"] ?? null;

// Verificar si el usuario es un administrador
if (!isset($_SESSION['esAdmin']) || $_SESSION['esAdmin'] !== true) {
    header("Location: index.php");
    exit();
}
if ($id_usuario) {
    // Verificar si el usuario existe
    $usuario = Usuario::buscaPorId($id_usuario);
    if ($usuario) {
        // Eliminar el usuario
        $usuario->borrate($id_usuario);

        // Redirigir a la página de administración
        header("Location: ../../../admin.php");
        exit();
    }
}