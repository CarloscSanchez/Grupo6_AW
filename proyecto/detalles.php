<?php
require __DIR__.'/includes/config.php';
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <link rel="icon" href="img/logo_icono.ico" type="image/x-icon">
    <link rel="stylesheet" href="CSS/estilos.css"> <!-- Archivo CSS externo -->
    <title>Detalles</title>
  </head>
  <body>

    <!-- Incluir el archivo navbar.php -->
    <?php include 'includes/vistas/comun/navbar.php'; ?>


    <h1>Introducción</h1><!-- Aquí viene indicada una pequeña introducción a nuestra plataforma -->
    <p>BookSwap es una plataforma web que permite a los usuarios intercambiar libros físicos de manera
       fácil y gratuita. Creemos que cada libro merece ser leído más de una vez y que compartir 
       historias fomenta la cultura y la comunidad. Con el auge de la digitalización, muchos libros
        físicos quedan olvidados en estanterías, pero BookSwap busca darles una segunda vida 
        conectando lectores con intereses similares. La plataforma ofrece una alternativa 
        sostenible y económica para acceder a nuevas lecturas sin necesidad de comprarlas. 
        A través de nuestra web, los usuarios pueden subir los libros que desean intercambiar, 
        buscar títulos disponibles en su área y contactar con otros lectores para organizar 
        intercambios. Además, ofrecemos herramientas de búsqueda avanzada y filtrado por género,
         idioma y popularidad, facilitando así una experiencia intuitiva y eficiente. Con BookSwap, 
         los libros dejan de acumular polvo en las estanterías y encuentran nuevos lectores sin 
         coste alguno</p>

    <h2> Tipos de usuarios </h2><!-- Aquí vienen indicados los tipos de usuarios -->
    <p>Visitantes (no registrados): Pueden explorar los libros disponibles en su área mediante un buscador por título, autor o género.</p>
    <p>Usuarios registrados: Pueden publicar libros que desean intercambiar, contactar con otros usuarios para acordar intercambios y dejar reseñas sobre los libros recibidos.</p>
    <p>Bibliotecas asociadas: Pueden publicar libros gratuitos disponibles para la comunidad y anunciar eventos de lectura.</p>
    <p>Administrador: Supervisa las publicaciones para evitar contenido inadecuado, gestiona usuarios y mantiene la plataforma segura.</p>

    <h3> Funcionalidades </h3><!-- Las funcionalidades que desarrollaremos -->
    <p>Filtros y búsqueda: Búsqueda mediante filtros y/o palabras.</p>
    <p>Eliminar, borrar, subir libros</p>
    <p>Intercambio de libros / solicitar</p>
    <p>Gestión de admins -> eventos y demás: Un blog con las últimas novedades que será manejado por los administradores.</p>

  </body>
</html>
