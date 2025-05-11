<?php
//Inicio del procesamiento
require_once __DIR__.'/includes/config.php';

use \includes\clases\productos\evento as Evento;
$tituloPagina = 'BookSwap';

// Obtener los próximos eventos desde la base de datos
$eventos = Evento::getEventos();
$eventosHtml = '';

if ($eventos) {
    foreach ($eventos as $evento) {
        $eventosHtml .= <<<EOS
        <div class="evento">
            <h3>{$evento->getNombre()}</h3>
            <p><strong>Fecha:</strong> {$evento->getFecha()}</p>
            <p><strong>Hora:</strong> {$evento->getHora()}</p>
            <p><strong>Lugar:</strong> {$evento->getLugar()}</p>
            <p><strong>Género:</strong> {$evento->getGenero()}</p>
        </div>
        EOS;
    }
} else {
    $eventosHtml = '<p>No hay eventos próximos.</p>';
}

$contenidoPrincipal = <<<EOS
<div class="hero">
        <h1>BookSwap - Comparte y descubre libros cerca de ti</h1>
        <p>
            Intercambia libros físicos de forma fácil y gratuita. Busca títulos en tu área,
            contacta con otros lectores y da una nueva vida a tus historias favoritas.
            ¡Únete a nuestra comunidad y empieza a compartir lectura hoy mismo!
        </p>

    <div class="cta">
            <h2>Explora Nuestro Catálogo </h2>
            <p>Descubre cientos de libros en diferentes géneros y encuentra tu próxima lectura favorita.</p>
            <button onclick="window.location.href='catalogo.php'">Ver Catálogo</button>
    </div>

    <div class="proximos-eventos">
        <h2>Próximos Eventos</h2>
        <div class="carousel">
            $eventosHtml
        </div>
    </div>

</div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';