<?php
require __DIR__.'/includes/config.php';


// Verificar si el usuario es un administrador
if (!isset($_SESSION['esAdmin']) || $_SESSION['esAdmin'] !== true) {
    header("Location: login.php");
    exit();
}


// Crear la conexión
$app = Aplicacion::getInstance();
$conn = $app->getConexionBd();

// Verificar la conexión
if ($conn->connect_errno) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Consultar la lista de usuarios normales
$sql_usuarios = "SELECT idusuario, nombre, correo, tipo FROM usuarios WHERE tipo = 'normal'";
$result_usuarios = $conn->query($sql_usuarios);

// Generar la tabla de usuarios
$tabla_usuarios = '';
if ($result_usuarios->num_rows > 0) {
    while ($row = $result_usuarios->fetch_assoc()) {
        $tabla_usuarios .= "<tr>";
        $tabla_usuarios .= "<td>" . $row['idusuario'] . "</td>";
        $tabla_usuarios .= "<td>" . $row['nombre'] . "</td>";
        $tabla_usuarios .= "<td>" . $row['correo'] . "</td>";
        $tabla_usuarios .= "<td>" . $row['tipo'] . "</td>";
        $tabla_usuarios .= "<td><a href='eliminar_usuario.php?id=" . $row['idusuario'] . "'>Eliminar</a></td>";
        $tabla_usuarios .= "</tr>";
    }
} else {
    $tabla_usuarios .= "<tr><td colspan='5'>No hay usuarios registrados.</td></tr>";
}

// Consultar la lista de libros
$sql_libros = "SELECT idlibro, titulo, autor FROM libros";
$result_libros = $conn->query($sql_libros);

// Generar la tabla de libros
$tabla_libros = '';
if ($result_libros->num_rows > 0) {
    while ($row = $result_libros->fetch_assoc()) {
        $tabla_libros .= "<tr>";
        $tabla_libros .= "<td>" . $row['idlibro'] . "</td>";
        $tabla_libros .= "<td>" . $row['titulo'] . "</td>";
        $tabla_libros .= "<td>" . $row['autor'] . "</td>";
        $tabla_libros .= "<td><a href='eliminar_libro.php?id=" . $row['idlibro'] . "'>Eliminar</a></td>";
        $tabla_libros .= "</tr>";
    }
} else {
    $tabla_libros .= "<tr><td colspan='4'>No hay libros registrados.</td></tr>";
}

?>

<?php
$tituloPagina = 'BookSwap - Admin';
require_once __DIR__.'/includes/config.php';

$contenidoPrincipal=<<<EOS
  <div class="admin-container">
        <h2>Listado de Usuarios</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Tipo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $tabla_usuarios
            </tbody>
        </table>

        <h2>Listado de Libros</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $tabla_libros
            </tbody>
        </table>
    </div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';

?>
