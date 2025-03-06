<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <link rel="icon" href="img/logo_icono.ico" type="image/x-icon">
    <link rel="stylesheet" href="CSS/estilos.css"> <!-- Archivo CSS externo -->
    <title>BookSwap</title>
</head>
<body>
    <!-- Incluir la barra de navegación -->
    <?php include 'includes/vistas/comun/navBar.php'; ?>

    <div class="hero">
        <h1>BookSwap - Comparte y descubre libros cerca de ti</h1>
        <p>
            Intercambia libros físicos de forma fácil y gratuita. Busca títulos en tu área,
            contacta con otros lectores y da una nueva vida a tus historias favoritas.
            ¡Únete a nuestra comunidad y empieza a compartir lectura hoy mismo!
        </p>
    </div>

    <div class="cta">
            <h2>Explora Nuestro Catálogo </h2>
            <p>Descubre cientos de libros en diferentes géneros y encuentra tu próxima lectura favorita.</p>
            <button onclick="window.location.href='catalogo.php'">Ver Catálogo</button>
    </div>

</body>
</html>