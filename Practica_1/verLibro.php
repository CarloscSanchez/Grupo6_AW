<?php
require __DIR__.'/includes/config.php';

use \includes\clases\productos\libro as Libro;
use \includes\clases\usuarios\usuario as Usuario;

$id_libro = $_GET["id"] ?? null;

$libro = Libro::buscaPorId($id_libro);

if (!$libro) {
    header("Location: index.php");
    exit();
}

$usuario = Usuario::buscaPorId($libro->getIdPropietario());

$tituloPagina = 'Ver Libro - BookSwap';

if ($libro) {
    $acciones = '';
    if (isset($_SESSION['nombre'])) {
        if ($usuario->getNombre() == $_SESSION['nombre']) {
            $acciones = <<<EOS
            <div class="acciones">
                <button class="editar" onclick="window.location.href='editarLibro.php?id={$libro->getId()}'">Editar</button>
                <button class="borrar" onclick="window.location.href='procesarBorrarLibro.php?id={$libro->getId()}'">Borrar</button>
            </div>
            EOS;
        } else {
            $acciones = <<<EOS
            <div class="acciones">
                <button class="intercambiar" onclick="window.location.href='intercambiarLibro.php?id={$libro->getId()}'">Intercambiar</button>
            </div>
            EOS;
        }
    } else {
        $acciones = '<p>No puedes intercambiar un libro si no has iniciado sesión</p>';
    }
    
    $contenidoPrincipal = <<<EOS
    <div class="body-verLibro">
        <div class="libro-container">
            <div class="libro">
                <img src="{$libro->getImagen()}" alt="{$libro->getTitulo()}">
                <h1>{$libro->getTitulo()}</h1>
                <p><strong>Autor:</strong> {$libro->getAutor()}</p>
                <p><strong>Propietario:</strong> {$usuario->getNombre()}</p>
                <p>{$libro->getDescripcion()}</p>
                <div class="generos">
                    <span> Género: {$libro->getGenero()}</span>
                    <span> Editorial: {$libro->getEditorial()}</span>
                    <span> Estado: {$libro->getEstado()}</span>
                    <span> Idioma: {$libro->getIdioma()}</span>
                </div>
                $acciones
            </div>
        </div>
    </div>
    EOS;
} else {
    $contenidoPrincipal = '<p>Libro no encontrado.</p>';
}

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
?>
