<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard principal</title>
    <link rel="stylesheet" href="public/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="public/js/charts.js" defer></script>
</head>
<body>
    <div class="container">
        <!-- Barra lateral -->
         <!-- Barra lateral -->
         <nav class="sidebar">
             <h2>Augusto B Leguia</h2>
             <ul>
                <div>
                 <li><a href="index.php?action=dashboard" class="<?php echo ($_GET['action'] == 'dashboard' ? 'active' : ''); ?>">Dashboard</a></li>
                </div>
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

            <div class="stats">
                <div class="stat-box">
                    <h3>Total usuarios</h3>
                    <p><?php echo $totalUsuarios; ?></p>
                </div>
                <div class="stat-box">
                    <h3>Total votados</h3>
                    <p><?php echo $totalVotados; ?></p>
                </div>
                <div class="stat-box">
                    <h3>Sin votar</h3>
                    <p><?php echo $sinVotar; ?></p>
                </div>
                <div class="stat-box">
                    <h3>En blanco</h3>
                    <p><?php echo $votosEnBlanco; ?></p>
                </div>
            </div>

            <!-- Gráficos -->
            <div class="charts">
                <div class="chart-box">
                    <h3>Candidatos</h3>
                    <canvas id="candidatosChart" 
                            data-chart-data='<?php echo json_encode([
                                "labels" => array_column($candidatosData, 'candidato'), 
                                "values" => array_column($candidatosData, 'votos'),
                                "colors" => ['#f1c40f', '#e74c3c', '#3498db', '#9b59b6', '#2ecc71', '#e67e22']
                            ]); ?>'></canvas>
                </div>
                <div class="chart-box">
                    <h3>Gráfica de las elecciones</h3>
                    <div class="doughnut-charts">
                        <div class="doughnut-chart-item">
                            <canvas id="sinVotarChart" 
                                    data-chart-data='<?php echo json_encode([
                                        "label" => "Sin votar",
                                        "value" => round($porcentajeSinVotar, 2),
                                        "color" => "#e74c3c"
                                    ]); ?>'></canvas>
                            <div class="chart-label">Sin votar</div>
                        </div>
                        <div class="doughnut-chart-item">
                            <canvas id="enBlancoChart" 
                                    data-chart-data='<?php echo json_encode([
                                        "label" => "En blanco",
                                        "value" => round($porcentajeEnBlanco, 2),
                                        "color" => "#2ecc71"
                                    ]); ?>'></canvas>
                            <div class="chart-label">En blanco</div>
                        </div>
                        <div class="doughnut-chart-item">
                            <canvas id="totalVotadosChart" 
                                    data-chart-data='<?php echo json_encode([
                                        "label" => "Total votados",
                                        "value" => round($porcentajeTotalVotados, 2),
                                        "color" => "#3498db"
                                    ]); ?>'></canvas>
                            <div class="chart-label">Total votados</div>
                        </div>
                    </div>
                </div> <br>
            </div

            <!-- Lista de alumnos -->
            <div class="students-list">
                <h3>Lista de alumnos</h3>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>DNI</th>
                            <th>Grado</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Correo</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ciudadanos as $index => $ciudadano): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $ciudadano['cedula']; ?></td>
                            <td><?php echo $ciudadano['Grado']; ?></td>
                            <td><?php echo $ciudadano['nombre']; ?></td>
                            <td><?php echo $ciudadano['apellido']; ?></td>
                            <td><?php echo $ciudadano['email']; ?></td>
                            <td><?php echo $ciudadano['estado'] ? '<span class="active">Activo</span>' : '<span class="inactive">Inactivo</span>'; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</body>
</html>
