<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/clases/productos/Libro.php';
require_once __DIR__.'/includes/clases/usuarios/Usuario.php';

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
                        <p>No hay intercambios recibidos.</p>
                    </div>
                </div>

                <div class='tab-content' id='content3'>
                    <div class='intercambios'>
                        <p>No hay intercambios enviados.</p>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
?>