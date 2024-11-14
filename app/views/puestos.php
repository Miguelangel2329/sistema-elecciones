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
                    echo 'El partido se ha registrado exitosamente.';
                }
                ?>
            </div>
        <?php elseif (isset($_GET['error']) && $_GET['error'] == 'no_se_puede_eliminar'): ?>
            <div class="alert error">No se puede eliminar el partido porque tiene datos relacionados.</div>
        <?php endif; ?>

        <div class="chart-box">
            <h3>Lista de Puesto</h3>
            <div class="form-container">
              <button type="button" class="register"><a href="index.php?action=agregar_puesto" style="color: white;">Agregar</a></button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($puestos as $index => $puesto): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($puesto['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($puesto['descripcion']); ?></td>
                        <td><?php echo $puesto['estado'] ? '<span class="active">Activo</span>' : '<span class="inactive">Inactivo</span>'; ?></td>
                        <td>
                            <a href="index.php?action=editar_puesto&id=<?php echo $puesto['id_puesto']; ?>" class="edit-icon">✏️</a>
                            <a href="index.php?action=eliminar_puesto&id=<?php echo $puesto['id_puesto']; ?>" class="delete-icon" onclick="return confirm('¿Está seguro de eliminar este puesto?');">🗑️</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        </section>
    </div>
</body>
</html>
