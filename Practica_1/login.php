<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BookSwap</title>
    <link rel="stylesheet" href="CSS/estilos.css"> <!-- Archivo CSS externo -->
</head>
<body>

    <!-- Incluir la barra de navegación -->
    <?php include 'includes/vistas/comun/navbar.php'; ?>
    
    <div class="login-body">
        <div class="login-container">
            <h2>Iniciar Sesión</h2>
            
            <!-- Formulario de login -->
            <form action="procesar_login.php" method="POST">
                <!-- Campos de usuario y contraseña -->
                <div class="input-group">
                    <label for="usuario">Usuario</label>
                    <input type="text" id="usuario" name="usuario" required>
                </div>
                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <!-- Mensaje de error -->
                <div class="error-msg">
                    <?php
                    if (isset($_GET['error'])) {
                        echo "Usuario o contraseña incorrectos";
                    }
                    ?>
                </div>

                <!-- Botón de login -->
                <button type="submit" class="btn-login">Login</button>
            </form>

            

            <!-- Enlaces adicionales -->
            <div class="extra-links">
                <a href="recuperar_contraseña.php">¿Has olvidado tu contraseña?</a>
                <br>
                <a href="registro.php">¿Todavía no tienes cuenta? Regístrate</a>
            </div>
        </div>
    </div>
   

</body>
</html>
