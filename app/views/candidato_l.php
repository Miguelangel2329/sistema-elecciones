<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataforma Electoral ABL</title>
    <link rel="stylesheet" href="public/css/home.css">
    <link rel="stylesheet" href="public/css/list_candidatos.css">

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
        <a href="index.php?action=candid" class="nav-item active">Candidatos</a>
        <a href="index.php?action=ganadores" class="nav-item">Resultados</a>
    </nav> <br> <br>

    <!-- Contenido principal -->
    <section class="candidatos-container"> <br>
        <?php if (!empty($candidatos)): ?>
            <?php foreach ($candidatos as $candidato): ?>
                <div class="candidato-card"><br>
                <img src="public/images/<?php echo htmlspecialchars($candidato['foto_perfil'] ?? 'default.jpg'); ?>" alt="Foto del candidato" class="logo-partido">
                <h3><?php echo htmlspecialchars($candidato['nombre_candidato'] ?? '') . ' ' . htmlspecialchars($candidato['apellido'] ?? ''); ?></h3>
                <p>Partido: <?php echo htmlspecialchars($candidato['nombre_partido'] ?? ''); ?></p>
                <p>Puesto: <?php echo htmlspecialchars($candidato['puesto'] ?? ''); ?></p> <br>
    
                <!-- Botón que enlaza a la sección detallada -->
                <a href="#detalles-candidato-<?php echo $candidato['id_candidato']; ?>" class="btn-secondary">Ver más</a>
            </div>

            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay candidatos disponibles.</p>
        <?php endif; ?>
    </section>

    <H2 class="navbar-1">Datos de los partidos</H2>

    <div class="candidatos-container">
    <?php foreach ($candidatos as $candidato): ?>
        <div id="detalles-candidato-<?php echo $candidato['id_candidato']; ?>" class="btn-secondary">
            <h3>Detalles de <?php echo htmlspecialchars($candidato['nombre_candidato'] ?? '') . ' ' . htmlspecialchars($candidato['apellido'] ?? ''); ?></h3>
            <p><strong>ID Candidato:</strong> <?php echo htmlspecialchars($candidato['id_candidato'] ?? ''); ?></p>
            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($candidato['nombre_candidato'] ?? ''); ?></p>
            <p><strong>Apellido:</strong> <?php echo htmlspecialchars($candidato['apellido'] ?? ''); ?></p>
            <p><strong>ID Partido:</strong> <?php echo htmlspecialchars($candidato['id_partido'] ?? ''); ?></p>
            <p><strong>ID Puesto:</strong> <?php echo htmlspecialchars($candidato['id_puesto'] ?? ''); ?></p>
            <p><strong>Estado:</strong> <?php echo isset($candidato['estado']) ? ($candidato['estado'] == 1 ? 'Activo' : 'Inactivo') : ''; ?></p>
            <p><strong>Tenis - Nombre:</strong> <?php echo htmlspecialchars($candidato['nom_teni'] ?? ''); ?></p>
            <p><strong>Tenis - Grado:</strong> <?php echo htmlspecialchars($candidato['gra_teni'] ?? ''); ?></p>
            <p><strong>Salud - Nombre:</strong> <?php echo htmlspecialchars($candidato['nom_salu'] ?? ''); ?></p>
            <p><strong>Salud - Grado:</strong> <?php echo htmlspecialchars($candidato['gra_salu'] ?? ''); ?></p>
            <p><strong>Educación - Nombre:</strong> <?php echo htmlspecialchars($candidato['nom_educ'] ?? ''); ?></p>
            <p><strong>Educación - Grado:</strong> <?php echo htmlspecialchars($candidato['gra_educ'] ?? ''); ?></p>
            <p><strong>Derecho - Nombre:</strong> <?php echo htmlspecialchars($candidato['nom_dere'] ?? ''); ?></p>
            <p><strong>Derecho - Grado:</strong> <?php echo htmlspecialchars($candidato['gra_dere'] ?? ''); ?></p>
            <p><strong>Comunicación - Nombre:</strong> <?php echo htmlspecialchars($candidato['nom_comu'] ?? ''); ?></p>
            <p><strong>Comunicación - Grado:</strong> <?php echo htmlspecialchars($candidato['gra_comu'] ?? ''); ?></p>
            <p><strong>Emprendimiento - Nombre:</strong> <?php echo htmlspecialchars($candidato['nom_empr'] ?? ''); ?></p>
            <p><strong>Emprendimiento - Grado:</strong> <?php echo htmlspecialchars($candidato['gra_empr'] ?? ''); ?></p>
            <p><strong>Plan de Trabajo:</strong> <?php echo htmlspecialchars($candidato['plan_trab'] ?? ''); ?></p>
            <hr>
        </div>
    <?php endforeach; ?>
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
