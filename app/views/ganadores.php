<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataforma Electoral ABL</title>
    <link rel="stylesheet" href="public/css/ganador.css">

</head>
<body>
    <!-- Encabezado -->
    <header class="header">
        <img src="public/images/aprista.jpg" alt="Logo" class="logo">
        <h1>PLATAFORMA ELECTORAL ABL</h1>
    </header>

    <!-- Barra de navegación -->
    <nav class="navbar">
        <a href="index.php?action=home" class="nav-item">Home</a>
        <a href="index.php?action=candid" class="nav-item">Candidatos</a>
        <a href="index.php?action=ganadores" class="nav-item active">Resultados</a>
    </nav> <br>

    <!-- Contenido principal -->
     <div class="navbar-1">
        <h1>Ganador de la Elección: <?php echo htmlspecialchars($eleccion['nombre']); ?></h1>
     </div>
    <section class="main-content">
    <section class="center-prin">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Candidato</th>
                    <th>Partido</th>
                    <th>Puesto</th>
                    <th>Total de Votos</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($candidatos as $index => $candidato): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($candidato['candidato']); ?></td>
                        <td><?php echo htmlspecialchars($candidato['partido']); ?></td>
                        <td><?php echo htmlspecialchars($candidato['puesto']); ?></td>
                        <td><?php echo htmlspecialchars($candidato['total_votos']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
    </section><br><br><br><br><br><br><br><br><br><br>

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
