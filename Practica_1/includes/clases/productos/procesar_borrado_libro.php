<?php
// Incluir la configuración de la base de datos
include 'config.php';

require __DIR__.'/includes/config.php';

use \includes\clases\productos\libro as Libro;
use \includes\clases\productos\usuario as Usuario;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $nombre = $_SESSION['nombre'];

    $libro = Libro::buscaPorId($id);
    $usuario = Usuario::buscaUsuario($nombre);

    // Verificar que el libro pertenece al usuario antes de eliminarlo
    $checkPropietario = Libro::verificaPropietario($id, $checkusuario->getId());

    if ($checkPropietario === 0) {
        die("Error: No tienes permiso para eliminar este libro.");
    }

    // Borrar el libro
    $libro->borra();
    
    header("Location: perfil.php");
    exit();
} else{
    die("Error: No se ha proporcionado un ID de libro.");
}

?>
