<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BookSwap</title>
</head>
<body>

    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form action="procesar_login.php" method="POST">
            <!-- Input nombre usuario-->
            <div class="input-group">
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" required>
            </div>
            <!-- Input contraseña-->
            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>

            <!-- Enviar formulario -->
            <button type="submit" class="btn-login">Login</button>

            <?php
            // Mensaje de error si el login falla
            if (isset($_GET['error']) && $_GET['error'] === "1") {
                echo "<p style='color: red;'>Usuario o contraseña incorrectos.</p>";
            }
            ?>
        </form>

        <div class="extra-links">
            <a href="recuperar_contraseña.php">¿Has olvidado tu contraseña?</a>
            <br>
            <a href="registro.php">¿Todavía no tienes cuenta? Regístrate</a>
        </div>
    </div>

</body>
</html>
