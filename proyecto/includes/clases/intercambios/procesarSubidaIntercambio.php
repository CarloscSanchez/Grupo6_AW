<?php

require __DIR__.'/../../config.php';


use \includes\clases\productos\libro as Libro;
use \includes\clases\intercambios\intercambio as Intercambio;
use \includes\clases\usuarios\usuario as Usuario;

$id_libro = $_GET["id"] ?? null;

if ($id_libro) {
    $libro = Libro::buscaPorId($id_libro);
    $nombre = $_SESSION['nombre'];
    $usuario = Usuario::buscaUsuario($nombre);

    $intercambio = Intercambio::crea($libro->getId(),$usuario->getId(),$libro->getIdPropietario());
       

    
    header("Location: ../../../perfil.php");
    exit();
} else{
    die("Error: No se ha proporcionado un ID de libro.");
}

?>
