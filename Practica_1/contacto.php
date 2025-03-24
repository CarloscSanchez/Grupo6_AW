<?php
require __DIR__.'/includes/config.php';
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <link rel="icon" href="img/logo_icono.ico" type="image/x-icon">
    <link rel="stylesheet" href="CSS/estilos.css"> <!-- Archivo CSS externo -->
    <title>Contacto</title>
  </head>
  <body>

        <!-- Incluir el archivo navbar.php -->
    <?php include 'includes/vistas/comun/navbar.php'; ?>

    <!--Formulario para rellenar que se envia a un correo-->
    <form action="mailto:ismaluca@ucm.es" method="post" enctype="text/plain">
      
      <!--Campo en el que se introduce el nombre-->
      <h3>Nombre: 
      <input type="text" name="Nombre" size="20"> </h3>

      <!--Campo en el que se introduce el correo-->
      <h3>Correo: 
      <input type="email" name="Email" size="20"> </h3>

      <!--Radio buttons para seleccionar entre tres opciones-->
      <h3>Motivo de la consulta:</h3>
        <input type="radio" id="evaluacion" name="Motivo" value="Evaluacion">
        <label for="evaluacion">Evaluacion</label><br>
        <input type="radio" id="sugerencias" name="Motivo" value="Sugerencias">
        <label for="sugerencias">Sugerencias</label><br>
        <input type="radio" id="criticas" name="Motivo" value="Críticas">
        <label for="criticas">Críticas</label><br>

      <!--Espacio para escribir la consulta-->
      <h3>Escriba su consulta: 
        <input type="text" name="Consulta" size="50"> </h3>

      <!--Checkbox que marca si se han leído los términos y condiciones-->
      <p><input type="checkbox" name="Checkbox" id="checkbox" value="Aceptada"> 
      <label for="checkbox">Marque esta casilla para verificar que ha leído 
        nuestros términos y condiciones del servicio
      </label></p>  
      
      <!--Botón de enviar-->
      <button type="submit" id="enviar">ENVIAR</button>

    </form>

  </body>
</html>
