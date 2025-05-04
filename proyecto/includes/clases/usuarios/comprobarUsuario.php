<?php

require __DIR__.'/../../config.php';

use \includes\clases\usuarios\usuario as Usuario;

$user = $_GET['user'] ?? null;

$usuario = Usuario::buscaUsuario($user);

if ($usuario) {
    echo "existe";
}
else {
    echo "disponible";
}

?>