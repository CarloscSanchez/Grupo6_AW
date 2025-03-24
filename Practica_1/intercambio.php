<?php
require __DIR__.'/includes/config.php';

?>


<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intercambio de Libros - BookSwap</title>
    <link rel="icon" href="img/logo_icono.ico" type="image/x-icon">
    <link rel="stylesheet" href="CSS/estilos.css">
</head>
<!-- Queda hacer toda la lógica está solo la previsualizacion-->
 
<body>
    <!-- Añadir la barra de navegación de la página -->
    <?php include 'includes/vistas/comun/navbar.php'; ?>

    <header>
        <h1>Biblioteca Online</h1>
    </header>

    <main>
        <!-- Sección del libro solicitado -->
        <section class="libro-solicitado">
            <h2>Libro Solicitado</h2>
            <?php                
                // Incluir la configuración de la base de datos
                include 'config.php';   

                // Crear la conexión
                $conn = new mysqli(BD_HOST, BD_USER, BD_PASS, BD_NAME);

                
                $id_intercambio = $_GET["id"] ?? null;

                // Verificar la conexión
                if($conn->connect_errno){
                    die("Error de conexión a la base de datos: " . $conn->connect_error);
                }

                $id_libro = 12;
                // Consulta para obtener los libros publicados por el usuario
                $libros_solicitados = [];
                $sql = "SELECT * FROM libros WHERE idlibro = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id_libro);    
                $stmt->execute();
                $result = $stmt->get_result();

                // Guardar los libros en un array
                while($libro = $result->fetch_assoc()){  // fetch_assoc() obtiene una fila de resultados como un array asociativo
                    $libros_solicitados[] = $libro;   // Añadir el libro al final del array
                }

                $stmt->close();  // Cerrar la consulta
                $conn->close();  // Cerrar la conexión

                // Mostrar cada libro en una tarjeta
                foreach ($libros_solicitados as $libro) {
                    echo '
                    <div class="card">
                        <img src="' . $libro["imagen"] . '" alt="' . $libro["titulo"] . '">
                        <h2>' . $libro["titulo"] . '</h2>
                        <p><strong>Autor:</strong> ' . $libro["autor"] . '</p>
                        <p>' . $libro["descripcion"] . '</p>
                        <div class="generos">';
                    echo '<span>' . $libro["genero"]. '</span>';                    
                    echo '</div>
                    </div>';
                }
                ?>
        </section>

        <!-- Sección de libros disponibles -->
        <section class="libros-disponibles">
            <h2> Libros Disponibles</h2>
            <div class="catalogo">
                <?php                
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
                $sql = "SELECT * FROM libros LEFT JOIN usuarios ON usuarios.idusuario = libros.idpropietario WHERE idpropietario != ?";
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
        </section>

        <?php
        if($id_intercambio == 0){
            echo '<button class="aceptar-intercambio">Aceptar intercambio</button>';
            echo '<button class="rechazar-intercambio">Rechazar intercambio</button>';
        } else{
            echo '<button class="rechazar-intercambio">Cancelar intercambio</button>';
        }
        
        ?>

    </main>

</body>
</html>