<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Libros - BookSwap</title>

    <!-- A modo de prueba, pero en caso de ponerlo, el estilo va a la CSS-->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .catalogo {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            padding: 15px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .card img {
            width: 100%;
            border-radius: 10px;
        }
        .card h2 {
            font-size: 1.5em;
            margin: 10px 0;
            color: #333;
        }
        .card p {
            font-size: 0.9em;
            color: #555;
            margin: 5px 0;
        }
        .card .generos {
            font-size: 0.8em;
            color: #777;
            margin-top: 10px;
        }
        .card .generos span {
            background-color: #e0e0e0;
            padding: 3px 8px;
            border-radius: 5px;
            margin-right: 5px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <h1>Catálogo de Libros</h1>
    <div class="catalogo">
        <?php
        // Datos de ejemplo (simulando una base de datos)
        $libros = [
            [
                "titulo" => "Cien años de soledad",
                "autor" => "Gabriel García Márquez",
                "descripcion" => "Una obra maestra del realismo mágico que narra la historia de la familia Buendía en Macondo.",
                "generos" => ["Ficción", "Realismo mágico"],
                "imagen" => "https://via.placeholder.com/300x200?text=Cien+años+de+soledad"
            ],
            [
                "titulo" => "1984",
                "autor" => "George Orwell",
                "descripcion" => "Una distopía clásica que explora temas de vigilancia y control estatal.",
                "generos" => ["Ciencia ficción", "Distopía"],
                "imagen" => "https://via.placeholder.com/300x200?text=1984"
            ],
            [
                "titulo" => "Orgullo y prejuicio",
                "autor" => "Jane Austen",
                "descripcion" => "Una novela romántica que sigue la historia de Elizabeth Bennet y el señor Darcy.",
                "generos" => ["Romance", "Clásico"],
                "imagen" => "https://via.placeholder.com/300x200?text=Orgullo+y+prejuicio"
            ],
            [
                "titulo" => "El señor de los anillos",
                "autor" => "J.R.R. Tolkien",
                "descripcion" => "Una épica aventura en la Tierra Media para destruir el Anillo Único.",
                "generos" => ["Fantasía", "Aventura"],
                "imagen" => "https://via.placeholder.com/300x200?text=El+señor+de+los+anillos"
            ]
        ];

        // Mostrar cada libro en una tarjeta
        foreach ($libros as $libro) {
            echo '
            <div class="card">
                <img src="' . $libro["imagen"] . '" alt="' . $libro["titulo"] . '">
                <h2>' . $libro["titulo"] . '</h2>
                <p><strong>Autor:</strong> ' . $libro["autor"] . '</p>
                <p>' . $libro["descripcion"] . '</p>
                <div class="generos">';
            foreach ($libro["generos"] as $genero) {
                echo '<span>' . $genero . '</span>';
            }
            echo '</div>
            </div>';
        }
        ?>
    </div>
</body>
</html>