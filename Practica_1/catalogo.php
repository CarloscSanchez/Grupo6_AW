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
            
            <form action="catalogo.php" method="get">
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

                // Mostrar cada libro en una tarjeta
                foreach ($libros_publicados as $libro) {
                    echo '
                    <div class="card">
                        <img src="' . $libro["imagen"] . '" alt="' . $libro["titulo"] . '">
                        <h2>' . $libro["titulo"] . '</h2>
                        <p><strong>Autor:</strong> ' . $libro["autor"] . '</p>
                        <p>' . $libro["descripcion"] . '</p>
                        <p><strong>Propietario:</strong>' . $libro["nombre"] . '</p>
                        <div class="generos">';
                    echo '<span>' . $libro["genero"]. '</span>';                    
                    echo '</div>
                    </div>';
                }
                ?>
            </div>

        </div>
    </div>

</body>
</html>