<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir la configuración de la base de datos
include 'config.php';   

// Crear la conexión
$conn = new mysqli(BD_HOST, BD_USER, BD_PASS, BD_NAME);

// Verificar la conexión
if($conn->connect_errno){
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

if(isset($_SESSION['usuario'])){    
    $usuario = $_SESSION['usuario'];  // Obtener el ID del usuario de la sesión
        
    // Consulta para obtener el id de usuario
    $stmt = $conn->prepare("SELECT idusuario FROM usuarios WHERE nombre = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $id_usuario = $stmt->get_result()->fetch_assoc()['idusuario'];
} else{
    $id_usuario = 0;
}

// Consulta para obtener los libros publicados por el usuario
$libros_publicados = [];
$sql = "SELECT * FROM libros LEFT JOIN usuarios ON usuarios.idUsuario = libros.idpropietario WHERE idpropietario != ?";
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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <link rel="icon" href="img/logo_icono.ico" type="image/x-icon">
    <link rel="stylesheet" href="CSS/estilos.css"> <!-- Archivo CSS externo -->
    <title>BookSwap</title>
</head>
<body>
    <!-- Incluir la barra de navegación -->
    <?php include 'includes/vistas/comun/navBar.php'; ?>

    <div class="hero">
        <h1>BookSwap - Comparte y descubre libros cerca de ti</h1>
        <p>
            Intercambia libros físicos de forma fácil y gratuita. Busca títulos en tu área,
            contacta con otros lectores y da una nueva vida a tus historias favoritas.
            ¡Únete a nuestra comunidad y empieza a compartir lectura hoy mismo!
        </p>
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
                    <p>Autor: ' . $libro["autor"] . '</p>
                    <p>Propietario: ' . $libro["nombre"] . '</p>
                    <div class="generos">';
                    echo '<span>' . $libro["genero"] . '</span>';
                    echo '</div>
                </div>';
            }                        
            ?>                        
        </div>
    </div>

</body>
</html>