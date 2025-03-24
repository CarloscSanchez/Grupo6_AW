<?php
require_once __DIR__.'/includes/config.php';

// Si es admin no le deja acceder
if (isset($_SESSION['esAdmin']) && $_SESSION['esAdmin'] === true) {
    header("Location: admin.php");
    exit();
}

$usuario = $_SESSION['nombre'];  // Obtener el ID del usuario de la sesión

$app = Aplicacion::getInstance();
$conn = $app->getConexionBd();

if ($conn->connect_errno) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Consulta para obtener el id de usuario
$stmt = $conn->prepare("SELECT idusuario FROM usuarios WHERE nombre = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$id_usuario = $stmt->get_result()->fetch_assoc()['idusuario'];
$stmt->close();

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

$tituloPagina = 'Perfil de Usuario - BookSwap';

$contenidoPrincipal = <<<EOS
<div class='perfil-body'>
    <div class='perfil-container'>

        <!-- Foto de perfil y botón para cambiarla -->
        <div class='foto-perfil'>
            <img src='img/logo5_AW.jpg' alt='Foto de perfil'>
            <p class='nombre-usuario'>$usuario</p>
            <button>Cambiar foto de perfil</button>
        </div>

        <!-- Información del usuario -->
        <div class='contenido'>
            <h2>Mi perfil</h2>

            <div class='perfil-tabs'>
                <input type='radio' name='tab' id='tab1' checked>
                <label for='tab1'>Mis libros</label>

                <input type='radio' name='tab' id='tab2'>
                <label for='tab2'>Intercambios recibidos</label>

                <input type='radio' name='tab' id='tab3'>
                <label for='tab3'>Intercambios enviados</label>

                <div class='tab-content' id='content1'>
                    <div class='libros-publicados'>
EOS;

foreach ($libros_publicados as $libro) {
    $contenidoPrincipal .= <<<EOS
        <div class="card" onclick="window.location.href='verLibro.php?id={$libro['idlibro']}'">
            <img src="{$libro['imagen']}" alt="{$libro['titulo']}">
            <h3>{$libro['titulo']}</h3>
            <p>Autor: {$libro['autor']}</p>
            <div class="generos">
                <span>{$libro['genero']}</span>
            </div>
        </div>
EOS;
}

$contenidoPrincipal .= <<<EOS
                    </div>
                    <button class='btn-subir-libro' onclick="window.location.href='subirLibro.php'">Subir Libro</button>
                </div>

                <div class='tab-content' id='content2'>
                    <div class='intercambios'>
                        <p>No hay intercambios recibidos.</p>
                    </div>
                </div>

                <div class='tab-content' id='content3'>
                    <div class='intercambios'>
                        <p>No hay intercambios enviados.</p>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
?>