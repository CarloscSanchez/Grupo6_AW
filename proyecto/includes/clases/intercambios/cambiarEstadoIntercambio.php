<?php

require __DIR__.'/../../config.php';


use \includes\clases\intercambios\intercambio as Intercambio;
use \includes\clases\usuarios\usuario as Usuario;

$idintercambio = $_GET["id"] ?? null;
$estado = $_GET["estado"] ?? null;

$usuario = Usuario::buscaUsuario($_SESSION['nombre']);
$idUsuario = $usuario->getId();

if ($idintercambio) {

    // Comprobación de que el usuario es el solicitante o el solicitado del intercambio
    $interc = Intercambio::buscaPorId($idintercambio);
    if ($idUsuario != $interc->getIdSolicitante() && $idUsuario != $interc->getIdPropietario()) {
        header("Location: index.php");
        exit();
    }

    Intercambio::cambiarEstadoIntercambio($idintercambio, $estado);
    
    header("Location: ../../../perfil.php");
    exit();
} else{
    die("Error: No se ha proporcionado un ID de libro o intercambio.");
}

?>
