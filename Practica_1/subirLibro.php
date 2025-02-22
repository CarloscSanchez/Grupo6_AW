<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir un libro</title>
</head>
<body>
    <div class="form-container">
        <h2>Subir un libro</h2>
       
        <form action="" method="post" enctype="multipart/form-data">
            <!-- Título -->
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>
            <br>

            <!-- Autor -->
            <label for="autor">Autor:</label>
            <input type="text" id="autor" name="autor" required>
            <br>

            <!-- Géneros -->
            <label for="genero">Género:</label>
            <select id="genero" name="genero" required>
                <option value="">Selecciona un género</option>
                <option value="Ficción">Ficción</option>
                <option value="No ficción">No ficción</option>
                <option value="Ciencia ficción">Ciencia ficción</option>
                <option value="Romance">Romance</option>
                <option value="Misterio">Misterio</option>
                <option value="Fantasía">Fantasía</option>
                <option value="Histórico">Histórico</option>
                <option value="Biografía">Biografía</option>
            </select>
            <br>

            <!-- Editorial -->
            <label for="editorial">Editorial:</label>
            <input type="text" id="editorial" name="editorial">
            <br>

            <!-- Foto del libro -->
            <label for="foto">Foto del libro (opcional):</label>
            <input type="file" id="foto" name="foto" accept="image/*">
            <br>

            <!-- Botón de publicar -->
            <button type="submit">Publicar libro</button>
        </form>
    </div>

</body>
</html>