<div class="navbar">
    <!-- Sección izquierda: Logo + Nombre de la app -->
    <div class="navbar-left">
        <a href="index.php">  <!-- Enlace a la página principal -->
            <img src="img/logo_icono.ico" alt="Logo" class="logo">
            <span>BookSwap</span>
        </a>
    </div>

    <!-- Sección central: Enlaces de la web -->
    <div class="navbar-links">
        <ul>
            <li><a href="detalles.php">Más detalles</a></li>
            <li><a href="miembros.php">Conócenos</a></li>
            <li><a href="contacto.php">¡Contáctanos!</a></li>
            <li><a href="bocetos.php">Bocetos</a></li>
            <li><a href="planificacion.php">Planificación</a></li>
        </ul>
    </div>

    <!-- Sección derecha: Login/Register o LogOut/Profile -->
    <div class="navbar-right">
        <?php if (!isset($_SESSION['usuario'])): ?>
            <!-- Si el usuario no está logueado, muestra Login y Register -->
            <a href="login.php" class="nav-item">Login</a>
            <a href="registro.php" class="nav-item">Register</a>
        <?php else: ?>
            <!-- Si el usuario está logueado, muestra LogOut y el ícono del perfil -->
            <a href="perfil.php" class="nav-item">
                <img src="img/carlos.jpg" alt="Perfil" class="profile-icon">
            </a>
            <a href="logout.php" class="nav-item">Log Out</a>
        <?php endif; ?>
    </div>
</div>
