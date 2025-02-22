<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Libro - BookSwap</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }
        .libro-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .libro-container img {
            width: 100%;
            max-width: 300px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .libro-container h1 {
            color: #333;
        }
        .libro-container p {
            font-size: 1.1em;
            color: #555;
        }
        .libro-container .generos {
            font-size: 0.9em;
            color: #777;
            margin-top: 10px;
        }
        .libro-container .generos span {
            background-color: #e0e0e0;
            padding: 3px 8px;
            border-radius: 5px;
            margin-right: 5px;
            display: inline-block;
        }
        .acciones {
            margin-top: 20px;
        }
        .acciones button {
            padding: 10px 20px;
            margin-right: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .acciones .editar {
            background-color: #ffc107;
            color: black;
        }
        .acciones .editar:hover {
            background-color: #e0a800;
        }
        .acciones .borrar {
            background-color: #dc3545;
            color: white;
        }
        .acciones .borrar:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
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

    <script>
        // Función para confirmar el borrado de un libro
        function confirmarBorrado(id) {
            if (confirm("¿Estás seguro de que quieres borrar este libro?")) {
                window.location.href = 'borrarLibro.php?id=' + id;
            }
        }
    </script>
</body>
</html>