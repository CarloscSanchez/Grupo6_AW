<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario es un administrador
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Incluir la configuración de la base de datos
include 'config.php';

// Crear la conexión
$conn = new mysqli(BD_HOST, BD_USER, BD_PASS, BD_NAME);

// Verificar la conexión
if ($conn->connect_errno) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Consultar la lista de usuarios normales
$sql_usuarios = "SELECT idUsuario, nombre, correo, tipo FROM usuarios WHERE tipo = 'normal'";
$result_usuarios = $conn->query($sql_usuarios);

// Generar la tabla de usuarios
$tabla_usuarios = '';
if ($result_usuarios->num_rows > 0) {
    while ($row = $result_usuarios->fetch_assoc()) {
        $tabla_usuarios .= "<tr>";
        $tabla_usuarios .= "<td>" . $row['idUsuario'] . "</td>";
        $tabla_usuarios .= "<td>" . $row['nombre'] . "</td>";
        $tabla_usuarios .= "<td>" . $row['correo'] . "</td>";
        $tabla_usuarios .= "<td>" . $row['tipo'] . "</td>";
        $tabla_usuarios .= "<td><a href='eliminar_usuario.php?id=" . $row['idUsuario'] . "'>Eliminar</a></td>";
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

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <link rel="icon" href="img/logo_icono.ico" type="image/x-icon">
    <link rel="stylesheet" href="CSS/estilos.css"> <!-- Archivo CSS externo -->
    <title>BookSwap - Admin</title>
</head>
<body>
    <!-- Incluir la barra de navegación -->
    <?php include 'includes/vistas/comun/navBar.php'; ?>

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
                <?php echo $tabla_usuarios; ?>
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
                <?php echo $tabla_libros; ?>
            </tbody>
        </table>
    </div>
</body>
</html>