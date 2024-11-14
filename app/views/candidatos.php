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
            <h3>Lista de Candidatos</h3>
            <div class="form-container">
              <button type="button" class="register"><a style="color: white;" href="index.php?action=agregar_candidato" class="Register">Agregar</a></button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Puesto</th>
                        <th>Partido</th>
                        <th>Foto Perfil</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($candidatos as $index => $candidato): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($candidato['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($candidato['apellido']); ?></td>
                        <td>
                        <?php
                            // Obtener lista de puestos activos y marcar el seleccionado
                            $query = "SELECT id_puesto, nombre FROM puestos WHERE estado = 1";
                            $stmt = $this->db->prepare($query);
                            $stmt->execute();
                            $puestos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($puestos as $puesto) {
                                $selected = ($candidato['id_puesto'] == $puesto['id_puesto']) ? 'selected' : '';
                                echo "<option value='" . htmlspecialchars($puesto['id_puesto']) . "' $selected>" . htmlspecialchars($puesto['nombre']) . "</option>";
                            }
                            ?>

                        </td>
                        <td>
                        <?php
                            // Obtener la lista de partidos desde la base de datos
                            $query = "SELECT id_partido, nombre FROM partidos WHERE estado = 1";
                            $stmt = $this->db->prepare($query);
                            $stmt->execute();
                            $partidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($partidos as $partido) {
                                echo "<option value='" . $partido['id_partido'] . "'>" . $partido['nombre'] . "</option>";
                            }
                        ?>

                        </td>
                        <td><?php echo htmlspecialchars($candidato['foto_perfil']); ?></td>
                        <td><?php echo $candidato['estado'] ? '<span class="active">Activo</span>' : '<span class="inactive">Inactivo</span>'; ?></td>
                        <td>
                            <a href="index.php?action=editar_candidato&id=<?php echo $candidato['id_candidato']; ?>" class="edit-icon">✏️</a>
                            <a href="index.php?action=eliminar_candidato&id=<?php echo $candidato['id_candidato']; ?>" class="delete-icon" onclick="return confirm('¿Está seguro de eliminar este candidato?');">🗑️</a>
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
