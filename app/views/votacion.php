<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataforma Electoral ABL</title>
    <link rel="stylesheet" href="public/css/home.css">
</head>
<body>
    <!-- Encabezado -->
    <header class="header">
        <img src="public/images/aprista.jpg" alt="Logo" class="logo">
        <h1>PLATAFORMA ELECTORAL ABL</h1>
    </header><br>
    
    <div class="center-container"> <!-- Cambiado 'clase' a 'class' -->
        <div class="center-prin">
            <h2>Ingrese su cédula</h2>
            <form action="index.php?action=votacion" method="POST">
                <input class="btn-secondary" type="text" name="cedula" placeholder="Cédula" required>
                <button type="submit" class="btn-primary">Ingresar</button>
            </form>
            <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        </div>
    </div>

    <!-- Pie de página -->
    <footer class="footer">
        <img src="public/images/sdfg.jpg" alt="Logo" class="footer-logo">
        <p>PLATAFORMA ELECTORAL ABL</p>
        <div class="footer-info">
            <p><i class="fab fa-facebook"></i> Augusto B Leguía</p>
            <p><i class="fas fa-map-marker-alt"></i> Jirón Manchego Muñoz 247, Nuevo Imperial 15723</p>
        </div>
    </footer>
</body>
</html>
