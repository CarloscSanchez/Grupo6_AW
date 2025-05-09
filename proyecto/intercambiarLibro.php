<?php
require __DIR__.'/includes/config.php';

use \includes\aplicacion as Aplicacion;
use \includes\clases\productos\Libro as Libro;
use \includes\clases\usuarios\usuario as Usuario;
use \includes\clases\intercambios\intercambio as Intercambio;

// Crear la conexión
$app = Aplicacion::getInstance();
$conn = $app->getConexionBd();

$idIntercambio = $_GET['id'] ?? null;
if (!$idIntercambio) {
    throw new \Exception("No se ha proporcionado un ID de libro.");
}
// Cargar los datos del libro

$intercambio = Intercambio::buscaPorId($idIntercambio);
if (!$intercambio) {
    throw new \Exception("No se encontró el intercambio con ID: $idIntercambio");
}

$libroSolicitado = Libro::buscaPorId($intercambio->getIdLibroSolicitado());
if (!$libroSolicitado) {
    throw new \Exception("No se encontró el libro con ID: $idLibro");
}

// Verificar la conexión
if ($conn->connect_errno) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

$solicitante = Usuario::buscaPorId($intercambio->getIdSolicitante());
if (!$solicitante) {
    throw new \Exception("No se encontró el usuario solicitante.");
}
$propietario = Usuario::buscaPorId($intercambio->getIdPropietario());
if (!$propietario) {
    throw new \Exception("No se encontró el propietario del libro.");
}

$tituloPagina = 'BookSwap - Intercambio de libro';

$contenidoPrincipal=<<<EOS
    <header>
        <h1>Biblioteca Online</h1>
        <h2>Estado del intercambio: {$intercambio->getEstado()}</h2>
    </header>
    
    
        <!-- Sección del libro solicitado -->
        <section class="libro-solicitado">
            <h2>Libro Solicitado</h2>
            <div class="card">
                <img src="{$libroSolicitado->getImagen()}" alt="{$libroSolicitado->getTitulo()}">
                <h2>{$libroSolicitado->getTitulo()}</h2>
                <p><strong>Autor:</strong> {$libroSolicitado->getAutor()}</p>
                <p>Solicitante: {$propietario->getNombre()}</p>
                <div class="generos">
                    <span> {$libroSolicitado->getGenero()} </span>                    
                </div>
            </div>
        </section>
EOS;


if($propietario->getNombre() == $_SESSION['nombre']){
    $libros_publicados = Libro::buscaPorPropietario($solicitante->getId());

    $contenidoPrincipal .=<<<EOS
        <section class="libros-disponibles">
            <h2> Libros Disponibles</h2>
            <div class="catalogo">       
    EOS;        

    // Mostrar cada libro en una tarjeta
    foreach ($libros_publicados as $libro) {
        $idLibro = $libro->getId();
        $contenidoPrincipal .= <<<EOS
            <div class="card" data-libro-id="{$libro->getId()}">
                <input type="radio" name="libro_seleccionado" value="{$libro->getId()}" class="input-libro" style="display: none;">
                <img src="{$libro->getImagen()}" alt="{$libro->getTitulo()}">
                <h2>{$libro->getTitulo()}</h2>
                <p><strong>Autor:</strong> {$libro->getAutor()}</p>
                <p>{$libro->getDescripcion()}</p>
                <div class="generos">
                    <span>{$libro->getGenero()}</span>
                </div>
            </div>
        EOS;
    }

    $contenidoPrincipal .= <<<EOS
                </div>
            <div class="acciones">
                <input type="hidden" name="intercambio_id" value="{$intercambio->getId()}">
                <button class="aceptar-intercambio" id=btnAceptar disabled>Aceptar intercambio</button>
                <button class="rechazar-intercambio" onclick="window.location.href='includes/clases/intercambios/cambiarEstadoIntercambio.php?id={$intercambio->getId()}&estado=rechazado'">Rechazar intercambio</button>
            </div>
            
            </section> 
            <script src="JS/intercambios.js"></script>
    EOS; 
} else{
    $libros_publicados = Libro::buscaPorPropietario($solicitante->getId());

    $contenidoPrincipal .=<<<EOS
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
                <button class="rechazar-intercambio" onclick="window.location.href='includes/clases/intercambios/cambiarEstadoIntercambio.php?id={$intercambio->getId()}&estado=cancelado'">Cancelar intercambio</button>
            </div>
            </section> 
    EOS; 

}




require __DIR__.'/includes/vistas/plantillas/plantilla.php';

?>
