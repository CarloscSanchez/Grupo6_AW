<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Libros - BookSwap</title>
    <link rel="icon" href="img/logo_icono.ico" type="image/x-icon">
    <link rel="stylesheet" href="CSS/estilos.css">

</head>
<body>

    <!-- Añadir la barra de navegación de la página -->
    <?php include 'includes/vistas/comun/navbar.php'; ?>

    <div class="catalogo-contenedor">

        <!-- Barra lateral con búsqueda y filtros -->
        <aside class="filtros">
            <h2>Buscar y Filtrar</h2>
            
            <form action="" method="get">
                <input type="text" name="buscar" placeholder="Buscar por título o autor">

                <h3>Géneros</h3>
                <label><input type="checkbox" name="genero[]" value="Ficción"> Ficción</label>
                <label><input type="checkbox" name="genero[]" value="Realismo mágico"> Realismo mágico</label>
                <label><input type="checkbox" name="genero[]" value="Ciencia ficción"> Ciencia ficción</label>
                <label><input type="checkbox" name="genero[]" value="Distopía"> Distopía</label>
                <label><input type="checkbox" name="genero[]" value="Romance"> Romance</label>
                <label><input type="checkbox" name="genero[]" value="Clásico"> Clásico</label>
                <label><input type="checkbox" name="genero[]" value="Fantasía"> Fantasía</label>
                <label><input type="checkbox" name="genero[]" value="Aventura"> Aventura</label>

                <button type="submit">Aplicar filtros</button>
            </form>
        </aside>


        <div class="catalogo-body">
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

        </div>
    </div>

</body>
</html>