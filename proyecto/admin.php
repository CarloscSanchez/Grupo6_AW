<?php
require_once __DIR__.'/includes/config.php';

use \includes\clases\productos\libro as Libro;
use \includes\clases\productos\evento as Evento;
use \includes\clases\usuarios\usuario as Usuario;

// Verificar si el usuario es un administrador
if (!isset($_SESSION['esAdmin']) || $_SESSION['esAdmin'] !== true) {
    header("Location: login.php");
    exit();
}

// Obtener la lista de usuarios
$usuarios = Usuario::buscaPorTipo('normal');

// Generar la tabla de usuarios
$tabla_usuarios = '';
if ($usuarios) {
    foreach ($usuarios as $usuario) {
        $tabla_usuarios .= "<tr>";
        $tabla_usuarios .= "<td>" . $usuario->getId() . "</td>";
        $tabla_usuarios .= "<td>" . $usuario->getNombre() . "</td>";
        $tabla_usuarios .= "<td>" . $usuario->getCorreo() . "</td>";
        $tabla_usuarios .= "<td> normal </td>";
        $tabla_usuarios .= "<td><a href='includes/clases/usuarios/eliminarUsuario.php?id=" . $usuario->getId() . "'>Eliminar</a></td>";
        $tabla_usuarios .= "</tr>";
    }
} else {
    $tabla_usuarios .= "<tr><td colspan='5'>No hay usuarios registrados.</td></tr>";
}

// Consultar la lista de libros
$libros = Libro::getLibros();

// Generar la tabla de libros
$tabla_libros = '';
if ($libros) {
    foreach($libros as $libro) {
        $tabla_libros .= "<tr>";
        $tabla_libros .= "<td>" . $libro->getId() . "</td>";
        $tabla_libros .= "<td>" . $libro->getTitulo() . "</td>";
        $tabla_libros .= "<td>" . $libro->getAutor() . "</td>";
        $tabla_libros .= "<td><a href='includes/clases/productos/procesarBorrarLibro.php?id=" . $libro->getId() . "'>Eliminar</a></td>";
        $tabla_libros .= "</tr>";
    }
} else {
    $tabla_libros .= "<tr><td colspan='4'>No hay libros registrados.</td></tr>";
}

// Consultar la lista de eventos
$eventos = Evento::getEventos();

// Generar la tabla de eventos
$tabla_eventos = '';
if ($eventos) {
    foreach ($eventos as $evento) {
        $tabla_eventos .= "<tr>";
        $tabla_eventos .= "<td>" . $evento->getId() . "</td>";
        $tabla_eventos .= "<td>" . $evento->getNombre() . "</td>";
        $tabla_eventos .= "<td>" . $evento->getFecha() . "</td>";
        $tabla_eventos .= "<td>" . $evento->getHora() . "</td>";
        $tabla_eventos .= "<td>" . $evento->getLugar() . "</td>";
        $tabla_eventos .= "<td>
            <a href='includes/clases/productos/procesarBorrarEvento.php?id=" . $evento->getId() . "'>Eliminar</a> |
            <a href='editarEvento.php?id=" . $evento->getId() . "'>Editar</a>
        </td>";
        $tabla_eventos .= "</tr>";
    }
} else {
    $tabla_eventos .= "<tr><td colspan='6'>No hay eventos registrados.</td></tr>";
}

$tituloPagina = 'BookSwap - Admin';
$contenidoPrincipal = <<<EOS
<div class="admin-container">
    <h2 class="admin-subtitle">Listado de Usuarios</h2>
    <div class="admin-table-wrapper">
        <table class="admin-table">
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
                $tabla_usuarios
            </tbody>
        </table>
    </div>

    <h2 class="admin-subtitle">Listado de Libros</h2>
    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                $tabla_libros
            </tbody>
        </table>
    </div>

    <h2 class="admin-subtitle">Listado de Eventos</h2>
    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Lugar</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                $tabla_eventos
            </tbody>
        </table>
    </div>

    <div class="add-event-button-wrapper">
        <a href="subirEvento.php" class="admin-btn editar">Añadir Evento</a>
    </div>
</div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
?>