<?php

require __DIR__.'/../../config.php';


use \includes\clases\productos\libro as Libro;
use \includes\clases\usuarios\usuario as Usuario;

$id_libro = $_GET["id"] ?? null;

if ($id_libro) {
    $nombre = $_SESSION['nombre'];

    $libro = Libro::buscaPorId($id_libro);
    $usuario = Usuario::buscaUsuario($nombre);

    // Verificar que el libro pertenece al usuario antes de eliminarlo
    $checkPropietario = Libro::verificaPropietario($id_libro, $usuario->getId());

    if ($checkPropietario === 0) {
        die("Error: No tienes permiso para eliminar este libro.");
    }

    // Borrar el libro
    Libro::borra($id_libro);
    
    header("Location: ../../../perfil.php");
    exit();
} else{
    die("Error: No se ha proporcionado un ID de libro.");
}

?>
