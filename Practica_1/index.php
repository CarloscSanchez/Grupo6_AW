

<?php
//Inicio del procesamiento
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'BookSwap';

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
</div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
