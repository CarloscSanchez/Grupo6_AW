<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$usuario = $_SESSION['usuario'];  // Obtener el ID del usuario de la sesión

// Incluir la configuración de la base de datos
include 'config.php';   

// Crear la conexión
$conn = new mysqli(BD_HOST, BD_USER, BD_PASS, BD_NAME);

// Verificar la conexión
if($conn->connect_errno){
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Consulta para obtener el id de usuario
$stmt = $conn->prepare("SELECT idusuario FROM usuarios WHERE nombre = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$id_usuario = $stmt->get_result()->fetch_assoc()['idusuario'];

// Consulta para obtener los libros publicados por el usuario
$libros_publicados = [];
$sql = "SELECT * FROM libros WHERE idpropietario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);    
$stmt->execute();
$result = $stmt->get_result();

// Guardar los libros en un array
while($libro = $result->fetch_assoc()){  // fetch_assoc() obtiene una fila de resultados como un array asociativo
    $libros_publicados[] = $libro;   // Añadir el libro al final del array
}

$stmt->close();  // Cerrar la consulta
$conn->close();  // Cerrar la conexión
?>

<!-- Código HTML para mostrar el perfil del usuario -->
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
    <?php include 'includes/vistas/comun/navbar.php'; ?>

    <!-- Contenido de la página -->
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

                <!-- Contenido de las pestañas -->
                <div id="libros" class="tab-content active">
                    <div class="libros-publicados">
                        <?php
                        // Mostrar cada libro en una tarjeta
                        foreach ($libros_publicados as $libro) {
                            echo '
                            <div class="card" onclick="window.location.href=\'verLibro.php?id=' . $libro["idlibro"] . '\'">
                                <img src="' . $libro["imagen"] . '" alt="' . $libro["titulo"] . '">
                                <h3>' . $libro["titulo"] . '</h3>
                                <p>Autor:' . $libro["autor"] . '</p>
                                <div class="generos">';
                                echo '<span>' . $libro["genero"] . '</span>';
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