<?php
require_once __DIR__.'/includes/config.php';


//si es admin no le deja acceder
if (isset($_SESSION['esAdmin']) && $_SESSION['esAdmin'] === true) {
    header("Location: admin.php");
    exit();
}   

$usuario = $_SESSION['nombre'];  // Obtener el ID del usuario de la sesión

$conn = new mysqli(BD_HOST, BD_USER, BD_PASS, BD_NAME);

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
while($libro = $result->fetch_assoc()){
    $libros_publicados[] = $libro;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo_icono.ico" type="image/x-icon">
    <link rel="stylesheet" href="CSS/estilos.css">
    <title>Perfil de Usuario - BookSwap</title>

</head>
<body>
    <!-- Incluir la barra de navegación -->
    <?php include 'includes/vistas/comun/navbar.php'; ?>

    <!-- Contenido de la página -->
    <div class="perfil-body">
        <div class="perfil-container">

            <!-- Foto de perfil y botón para cambiarla -->
            <div class="foto-perfil">
                <img src="img/logo5_AW.jpg" alt="Foto de perfil">
                <p class="nombre-usuario"><?php echo $usuario; ?></p>
                <button>Cambiar foto de perfil</button>
            </div>

            <!-- Información del usuario -->
            <div class="contenido">
                <h2>Mi perfil</h2>

                <div class="perfil-tabs">
                    <input type="radio" name="tab" id="tab1" checked>
                    <label for="tab1">Mis libros</label>

                    <input type="radio" name="tab" id="tab2">
                    <label for="tab2">Intercambios recibidos</label>

                    <input type="radio" name="tab" id="tab3">
                    <label for="tab3">Intercambios enviados</label>

                    <div class="tab-content" id="content1">
                        <div class="libros-publicados">
                            <?php
                            foreach ($libros_publicados as $libro) {
                                echo '
                                <div class="card" onclick="window.location.href=\'verLibro.php?id=' . $libro["idlibro"] . '\'">
                                    <img src="' . $libro["imagen"] . '" alt="' . $libro["titulo"] . '">
                                    <h3>' . $libro["titulo"] . '</h3>
                                    <p>Autor: ' . $libro["autor"] . '</p>
                                    <div class="generos">
                                        <span>' . $libro["genero"] . '</span>
                                    </div>
                                </div>';
                            }
                            ?>
                        </div>
                        <button class="btn-subir-libro" onclick="window.location.href='subirLibro.php'">Subir Libro</button>
                    </div>

                    <div class="tab-content" id="content2">
                        <div class="intercambios">
                            <?php
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
                            $a = 0;
                            foreach ($intercambios_recibidos as $intercambio) {
                                echo '
                                <div class="card" onclick="window.location.href=\'intercambio.php?id=' . $a . '\'">
                                    <h3>' . $intercambio["libro_solicitado"] . '</h3>
                                    <p><strong>Usuario:</strong> ' . $intercambio["usuario"] . '</p>
                                    <p><strong>Ofrece:</strong> ' . $intercambio["libro_ofrecido"] . '</p>
                                    <p><strong>Estado:</strong> ' . $intercambio["estado"] . '</p>
                                </div>';
                            }
                            ?>
                        </div>
                    </div>

                    <div class="tab-content" id="content3">
                        <div class="intercambios">
                            <?php
                            $intercambios_enviados = [
                                [
                                    "libro_solicitado" => "1984",
                                    "usuario" => "Carlos Ruiz",
                                    "libro_ofrecido" => "Cien años de soledad",
                                    "estado" => "Pendiente"
                                ]
                            ];                            
                            $b = 1;
                            foreach ($intercambios_enviados as $intercambio) {
                                echo '
                                <div class="card" onclick="window.location.href=\'intercambio.php?id=' . $b . '\'">
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
    </div>

</body>
</html>
