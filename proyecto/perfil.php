<?php
require_once __DIR__.'/includes/config.php';

use \includes\clases\productos\libro as Libro;
use \includes\clases\usuarios\usuario as Usuario;
use \includes\clases\intercambios\intercambio as Intercambio;

// Si es admin no le deja acceder
if (isset($_SESSION['esAdmin']) && $_SESSION['esAdmin'] === true) {
    header("Location: admin.php");
    exit();
}

// Buscar el ID del usuario
$usuario = Usuario::buscaUsuario($_SESSION['nombre']);

// Si no se encuentra el usuario, redirigir a la página de inicio
if (!$usuario) {
    header("Location: index.php");
    exit();
}

$nombreUsuario = $usuario->getNombre();

// Cargar los libros del usuario
$libros_publicados = Libro::cargaLibrosUsuario($usuario->getId());

$tituloPagina = 'Perfil de Usuario - BookSwap';

$contenidoPrincipal = <<<EOS
<div class='perfil-body'>
    <div class='perfil-container'>

        <!-- Foto de perfil y botón para cambiarla -->
        <div class='foto-perfil'>
            <img src='img/logo5_AW.jpg' alt='Foto de perfil'>
            <p class='nombre-usuario'>$nombreUsuario</p>
            <button>Cambiar foto de perfil</button>
        </div>

        <!-- Información del usuario -->
        <div class='contenido'>
            <h2>Mi perfil</h2>

            <div class='perfil-tabs'>
                <input type='radio' name='tab' id='tab1' checked>
                <label for='tab1'>Mis libros</label>

                <input type='radio' name='tab' id='tab2'>
                <label for='tab2'>Intercambios recibidos</label>

                <input type='radio' name='tab' id='tab3'>
                <label for='tab3'>Intercambios enviados</label>

                <input type='radio' name='tab' id='tab4'>
                <label for='tab4'>Historial de intercambios</label>

                <div class='tab-content' id='content1'>
                    <div class='libros-publicados'>
EOS;

foreach ($libros_publicados as $libro) {
    $contenidoPrincipal .= <<<EOS
        <div class="card" onclick="window.location.href='verLibro.php?id={$libro['idlibro']}'">
            <img src="{$libro['imagen']}" alt="{$libro['titulo']}">
            <h3>{$libro['titulo']}</h3>
            <p>Autor: {$libro['autor']}</p>
            <div class="generos">
                <span>{$libro['genero']}</span>
            </div>
        </div>
EOS;
}

$contenidoPrincipal .= <<<EOS
                    </div>
                    <button class='btn-subir-libro' onclick="window.location.href='subirLibro.php'">Subir Libro</button>
                </div>

                <div class='tab-content' id='content2'>
                    <div class='intercambios'>
EOS;

$intercambios_recibidos = Intercambio::buscaIntercambiosRecibidos($usuario->getId());

if ($intercambios_recibidos) {
    foreach ($intercambios_recibidos as $intercambio) {
        $libro = Libro::buscaPorId($intercambio->getIdLibroSolicitado());
        $usuarioSolicitante = Usuario::buscaPorId($intercambio->getIdSolicitante());

        $estado = $intercambio->getEstado();
        $id = $intercambio->getId();

        if ($estado === 'aceptado') {
            $href = "completarIntercambio.php?id={$id}";
        } elseif ($estado === 'pendiente') {
            $href = "intercambiarLibro.php?id={$id}";
        } else {
            $href = "verIntercambio.php?id={$id}";
        }

                
        $contenidoPrincipal .= <<<EOS
            <div class="card" onclick="window.location.href='{$href}'">
                <img src="{$libro->getImagen()}" alt="{$libro->getTitulo()}">
                <h3>{$libro->getTitulo()}</h3>
                <p>Autor: {$libro->getAutor()}</p>
                <p>Solicitante: {$usuarioSolicitante->getNombre()}</p>
                <p>Estado: {$intercambio->getEstado()}</p>
                <div class="generos">
                    <span>{$libro->getGenero()}</span>
                </div>
            </div>
EOS;
    }
} else {
    $contenidoPrincipal .= <<<EOS
        <p>No hay intercambios recibidos.</p>
EOS;
}


$contenidoPrincipal .= <<<EOS
                    </div>
                </div>

                <div class='tab-content' id='content3'>
                    <div class='intercambios'>
EOS;


$intercambios_enviados = Intercambio::buscaIntercambiosSolicitados($usuario->getId());

if ($intercambios_enviados) {
    foreach ($intercambios_enviados as $intercambio) {
        $libro = Libro::buscaPorId($intercambio->getIdLibroSolicitado());
        $usuarioPropietario = Usuario::buscaPorId($intercambio->getIdPropietario());

        $estado = $intercambio->getEstado();
        $id = $intercambio->getId();

        if ($estado === 'aceptado') {
            $href = "completarIntercambio.php?id={$id}";
        } elseif ($estado === 'pendiente') {
            $href = "intercambiarLibro.php?id={$id}";
        } else {
            $href = "verIntercambio.php?id={$id}";
        }


        $contenidoPrincipal .= <<<EOS
            <div class="card" onclick="window.location.href='{$href}'">
                <img src="{$libro->getImagen()}" alt="{$libro->getTitulo()}">
                <h3>{$libro->getTitulo()}</h3>
                <p>Autor: {$libro->getAutor()}</p>
                <p>Propietario: {$usuarioPropietario->getNombre()}</p>
                <p>Estado: {$intercambio->getEstado()}</p>
                <div class="generos">
                    <span>{$libro->getGenero()}</span>
                </div>
            </div>
EOS;
    }
} else {
    $contenidoPrincipal .= <<<EOS
        <p>No hay intercambios recibidos.</p>
EOS;
}

$historial_intercambios = Intercambio::buscaHistorialIntercambios($usuario->getId());


$contenidoPrincipal .= <<<EOS
                    </div>
                </div>

                <div class='tab-content' id='content4'>
                    <div class='intercambios'>
EOS;

if ($historial_intercambios) {
    foreach ($historial_intercambios as $intercambio) {
        $libro = Libro::buscaPorId($intercambio->getIdLibroSolicitado());
        $id = $intercambio->getId();
        $estado = $intercambio->getEstado();
        $usuarioOtro = ($intercambio->getIdSolicitante() === $usuario->getId())
            ? Usuario::buscaPorId($intercambio->getIdPropietario())
            : Usuario::buscaPorId($intercambio->getIdSolicitante());

        if ($estado === 'aceptado') {
            $href = "completarIntercambio.php?id={$id}";
        } elseif ($estado === 'pendiente') {
            $href = "intercambiarLibro.php?id={$id}";
        } else {
            $href = "verIntercambio.php?id={$id}";
        }
    

        $contenidoPrincipal .= <<<EOS
            <div class="card" onclick="window.location.href='{$href}'">
                <img src="{$libro->getImagen()}" alt="{$libro->getTitulo()}">
                <h3>{$libro->getTitulo()}</h3>
                <p>Intercambiado con: {$usuarioOtro->getNombre()}</p>
                <p>Estado: {$intercambio->getEstado()}</p>
                <p>Fecha: {$intercambio->getFechaIntercambio()}</p>
            </div>
EOS;
    }
} else {
    $contenidoPrincipal .= <<<EOS
        <p>No hay intercambios completados.</p>
EOS;
}


$contenidoPrincipal .= <<<EOS
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
?>
