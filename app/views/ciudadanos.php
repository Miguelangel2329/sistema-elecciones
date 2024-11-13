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

            <!-- Formulario de búsqueda -->
            <div class="search-container">
                <form action="index.php" method="GET">
                    <input type="hidden" name="action" value="ciudadanos">
                    <input type="text" name="buscar" placeholder="Buscar por nombre, apellido o cédula" value="<?php echo isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : ''; ?>">
                    <button type="submit">Buscar</button>
                </form>
            </div><br>

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
            <h3>Lista de Ciudadanos</h3>
            <div class="button-container">
              <a href="index.php?action=agregar_ciudadano" class="Register">Agregar</a>
              <button type="button" class="cancel"><a href="index.php?action=agregar_ciudadano" class="Register">Agregar</a></button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Cedula</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>email</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ciudadanos as $index => $ciudadano): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($ciudadano['cedula']); ?></td>
                        <td><?php echo htmlspecialchars($ciudadano['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($ciudadano['apellido']); ?></td>
                        <td><?php echo htmlspecialchars($ciudadano['email']); ?></td>
                        <td><?php echo $ciudadano['estado'] ? '<span class="active">Activo</span>' : '<span class="inactive">Inactivo</span>'; ?></td>
                        <td>
                            <a href="index.php?action=editar_ciudadano&id=<?php echo $ciudadano['cedula']; ?>" class="edit-icon">✏️</a>
                            <a href="index.php?action=eliminar_ciudadano&id=<?php echo $ciudadano['cedula']; ?>" class="delete-icon" onclick="return confirm('¿Está seguro de eliminar este ciudadano?');">🗑️</a>
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
