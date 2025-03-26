<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/clases/productos/Filtro.php';
require_once __DIR__ . '/includes/clases/usuarios/Usuario.php';

$tituloPagina = 'Catálogo de Libros';

// Instanciar el formulario de filtros
$filtro = new Filtro();
$htmlFiltro = $filtro->gestiona($_GET); // Pasar los datos enviados por el formulario

// Obtener los libros filtrados
$libros = $filtro->procesaFiltro();

// Generar el contenido principal
$contenidoPrincipal = <<<EOS
<div class="catalogo-contenedor">
    <aside class="filtros">
        <h2>Buscar y Filtrar</h2>
        $htmlFiltro 
    </aside>
    <div class="catalogo-body">
        <h1>Catálogo de Libros</h1>
        <div class="catalogo">
EOS;

// Mostrar cada libro en una tarjeta
foreach ($libros as $libro) {
    $contenidoPrincipal .= <<<EOS
    
        <div class="card" onclick="window.location.href='verLibro.php?id={$libro['idlibro']}'">
            <img src="{$libro['imagen']}" alt="{$libro['titulo']}">
            <h2>{$libro['titulo']}</h2>
            <p><strong>Autor:</strong> {$libro['autor']}</p>
            <p>{$libro['descripcion']}</p>
            <p><strong>Propietario:</strong> {$libro['nombre']}</p>
            <div class="generos">
                <span>{$libro['genero']}</span>
            </div>
        </div>
EOS;
}

$contenidoPrincipal .= <<<EOS
        </div>
    </div>
</div>
EOS;

require __DIR__ . '/includes/vistas/plantillas/plantilla.php';