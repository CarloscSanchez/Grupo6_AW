<?php

require __DIR__.'/../../config.php';


use \includes\clases\intercambios\intercambio as Intercambio;

$idintercambio = $_GET["id"] ?? null;
$estado = $_GET["estado"] ?? null;

if ($idintercambio) {

    
    Intercambio::cambiarEstadoIntercambio($idintercambio, $estado);
    
    header("Location: ../../../perfil.php");
    exit();
} else{
    die("Error: No se ha proporcionado un ID de libro o intercambio.");
}

?>
