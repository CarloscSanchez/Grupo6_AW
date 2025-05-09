<?php
require __DIR__.'/includes/config.php';
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <link rel="icon" href="img/logo_icono.ico" type="image/x-icon">  <!-- Link para cambiar el icono de favicon-->
    <link rel="stylesheet" href="CSS/estilos.css"> <!-- Archivo CSS externo -->
    <title>Miembros</title>
  </head>

  <?php include 'includes/vistas/comun/navbar.php'; ?>

    <h1>¿Quiénes somos?</h1>
    <p>Aquí puedes conocer a los miembros de nuestro equipo.</p>

    <h2>Listado de Miembros</h2>
    <ul>  <!-- Lista donde están las referencias a los integrantes del grupo-->
      <li><a href="#carlos">Carlos Clemente</a></li>
      <li><a href="#alvaro">Álvaro Moreno</a></li>
      <li><a href="#pablo">Pablo Fernández</a></li>
      <li><a href="#ismael">Ismael Lucas</a></li>
    </ul>

    <div id="carlos"><!--A continuación todos los miembros, sus fotos y sus intereses-->
      <h3>Carlos Clemente Sánchez</h3>
      <img src="img/carlos.jpg" alt="Foto Carlos" width="300" height="250">
      <p><strong>Correo:</strong> carlocle@ucm.es </p>
      <p>Apasionado de la tecnología y los videojuegos. Me encanta leer ciencia ficción y aprender sobre inteligencia artificial.</p>
    </div>
    <br>
    <div id="alvaro">
      <h3>Álvaro Moreno Arribas</h3>
      <img src="img/alvaro.jpg" alt="Foto de Álvaro" width="300" height="410">
      <p><strong>Correo:</strong> alvamo14@ucm.es </p>
      <p>Amante del cine y de la música. Me gusta programar y crear pequeñas aplicaciones en mi tiempo libre.</p>
    </div>
    <br>
    <div id="pablo">
      <h3>Pablo Fernández Sánchez-Tembleque</h3>
      <img src="img/pablo.jpg" alt="Foto de Pablo" width="300" height="300">
      <p><strong>Correo:</strong> pablof25@ucm.es </p>
      <p>Disfruto viajar y conocer nuevas culturas. Me interesa el desarrollo web y las redes sociales.</p>
    </div>
    <br>
    <div id="ismael">
      <h3>Ismael Lucas Parada</h3>
      <img src="img/ismael.jpg" alt="Foto de Ismael" width="300" height="400">
      <p><strong>Correo:</strong> ismaluca@ucm.es </p>
      <p>Me encanta la fotografía y el diseño gráfico. Siempre estoy buscando inspiración en el arte y la naturaleza.</p>
    </div>

  </body>
</html>
