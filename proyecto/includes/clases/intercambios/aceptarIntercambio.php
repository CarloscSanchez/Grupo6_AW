<?php

require __DIR__.'/../../config.php';


use \includes\clases\intercambios\intercambio as Intercambio;

$id_libro = $_GET["id_libro"] ?? null;
$idintercambio = $_GET["id_intercambio"] ?? null;

if ($id_libro && $idintercambio) {
    $intercambio = Intercambio::buscaPorId($idintercambio);

    $intercambio->aceptarIntercambio($id_libro, $idintercambio);

    
    header("Location: ../../../perfil.php");
    exit();
} else{
    die("Error: No se ha proporcionado un ID de libro o intercambio.");
}

?>
