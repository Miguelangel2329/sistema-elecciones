<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Partidos</title>
    <link rel="stylesheet" href="public/css/partidos.css">
</head>
<body>
<div class="container">
        <!-- Barra lateral -->
         <!-- Barra lateral -->
         <nav class="sidebar">
             <h2>Augusto B Leguia</h2>
             <ul>
                 <li><a href="index.php?action=dashboard" class="<?php echo ($_GET['action'] == 'dashboard' ? 'active' : ''); ?>">Dashboard</a></li>
                 <li><a href="index.php?action=partidos" class="<?php echo ($_GET['action'] == 'partidos' ? 'active' : ''); ?>">Partidos</a></li>
                 <li><a href="index.php?action=puestos" class="<?php echo ($_GET['action'] == 'puestos' ? 'active' : ''); ?>">Puesto electivo</a></li>
                 <li><a href="index.php?action=candidatos" class="<?php echo ($_GET['action'] == 'candidatos' ? 'active' : ''); ?>">Candidatos</a></li>
                 <li><a href="index.php?action=ciudadanos" class="<?php echo ($_GET['action'] == 'ciudadanos' ? 'active' : ''); ?>">Ciudadanos</a></li>
                 <li><a href="index.php?action=elecciones" class="<?php echo ($_GET['action'] == 'elecciones' ? 'active' : ''); ?>">Elecciones</a></li>
             </ul>
             <a href="index.php?action=logout" class="logout">Log out</a>
         </nav>


        <!-- Sección principal -->
        <section class="main">
            <header>
                <h1>Bienvenidos(as) al panel de control</h1>
                <div class="user-info">
                    <span>Marci Fumons</span>
                </div>
            </header>
            <!-- Mensajes de éxito o error -->
             <!-- Mensajes de éxito o error -->
        <?php if (isset($_GET['mensaje'])): ?>
            <div class="alert success">
                <?php 
                if ($_GET['mensaje'] == 'eliminado_exitosamente') {
                    echo 'El partido se ha eliminado exitosamente.';
                } elseif ($_GET['mensaje'] == 'actualizado_exitosamente') {
                    echo 'El partido se ha actualizado exitosamente.';
                } else {
                    echo 'La eleccion a iniciado exitosamente.';
                }
                ?>
            </div>
        <?php elseif (isset($_GET['error']) && $_GET['error'] == 'no_se_puede_eliminar'): ?>
            <div class="alert error">No se puede eliminar el partido porque tiene datos relacionados.</div>
        <?php endif; ?>

        <div class="chart-box">
            <div class="button-container">
            <?php
                $hayEleccionActiva = false;
                foreach ($elecciones as $eleccion) {
                    if ($eleccion['estado'] == 1) {
                        $hayEleccionActiva = true;
                        break;
                    }
                }
                ?>

                <h1>Panel de Elecciones</h1>

                <?php if ($hayEleccionActiva): ?>
                    <a href="index.php?action=terminar_eleccion" class="btn">Terminar Elecciones</a>
                <?php else: ?>
                    <a href="index.php?action=iniciar_eleccion" class="btn">Iniciar Elecciones</a>
                <?php endif; ?>

            </div>
            <?php foreach ($elecciones as $eleccion): ?>
        <div class="eleccion-container">
            <h2>Elección: <?php echo htmlspecialchars($eleccion['nombre']); ?></h2>
            <p>Fecha: <?php echo htmlspecialchars($eleccion['fecha']); ?></p>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Candidato</th>
                        <th>Partido</th>
                        <th>Puesto</th>
                        <th>Total de votos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($eleccion['candidatos'] as $index => $candidato): ?>
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
        </div>
        <hr>
    <?php endforeach; ?>
        </div>
        </section>
    </div>
</body>
</html>
