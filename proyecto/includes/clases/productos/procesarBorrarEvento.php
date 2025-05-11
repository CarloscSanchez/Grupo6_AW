<?php
require_once __DIR__ . '/../../config.php';

use includes\clases\productos\evento;

$idEvento = $_GET['id'] ?? null;

if ($idEvento) {
    // Intentar borrar el evento
    if (Evento::borra($idEvento)) {
        header("Location: ../../../perfil.php");
        exit();
    } else {
        die("Error: No se pudo eliminar el evento. Inténtalo de nuevo.");
    }
} else {
    die("Error: No se ha proporcionado un ID de evento.");
}