<?php
require __DIR__.'/includes/config.php';

use \includes\aplicacion as Aplicacion;

// Crear la conexión
$app = Aplicacion::getInstance();
$conn = $app->getConexionBd();

$id_intercambio = $_GET["id"] ?? null;

// Verificar la conexión
if ($conn->connect_errno) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

//Aqui el idlibro tendremos que poner el seleccionado
$id_libro = 2;
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
$tituloPagina = 'BookSwap - Admin';

$contenidoPrincipal=<<<EOS
    <header>
        <h1>Biblioteca Online</h1>
    </header>
    
    <main>
        <!-- Sección del libro solicitado -->
        <section class="libro-solicitado">
            <h2>Libro Solicitado</h2>
EOS;

// Mostrar cada libro en una tarjeta
foreach ($libros_solicitados as $libro) {
    $contenidoPrincipal .= <<<EOS
    <div class="card">
        <img src="{$libro["imagen"]}" alt="{$libro["titulo"]}">
        <h2>{$libro["titulo"]}</h2>
        <p><strong>Autor:</strong> {$libro["autor"]}</p>
        <p>{$libro["descripcion"]}</p>
        <div class="generos">
            <span> {$libro["genero"]} </span>                    
        </div>
    </div>
EOS;
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


$contenidoPrincipal .= <<<EOS
        </section>

        <section class="libros-disponibles">
            <h2> Libros Disponibles</h2>
            <div class="catalogo">       
EOS;        

// Mostrar cada libro en una tarjeta
foreach ($libros_publicados as $libro) {
    $contenidoPrincipal .= <<<EOS
                <div class="card">
                    <img src="{$libro["imagen"]}" alt=" {$libro["titulo"]} ">
                    <h2> {$libro["titulo"]} </h2>
                    <p><strong>Autor:</strong>  {$libro["autor"]} </p>
                    <p> {$libro["descripcion"]} </p>
                    <p><strong>Propietario:</strong> {$libro["nombre"]} </p>
                    <div class="generos">
                        <span> {$libro["genero"]} </span>                   
                    </div>
                </div>
    EOS;
}

$contenidoPrincipal .= <<<EOS
            </div>
        </section> 
EOS;        
            

if($id_intercambio == 0){
    $contenidoPrincipal .= <<<EOS
        <button class="aceptar-intercambio">Aceptar intercambio</button>
        <button class="rechazar-intercambio">Rechazar intercambio</button>
        </main> 
    EOS;
    
} else{
    $contenidoPrincipal .= <<<EOS
        <button class="rechazar-intercambio">Cancelar intercambio</button>
        </main> 
    EOS;
}

require __DIR__.'/includes/vistas/plantillas/plantilla.php';

?>