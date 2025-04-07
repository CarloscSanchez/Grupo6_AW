<?php
require __DIR__.'/includes/config.php';

?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <link rel="icon" href="img/logo_icono.ico" type="image/x-icon">
    <link rel="stylesheet" href="CSS/estilos.css"> <!-- Archivo CSS externo -->
    <title>Bocetos</title>
  </head>
  <body>

  <?php include 'includes/vistas/comun/navbar.php'; ?>

    <div id="fotos">
      <!-- Aquí las imagenes, todas ajustadas para tener la misma anchura. Al ser la misma proporción, la altura será igual también-->
      <img src="img/vistas_1.jpg" alt="vistas 1-4" width="300" height="400">
      <img src="img/vistas_2.jpg" alt="vistas 5-8" width="300" height="400">
      <img src="img/vistas_3.jpg" alt="vista 9" width="300" height="400">
    </div>
    <div id="explicaciones">
      <!-- Aquí las explicaciones de cada vista-->
      <p>
        <strong>Vista 1</strong>: Esta corresponde a la página principal. Arriba estará la barra con el logo, el nombre con un vínculo a esta página, 
        el menú que incluirá catálogo, blog, subir libro nuevo, notificaciones y, dependiendo de si el usuario está autenticado o no, enlaces a Login/Register 
        o a su perfil (Esta barra estará en todas las vistas con la misma funcionalidad). Más abajo, incluye un deslizable que mostrará las últimas noticias 
        y publicaciones del blog, y abajo los ejemplares de libros más populares, recomendaciones especiales de la página, etc.
      </p>
      <p>
        <strong>Vista 2</strong>: Esta vista es el formulario de Login de nuestra página. Incluye la barra de menú, campos para introducir el usuario y la 
        contraseña, el botón para enviar y dos links, uno que lleva a la pestaña de registro y otro que mandará un correo al usuario con su contraseña
        en caso de que se le haya olvidado. Esta pestaña corresponde a la gestión de usuarios.
      </p>
      <p>
        <strong>Vista 3</strong>: El formulario para registrarse como usuario, incluye el menu, campos para introducir el usuario, el correo, la contraseña y 
        la contraseña repetida, el botón para enviar los datos y un link a la pestaña de login en caso de que el usuario ya tenga una cuenta. Esta pestaña 
        correspondería con la gestión de usuarios.
      </p>
      <p>
        <strong>Vista 4</strong>: Esta vista corresponde a la página de catálogo, donde se podrán ver todos los libros que han publicado los usuarios para
        intercambiar, que inlcuirán una foto del ejemoplar, el título y autor, año de publicación, géneros y el usuario que lo publicó. También habrá a la
        derecha una columna donde se podrán especificar filtros de búsqueda por género, autor, año de publicación y usuario publicante, así como un 
        portal de búsqueda para encontrar libros específicos si así se desea. Esta pestaña corresponde a la gestión de libros y filtros de búsqueda.
      </p>
      <p>
        <strong>Vista 5</strong>: Una vez clickeado uno de los productos del catálogo, aparecerá una vista más completa para el producto. Esta tendrá la barra 
        de menú, la foto del producto en grande, el título, autor, año de publicación, géneros, editorial, estado y una descripción del libro aportada por el 
        publicante. También incluirá dos botones, uno de solicitud de intercambio y otro de confirmación de intercambio: el de solicitud servirá para enviar 
        una notificación al propietario de que nos interesa el libro, y el de intercambio servirá para confirmar el trato, clickeando "intercambiar" en la 
        página del libro que nos interese del usuario que nos ha solicitado. Esta pestaña corresponde al intercambio de libros.
      </p>
      <p>
        <strong>Vista 6</strong>: Esta servirá para publicar un nuevo libro, para el cual habrá un formulario así como un campo para subir la imagen del 
        ejemplar. Esto incluirá Título, autor, año de publicación, editorial, estado del libro (desplegable de perfecto, buen estado, usado, mal estado) 
        y una descripción del ejemplar si así lo requiere. Abajo habrá un botón que mandará esta información al servidor y actualizará la base de datos de 
        los ejemplares existentes. Esta pestaña correspode a la gestión de libros y añadir/eliminar existencias.
      </p>
      <p>
        <strong>Vista 7</strong>: Esta será la pestaña principal del blog, donde los administradores podrán subir artículos y anunciar evento de interés para los 
        usuarios de la página web. Contendrá la barra de menú y una entrada por artículo, con una miniatura de la imagen con un título y un subtítulo. Estas
        entradas estarán ordenadas cronológicamente pero habrá un portal de búsqueda de artículos encima de todas las entradas. Esta pestaña corresponde a 
        la gestión de eventos, blog y artículos.
      </p>
      <p>
        <strong>Vista 8</strong>: Esta vista corresponde a lo que se verá al clickear en una de las entradas de la vista 7. La imagen será mas grande hacia 
        la derecha y tendrá el título, subtítulo y cuerpo como se muestra en la imagen. Barajamos incluir una seccion de comentarios por artículo. Como el 
        resto de vistas, también tendrá la barra de menú con todos los links correspondientes. Esta pestaña corresponde a la gestión de eventos, blog y 
        artículos.
      </p>
      <p>
        <strong>Vista 9</strong>: Vista de perfil de un usuario, será accesible a través de la barra de menú, o clickeando en el apartado de "usuario" en un 
        producto publicado. Tendrá la foto de perfil, el nombre y un catálogo de los libros publicados por dicho usuario. En caso de ser la pestaña de usuario 
        de quien está actualmente autenticado, se podrá cambiar la foto de perfil, el nombre y estará habilitado un botón para subir un nuevo libro, que llevará 
        a la vista 6. Esta pestaña corresponde a la gestión de usuarios y gestión de libros.
      </p>
    </div>
  </body>
</html>