<?php

require __DIR__.'/../../config.php';

use \includes\clases\usuarios\usuario as Usuario;

$nuevoNombre = $_GET['user'] ?? null;
$usuario = Usuario::buscaUsuario($nuevoNombre);

$user = $_SESSION['nombre'] ?? null;
// si el usuario existe, pero es diferente al que está logueado, entonces no se puede usar el mismo nombre de usuario

if ($usuario) {
    // Comprobar si el usuario existe y es diferente al que está logueado
    if ($usuario->getNombre() == $user) {
        echo "disponible";
    } else {
        echo "existe";
    }
}
else {
    echo "disponible";
}

?>