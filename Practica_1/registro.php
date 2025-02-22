<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - BookSwap</title>
</head>
<body>

    <div class="login-container">  <!-- Mismo estilo que el login -->
        <h2>Crear una cuenta</h2>
        <form action="procesar_registro.php" method="POST">
            <!-- Input nombre usuario-->
            <div class="input-group">
                <label for="usuario">Nombre de Usuario</label>
                <input type="text" id="usuario" name="usuario" required>
            </div>
            <!-- Input correo electrónico-->
            <div class="input-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" required>
            </div>
            <!-- Input contraseña-->
            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>
            <!-- Input repetir contraseña-->
            <div class="input-group">
                <label for="repassword">Repetir Contraseña</label>
                <input type="password" id="repassword" name="repassword" required>
            </div>
            <!-- Botón enviar formulario-->
            <button type="submit" class="btn-login">Registrarse</button> <!-- Mismo estilo que el login -->
        </form>

        <div class="extra-links">
            <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
        </div>
    </div>

</body>
</html>
