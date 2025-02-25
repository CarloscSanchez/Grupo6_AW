<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/estilos.css"> <!-- Archivo CSS externo -->
    <title>Perfil de Usuario - BookSwap</title>
</head>
<body>

    <!-- Incluir la barra de navegación -->
    <?php include 'inlcudes/vistas/comun/navbar.php'; ?>

    <div class="perfil-body">
        <div class="perfil-container">
            <!-- Sección de foto de perfil -->
            <div class="foto-perfil">
                <img src="img/logo5_AW.jpg" alt="Foto de perfil">
                <button onclick="cambiarFotoPerfil()">Cambiar foto de perfil</button>
            </div>

            <!-- Sección de contenido -->
            <div class="contenido">
                <h2>Mi perfil</h2>
                <!-- Pestañas para navegar -->
                <div class="tabs">
                    <button onclick="mostrarTab('libros')">Mis libros</button>
                    <button onclick="mostrarTab('recibidos')">Intercambios recibidos</button>
                    <button onclick="mostrarTab('enviados')">Intercambios enviados</button>
                </div>

                <!-- Contenido de las pestañas (generado forzadamente para ver como quedaría)-->
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

                <!-- Intercambios recibidos (generados forzadamente para ver como sería)-->
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