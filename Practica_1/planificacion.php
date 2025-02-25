<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="img/logo_icono.ico" type="image/x-icon">
    <link rel="stylesheet" href="CSS/estilos.css"> <!-- Archivo CSS externo -->
    <title>Planificación del proyecto</title>
</head>
<body>

<header>
    <h1>Planificación del proyecto de Aplicaciones Web</h1>
    <p>Plan de desarrollo del proyecto con fechas y distribución de tareas</p>
</header>

<?php include 'inlcudes/vistas/comun/navbar.php'; ?>

<!-- Texto de introducción -->
<section class="descripción">
    <h2>Introducción</h2>
    <p>Este documento describe la planificación orientativa del proyecto de aplicación web,
        con el objetivo de organizar y gestionar las tareas durante su desarrollo. A continuación se detallan las tareas por realizar, 
        el reparto del trabajo, los plazos para cada entrega, y los hitos del proyecto. 
        Se utilizarán varias fases de desarrollo con fechas de entrega para estructurar el proceso de construcción de la web.
    </p>
</section>

<!-- Explicación de la distribución del trabajo -->
<section class="trabajo">
    <h2>Distribución del Trabajo con GitHub usando Issues y Planificación de Proyecto</h2>
    <p>Para organizar el desarrollo del proyecto, utilizaremos <strong>GitHub</strong> mediante la creación de <em>issues</em> y la
       <em>planificación de proyectos</em>.</p>
</section>

<!-- Descripción de las tareas -->
<section class="tareas">
    <h2>Descripción de las tareas</h2>

    <h3>Entrega 1</h3>
    <ul>
        <li><strong>index.php</strong></li>
        <li><strong>detalles.php</strong></li>
        <li><strong>miembros.php</strong></li>
        <li><strong>bocetos.php</strong></li>
        <li><strong>contacto.php</strong></li>
        <li><strong>planificacion.php</strong></li>
    </ul>

    <h3>Entrega 2</h3>
    <p>Próximamente...</p>

    <h3>Entrega 3</h3>
    <p>Próximamente...</p>

    <h3>Entrega Final</h3>
    <p>Constará de la entrega de todo el trabajo desarrollado.</p>
</section>

<!-- Tabla de los hitos con las fechas de entrega -->
<section class="tiempos">
    <h2>Hitos y fechas de entrega</h2>
    <table>
        <thead>
            <tr>
                <th>Hito</th>
                <th>Fecha de Entrega</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Entrega 1</td>
                <td>14 de febrero de 2025</td>
            </tr>
            <tr>
                <td>Entrega 2</td>
                <td>7 de marzo de 2025</td>
            </tr>
            <tr>
                <td>Entrega 3</td>
                <td>28 de marzo de 2025</td>
            </tr>
            <tr>
                <td>Entrega Final</td>
                <td>9 de mayo de 2025</td>
            </tr>
        </tbody>
    </table>
</section>

<!-- Diagrama de Gantt -->
<section class="gantt">
    <h2>Diagrama de Gantt</h2>
    <img src="img/gantt.jpg" alt="diagrama de gantt" width="1050" height="425">
</section>

</body>
</html>
