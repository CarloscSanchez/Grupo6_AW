<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Incluir la configuración de la base de datos
include 'config.php';

// Crear la conexión
$conn = new mysqli(BD_HOST, BD_USER, BD_PASS, BD_NAME);

// Verificar la conexión
if ($conn->connect_errno) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}


// Obtener los datos del formulario

$username = isset($_POST['usuario']) ? trim($_POST['usuario']) : "";
$password = isset($_POST['password']) ? trim($_POST['password']) : "";

// Evitar inyección SQL con consultas preparadas, al principio lo hice con ->query y no funciono
$stmt = $conn->prepare("SELECT nombre, contraseña, tipo FROM usuarios WHERE nombre = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    $row = $result->fetch_assoc();//en un array
    if(password_verify($password, $row['contraseña'])){//comprobamos los hashes
        $_SESSION['login'] = true;
        $_SESSION['usuario'] = $row['nombre'];
        $_SESSION['tipo'] = $row['tipo'];

        error_log("Tipo de usuario: " . $row['tipo']);

        // Redirigir según el rol del usuario
        if ($row['tipo'] == 'admin') {
            header("Location: admin.php");
        } else if ($row['tipo'] == 'normal')  {
            header("Location: index.php");
        }
        exit();
    }
}

// Redirigir en caso de error
header("Location: login.php?error=1");
exit();

$conn->close();
?>



