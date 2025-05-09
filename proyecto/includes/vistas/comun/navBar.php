<?php
require_once __DIR__ . '/../../config.php';

use \includes\clases\usuarios\usuario;

$imagenPerfil = null;

if (isset($_SESSION['nombre'])) {
    $usuario =Usuario::buscaUsuario($_SESSION['nombre']);
    if ($usuario) {
        $imagenPerfil = $usuario->getUrlImagen() ?? "img/perfil_default.png";
    }
}

$imagenPerfil = htmlspecialchars($imagenPerfil);
?>


<div class="navbar">
    <!-- Sección izquierda: Logo + Nombre de la app -->
    <div class="navbar-left">
        <a href="index.php">  <!-- Enlace a la página principal -->
            <img src="img/logo_icono.ico" alt="Logo" class="logo">
            <span>BookSwap</span>
        </a>
    </div>
    
    <!-- Sección derecha: Login/Register o LogOut/Profile -->
    <div class="navbar-right">
        <?php if (!isset($_SESSION['nombre'])): ?>
            <!-- Si el usuario no está logueado, muestra Login y Register -->
            <a href="login.php" class="nav-item">Login</a>
            <a href="registro.php" class="nav-item">Register</a>
        <?php else: ?>
            <!-- Si el usuario está logueado, muestra LogOut y el ícono del perfil -->
            <a href="perfil.php" class="nav-item">
                <img src="<?=$imagenPerfil?>" alt="Perfil" class="profile-icon">
            </a>
            <a href="includes/clases/usuarios/procesarLogout.php" class="nav-item">Log Out</a>
        <?php endif; ?>
    </div>
</div>
