<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo_icono.ico" type="image/x-icon">
    <link rel="stylesheet" href="CSS/estilos.css"> <!-- Archivo CSS externo -->
    <title>Editar un libro</title>
    
</head>
<body>
    <!-- Incluir la barra de navegación -->
    <?php include 'includes/vistas/comun/navBar.php'; ?>
    
    <?php $id = isset($_GET['id']) ? $_GET['id'] : '';  // Obtener el id del libro a editar  ?>

    <div class="body-subirLibro">
        <div class="form-container">
            <h2>Edita tu libro</h2>
            
            <!-- Formulario para subir un libro -->
            <form action="procesar_editar_libro.php?id=<?php echo htmlspecialchars($id); ?>" method="post" enctype="multipart/form-data">
                <!-- Título -->
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" required>

                <!-- Autor -->
                <label for="autor">Autor:</label>
                <input type="text" id="autor" name="autor" required>

                <!-- Géneros -->
                <label for="genero">Género:</label>
                <select id="genero" name="genero" required>
                    <option value="">Selecciona un género</option>
                    <option value="Poesía">Poesía</option>
                    <option value="Aventuras">Aventuras</option>
                    <option value="Ciencia ficción">Ciencia ficción</option>
                    <option value="Romance">Romance</option>
                    <option value="Misterio">Misterio</option>
                    <option value="Fantasía">Fantasía</option>
                    <option value="Histórico">Histórico</option>
                    <option value="Terror">Terror</option>
                    <option value="Biografía">Biografía</option>
                    <option value="Clásico">Clásico</option>
                </select>

                <!-- Estado -->
                <label for="estado">Estado:</label>
                <select id="estado" name="estado">
                    <option value="">Selecciona un estado</option>
                    <option value="nuevo">Nuevo</option>
                    <option value="bueno">Bueno</option>
                    <option value="aceptable">Aceptable</option>
                    <option value="deteriorado">Deteriorado</option>
                </select>

                <!-- Idioma -->
                <label for="idioma">Idioma:</label>
                <input type="text" id="idioma" name="idioma" required>

                <!-- Descripcion -->
                <label for="descripcion">Descripción:</label>
                <input type="text" id="descripcion" name="descripcion">

                <!-- Editorial -->
                <label for="editorial">Editorial:</label>
                <input type="text" id="editorial" name="editorial" required>


                <!-- Botón de actualizar -->
                <button class="btn-submit" type="submit">Actualizar libro</button>
                <button class="btn-cancel" type="button" onclick="window.location.href='perfil.php'">Cancelar</button>
            </form>            
        </div>
    </div>


</body>
</html>