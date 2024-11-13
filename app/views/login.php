<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="public/css/login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <h2>BIENVENIDOS</h2>
            <p>¡Bienvenido! Por favor, introduzca sus datos.</p>
            <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
            <form action="index.php?action=login" method="POST">
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" placeholder="Enter your email" required>
                
                <label for="clave">Clave</label>
                <input type="password" id="clave" name="clave" placeholder="********" required>
                
                <div class="remember-me">
                    <input type="checkbox" id="remember">
                    <label for="remember">Remember me</label>
                </div>
                
                <button type="submit">Sign in</button>
            </form>
            <p class="footer-text">Solo los Administradores tienen acceso</p>
        </div>
    </div>
</body>
</html>
