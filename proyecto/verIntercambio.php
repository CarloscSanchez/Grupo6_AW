<?php
require __DIR__.'/includes/config.php';

use \includes\aplicacion as Aplicacion;
use \includes\clases\productos\Libro as Libro;
use \includes\clases\usuarios\usuario as Usuario;
use \includes\clases\intercambios\intercambio as Intercambio;

// Crear la conexión
$app = Aplicacion::getInstance();
$conn = $app->getConexionBd();


// Verificar la conexión
if ($conn->connect_errno) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

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
    throw new \Exception("No se encontró el libro con ID: {$libroSolicitado->getId()}");
}
$libroOfrecido = Libro::buscaPorId($intercambio->getIdLibroOfrecido());



$solicitante = Usuario::buscaPorId($intercambio->getIdSolicitante());
if (!$solicitante) {
    throw new \Exception("No se encontró el usuario solicitante.");
}
$propietario = Usuario::buscaPorId($intercambio->getIdPropietario());
if (!$propietario) {
    throw new \Exception("No se encontró el propietario del libro.");
}

$tituloPagina = 'BookSwap - Intercambio de libro';

$fecha = $intercambio->getFechaIntercambio();
if(!$fecha){
    $fecha = 'No se ha establecido una fecha para este intercambio.';
}
$contenidoPrincipal=<<<EOS
    <header>
        <h1>Biblioteca Online</h1>
        <h2>Estado del intercambio: {$intercambio->getEstado()}</h2>
        <h2>Fecha: {$fecha}</h2>
    </header>
    
    <main>
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

        <!-- Sección del libro ofrecido -->
        <section class="libros-disponibles">
            <h2>Libro Ofrecido</h2>
EOS;

if(!$libroOfrecido){
    $contenidoPrincipal .=<<<EOS
            <h3>El intercambio fue rechazado</h3>
            </section>
        </main> 
    EOS;
}
else{
$contenidoPrincipal .=<<<EOS
            <div class="card">
                <img src="{$libroOfrecido->getImagen()}" alt="{$libroOfrecido->getTitulo()}">
                <h2>{$libroOfrecido->getTitulo()}</h2>
                <p><strong>Autor:</strong> {$libroOfrecido->getAutor()}</p>
                <p>Solicitante: {$solicitante->getNombre()}</p>
                <div class="generos">
                    <span> {$libroOfrecido->getGenero()} </span>                    
                </div>
            </div>
        </section>
    </main> 
EOS; 
}




require __DIR__.'/includes/vistas/plantillas/plantilla.php';

?>