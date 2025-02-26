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
    
    <?php include 'inlcudes/vistas/comun/navBar.php'; ?>

    <h1>BookSwap - Comparte y descubre libros cerca de ti</h1>

    <p>
        Intercambia libros físicos de forma fácil y gratuita. Busca títulos en tu área,
        contacta con otros lectores y da una nueva vida a tus historias favoritas.
        ¡Únete a nuestra comunidad y empieza a compartir lectura hoy mismo!
    </p>

    <!-- Imagen del logo de la aplicación -->
    <img src="img/logo5_AW.jpg" alt="Logo aplicación" width="350" height="350" style="border-radius: 35%;">

</body>
</html>