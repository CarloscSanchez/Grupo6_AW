<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Libro - BookSwap</title>
    <link rel="stylesheet" href="CSS/estilos.css"> <!-- Archivo CSS externo -->
</head>
<body>
    <div class="body-verLibro">
        <div class="libro-container">
            <?php
            // Simulación de datos del libro (en un caso real, esto vendría de una base de datos)
            $libros = [
                1 => [
                    "titulo" => "Cien años de soledad",
                    "autor" => "Gabriel García Márquez",
                    "descripcion" => "Una obra maestra del realismo mágico que narra la historia de la familia Buendía en Macondo.",
                    "generos" => ["Ficción", "Realismo mágico"],
                    "imagen" => "https://via.placeholder.com/300x200?text=Cien+años+de+soledad"
                ],
                2 => [
                    "titulo" => "1984",
                    "autor" => "George Orwell",
                    "descripcion" => "Una distopía clásica que explora temas de vigilancia y control estatal.",
                    "generos" => ["Ciencia ficción", "Distopía"],
                    "imagen" => "https://via.placeholder.com/300x200?text=1984"
                ],
                3 => [
                    "titulo" => "Orgullo y prejuicio",
                    "autor" => "Jane Austen",
                    "descripcion" => "Una novela romántica que sigue la historia de Elizabeth Bennet y el señor Darcy.",
                    "generos" => ["Romance", "Clásico"],
                    "imagen" => "https://via.placeholder.com/300x200?text=Orgullo+y+prejuicio"
                ]
            ];

            // Obtener el ID del libro desde la URL
            $id = $_GET["id"] ?? null;
            if ($id && isset($libros[$id])) {
                $libro = $libros[$id];
                echo '
                <img src="' . $libro["imagen"] . '" alt="' . $libro["titulo"] . '">
                <h1>' . $libro["titulo"] . '</h1>
                <p><strong>Autor:</strong> ' . $libro["autor"] . '</p>
                <p>' . $libro["descripcion"] . '</p>
                <div class="generos">';
                foreach ($libro["generos"] as $genero) {
                    echo '<span>' . $genero . '</span>';
                }
                echo '</div>
                <div class="acciones">
                    <button class="editar" onclick="window.location.href=\'editarLibro.php?id=' . $id . '\'">Editar</button>
                    <button class="borrar" onclick="confirmarBorrado(' . $id . ')">Borrar</button>
                </div>';
            } else {
                echo '<p>Libro no encontrado.</p>';
            }
            ?>
        </div>
    </div>
    

    <script>
        // Función para confirmar el borrado de un libro
        function confirmarBorrado(id) {
            if (confirm("¿Estás seguro de que quieres borrar este libro?")) {
                window.location.href = 'procesar_borrado.php?id=' + id;
            }
        }
    </script>
</body>
</html>