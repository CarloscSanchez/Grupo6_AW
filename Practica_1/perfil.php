<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario - BookSwap</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }
        .perfil-container {
            display: flex;
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .foto-perfil {
            text-align: center;
            flex: 1;
        }
        .foto-perfil img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 3px solid #ddd;
            object-fit: cover;
        }
        .foto-perfil button {
            margin-top: 10px;
            padding: 8px 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .foto-perfil button:hover {
            background-color: #218838;
        }
        .contenido {
            flex: 3;
        }
        .contenido h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .tabs button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .tabs button:hover {
            background-color: #0056b3;
        }
        .tabs button.active {
            background-color: #004080;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        .libros-publicados, .intercambios {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 200px;
            padding: 15px;
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .card img {
            width: 100%;
            border-radius: 10px;
        }
        .card h3 {
            font-size: 1.2em;
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
        .btn-subir-libro {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-subir-libro:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="perfil-container">
        <!-- Sección de foto de perfil -->
        <div class="foto-perfil">
            <img src="https://via.placeholder.com/150" alt="Foto de perfil">
            <button onclick="cambiarFotoPerfil()">Cambiar foto de perfil</button>
        </div>

        <!-- Sección de contenido -->
        <div class="contenido">
            <h2>Mi perfil</h2>
            <!-- Pestañas para navegar -->
            <div class="tabs">
                <button onclick="mostrarTab('libros')" class="active">Mis libros</button>
                <button onclick="mostrarTab('recibidos')">Intercambios recibidos</button>
                <button onclick="mostrarTab('enviados')">Intercambios enviados</button>
            </div>

            <!-- Contenido de las pestañas -->
            <div id="libros" class="tab-content active">
                <div class="libros-publicados">
                    <?php
                    // Datos de ejemplo (simulando libros publicados por el usuario)
                    $libros_publicados = [
                        [
                            "id" => 1,
                            "titulo" => "Cien años de soledad",
                            "autor" => "Gabriel García Márquez",
                            "generos" => ["Ficción", "Realismo mágico"],
                            "imagen" => "https://via.placeholder.com/200x150?text=Cien+años+de+soledad"
                        ],
                        [
                            "id" => 2,
                            "titulo" => "1984",
                            "autor" => "George Orwell",
                            "generos" => ["Ciencia ficción", "Distopía"],
                            "imagen" => "https://via.placeholder.com/200x150?text=1984"
                        ],
                        [
                            "id" => 3,
                            "titulo" => "Orgullo y prejuicio",
                            "autor" => "Jane Austen",
                            "generos" => ["Romance", "Clásico"],
                            "imagen" => "https://via.placeholder.com/200x150?text=Orgullo+y+prejuicio"
                        ]
                    ];

                    // Mostrar cada libro en una tarjeta
                    foreach ($libros_publicados as $libro) {
                        echo '
                        <div class="card" onclick="window.location.href=\'verLibro.php?id=' . $libro["id"] . '\'">
                            <img src="' . $libro["imagen"] . '" alt="' . $libro["titulo"] . '">
                            <h3>' . $libro["titulo"] . '</h3>
                            <p><strong>Autor:</strong> ' . $libro["autor"] . '</p>
                            <div class="generos">';
                        foreach ($libro["generos"] as $genero) {
                            echo '<span>' . $genero . '</span>';
                        }
                        echo '</div>
                        </div>';
                    }
                    ?>
                </div>
                <!-- Botón para subir libro -->
                <button class="btn-subir-libro" onclick="window.location.href='subirLibro.php'">Subir Libro</button>
            </div>

            <!-- Intercambios recibidos -->
            <div id="recibidos" class="tab-content">
                <div class="intercambios">
                    <?php
                    // Datos de ejemplo (simulando intercambios recibidos)
                    $intercambios_recibidos = [
                        [
                            "libro_solicitado" => "Cien años de soledad",
                            "usuario" => "Juan Pérez",
                            "libro_ofrecido" => "1984",
                            "estado" => "Pendiente"
                        ],
                        [
                            "libro_solicitado" => "Orgullo y prejuicio",
                            "usuario" => "Ana Gómez",
                            "libro_ofrecido" => "El señor de los anillos",
                            "estado" => "Aceptado"
                        ]
                    ];

                    // Mostrar cada intercambio recibido
                    foreach ($intercambios_recibidos as $intercambio) {
                        echo '
                        <div class="card">
                            <h3>' . $intercambio["libro_solicitado"] . '</h3>
                            <p><strong>Usuario:</strong> ' . $intercambio["usuario"] . '</p>
                            <p><strong>Ofrece:</strong> ' . $intercambio["libro_ofrecido"] . '</p>
                            <p><strong>Estado:</strong> ' . $intercambio["estado"] . '</p>
                        </div>';
                    }
                    ?>
                </div>
            </div>

            <!-- Intercambios enviados -->
            <div id="enviados" class="tab-content">
                <div class="intercambios">
                    <?php
                    // Datos de ejemplo (simulando intercambios enviados)
                    $intercambios_enviados = [
                        [
                            "libro_solicitado" => "1984",
                            "usuario" => "Carlos Ruiz",
                            "libro_ofrecido" => "Cien años de soledad",
                            "estado" => "Pendiente"
                        ]
                    ];

                    // Mostrar cada intercambio enviado
                    foreach ($intercambios_enviados as $intercambio) {
                        echo '
                        <div class="card">
                            <h3>' . $intercambio["libro_solicitado"] . '</h3>
                            <p><strong>Usuario:</strong> ' . $intercambio["usuario"] . '</p>
                            <p><strong>Ofrezco:</strong> ' . $intercambio["libro_ofrecido"] . '</p>
                            <p><strong>Estado:</strong> ' . $intercambio["estado"] . '</p>
                        </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Función para cambiar la foto de perfil (simulación)
        function cambiarFotoPerfil() {
            alert("Funcionalidad para cambiar la foto de perfil en desarrollo.");
        }

        // Función para mostrar la pestaña seleccionada
        function mostrarTab(tabId) {
            // Ocultar todos los contenidos de las pestañas
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });

            // Mostrar la pestaña seleccionada
            document.getElementById(tabId).classList.add('active');

            // Resaltar el botón de la pestaña activa
            document.querySelectorAll('.tabs button').forEach(button => {
                button.classList.remove('active');
            });
            document.querySelector(`.tabs button[onclick="mostrarTab('${tabId}')"]`).classList.add('active');
        }
    </script>
</body>
</html>