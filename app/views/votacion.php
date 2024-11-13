<!-- votacion.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Votación</title>
    <link rel="stylesheet" href="public/css/list_candidatos.css">
</head>
<body>
    <h2>Ingrese su cédula</h2>
    <form action="index.php?action=votacion" method="POST">
        <input type="text" name="cedula" placeholder="Cédula" required>
        <button type="submit">Ingresar</button>
    </form>
    <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
</body>
</html>
