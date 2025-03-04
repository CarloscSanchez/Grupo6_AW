<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/estilos.css"> <!-- Archivo CSS externo -->
    <title>Subir un libro</title>
    
</head>
<body>
    <div class="body-subirLibro">
        <div class="form-container">
            <h2>Subir un libro</h2>
        
            <form action="procesarSubidaLibro.php" method="post" enctype="multipart/form-data">
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
                    <option value="Ficción">Ficción</option>
                    <option value="No ficción">No ficción</option>
                    <option value="Ciencia ficción">Ciencia ficción</option>
                    <option value="Romance">Romance</option>
                    <option value="Misterio">Misterio</option>
                    <option value="Fantasía">Fantasía</option>
                    <option value="Histórico">Histórico</option>
                    <option value="Biografía">Biografía</option>
                </select>

                <!-- Editorial -->
                <label for="editorial">Editorial:</label>
                <input type="text" id="editorial" name="editorial">

                <!-- Foto del libro -->
                <label for="foto">Foto del libro (opcional):</label>
                <input type="file" id="foto" name="foto" accept="image/*" onchange="previewImage(event)">
                <img id="preview" src="#" alt="Vista previa de la imagen" style="display: none;">

                <!-- Botón de publicar -->
                <button class="btn-submit" type="submit">Publicar libro</button>

                <button class="btn-cancel" type="button" onclick="window.location.href='perfil.php'">Cancelar</button>
            </form>
        </div>
    </div>
    

    <script>
        // Función para previsualizar la imagen seleccionada
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = '#';
                preview.style.display = 'none';
            }
        }
    </script>
</body>
</html>