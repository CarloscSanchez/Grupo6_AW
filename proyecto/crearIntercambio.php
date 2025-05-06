<?php
require __DIR__.'/includes/config.php';

use \includes\aplicacion as Aplicacion;
use \includes\clases\productos\Libro as Libro;
use \includes\clases\usuarios\usuario as Usuario;

// Crear la conexión
$app = Aplicacion::getInstance();
$conn = $app->getConexionBd();

$idLibro = $_GET['id'] ?? null;
if (!$idLibro) {
    throw new \Exception("No se ha proporcionado un ID de libro.");
}
// Cargar los datos del libro
$libroSolicitado = Libro::buscaPorId($idLibro);
if (!$libroSolicitado) {
    throw new \Exception("No se encontró el libro con ID: $idLibro");
}

// Verificar la conexión
if ($conn->connect_errno) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

$usuario = Usuario::buscaUsuario($_SESSION['nombre']);

// Consulta para obtener los libros publicados por el usuario
$libros_publicados = Libro::buscaPorPropietario($usuario->getId());

$tituloPagina = 'BookSwap - Crear Intercambio de libro';

$contenidoPrincipal=<<<EOS
    <header>
        <h1>Biblioteca Online</h1>
    </header>
    
    <main>
        <!-- Sección del libro solicitado -->
        <section class="libro-solicitado">
            <h2>Libro Solicitado</h2>
            <div class="card">
                <img src="{$libroSolicitado->getImagen()}" alt="{$libroSolicitado->getTitulo()}">
                <h2>{$libroSolicitado->getTitulo()}</h2>
                <p><strong>Autor:</strong> {$libroSolicitado->getAutor()}</p>
                <p>{$libroSolicitado->getDescripcion()}</p>
                <div class="generos">
                    <span> {$libroSolicitado->getGenero()} </span>                    
                </div>
            </div>
        </section>
        <section class="libros-disponibles">
            <h2> Libros Disponibles</h2>
            <div class="catalogo">       
EOS;        

// Mostrar cada libro en una tarjeta
foreach ($libros_publicados as $libro) {
    $contenidoPrincipal .= <<<EOS
                <div class="card">
                    <img src="{$libro->getImagen()}" alt="{$libro->getTitulo()}">
                    <h2>{$libro->getTitulo()}</h2>
                    <p><strong>Autor:</strong> {$libro->getAutor()}</p>
                    <p>{$libro->getDescripcion()}</p>
                    <div class="generos">
                        <span> {$libro->getGenero()} </span>                    
                    </div>
                </div>
    EOS;
}

$contenidoPrincipal .= <<<EOS
            </div>
        <div class="acciones">
            <button class="aceptar-intercambio" onclick="window.location.href='includes/clases/intercambios/procesarSubidaIntercambio.php?id={$libroSolicitado->getId()}'">Crear intercambio</button>
            <button class="rechazar-intercambio" onclick="window.location.href='catalogo.php'">Cancelar intercambio</button>
        </div>
        </section> 
    </main> 
EOS; 

require __DIR__.'/includes/vistas/plantillas/plantilla.php';

?>