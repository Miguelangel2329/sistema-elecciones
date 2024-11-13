<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Candidato</title>
    <link rel="stylesheet" href="public/css/partidos.css">
</head>
<body>
<div class="container">
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
            <h1>Editar Candidato</h1>
            <div class="user-info">
                <span>Marci Fumons</span>
            </div>
        </header>
        <div class="form-container">
            <h3>Editar un candidato existente</h3>
            <form action="index.php?action=actualizar_candidato" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_candidato" value="<?php echo $candidato['id_candidato']; ?>">

                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($candidato['nombre']); ?>" required><br>

                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($candidato['apellido']); ?>" required><br>

                <label for="id_partido">Selecciona el partido</label>
                <select id="id_partido" name="id_partido" required>
                    <option value="">Selecciona un partido</option>
                    <?php
                    // Obtener lista de partidos activos y marcar el seleccionado
                    $query = "SELECT id_partido, nombre FROM partidos WHERE estado = 1";
                    $stmt = $this->db->prepare($query);
                    $stmt->execute();
                    $partidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($partidos as $partido) {
                        $selected = ($candidato['id_partido'] == $partido['id_partido']) ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars($partido['id_partido']) . "' $selected>" . htmlspecialchars($partido['nombre']) . "</option>";
                    }
                    ?>
                </select>

                <label for="id_puesto">Selecciona un puesto</label>
                <select id="id_puesto" name="id_puesto" required>
                    <option value="">Selecciona un puesto</option>
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
                </select>

                <label for="foto_perfil">Imagen de perfil:</label>
                <input type="file" name="foto_perfil" id="foto_perfil">
                <p>Imagen actual: 
                    <?php if (!empty($candidato['foto_perfil'])): ?>
                        <img src="public/images/<?php echo htmlspecialchars($candidato['foto_perfil']); ?>" alt="Foto de perfil" width="100">
                   <?php else: ?>
                       No hay imagen.
                    <?php endif; ?>
                </p>
                <input type="hidden" name="foto_perfil_actual" value="<?php echo htmlspecialchars($candidato['foto_perfil']); ?>"><br>

                <label for="estado">Estado:</label>
                <select name="estado" id="estado">
                    <option value="1" <?php echo ($candidato['estado'] == 1) ? 'selected' : ''; ?>>Activo</option>
                    <option value="0" <?php echo ($candidato['estado'] == 0) ? 'selected' : ''; ?>>Inactivo</option>
                </select>


                <!-- Campos adicionales de información del candidato -->
                <label for="nom-teni">Nombre del Teniente Alcalde</label>
                <input type="text" id="nom-teni" name="nom-teni" value="<?php echo htmlspecialchars($candidato['nom_teni']); ?>" required><br>

                <label for="gra-teni">Grado actual del Teniente</label>
                <textarea id="gra-teni" name="gra-teni" required><?php echo htmlspecialchars($candidato['gra_teni']); ?></textarea><br>

                <label for="nom-salu">Nombre del(a) Regidor(a) de Salud</label>
                <input type="text" id="nom-salu" name="nom-salu" value="<?php echo htmlspecialchars($candidato['nom_salu']); ?>" required><br>

                <label for="gra-salu">Grado actual del(a) Regidor(a) de Salud</label>
                <textarea id="gra-salu" name="gra-salu" required><?php echo htmlspecialchars($candidato['gra_salu']); ?></textarea><br>

                <label for="nom-educ">Nombre del(a) Regidor(a) de Educación</label>
                <input type="text" id="nom-educ" name="nom-educ" value="<?php echo htmlspecialchars($candidato['nom_educ']); ?>" required><br>

                <label for="gra-educ">Grado actual del(a) Regidor(a) de Educación</label>
                <textarea id="gra-educ" name="gra-educ" required><?php echo htmlspecialchars($candidato['gra_educ']); ?></textarea><br>

                <label for="nom-dere">Nombre del(a) Regidor(a) de Derechos</label>
                <input type="text" id="nom-dere" name="nom-dere" value="<?php echo htmlspecialchars($candidato['nom_dere']); ?>" required><br>

                <label for="gra-dere">Grado actual del Derecho</label>
                <textarea id="gra-dere" name="gra-dere" required><?php echo htmlspecialchars($candidato['gra_dere']); ?></textarea><br>

                <label for="nom-comu">Nombre del(a) Regidor(a) de comunicacion</label>
                <input type="text" id="nom-comu" name="nom-comu" value="<?php echo htmlspecialchars($candidato['nom_comu']); ?>" required><br>

                <label for="gra-comu">Grado actual del(a) Regidor(a) de comunicacion</label>
                <textarea id="gra-comu" name="gra-comu" required><?php echo htmlspecialchars($candidato['gra_comu']); ?></textarea><br>

                <label for="nom-empr">Nombre del(a) Regidor(a) de emprendimiento</label>
                <input type="text" id="nom-empr" name="nom-empr" value="<?php echo htmlspecialchars($candidato['nom_empr']); ?>" required><br>

                <label for="gra-empr">Grado actual del(a) Regidor(a) de emprendimento</label>
                <textarea id="gra-empr" name="gra-empr" required><?php echo htmlspecialchars($candidato['gra_empr']); ?></textarea><br>


                <label for="plan-trab">Plan de Trabajo</label>
                <textarea id="plan-trab" name="plan-trab" required><?php echo htmlspecialchars($candidato['plan_trab']); ?></textarea><br>

                <div class="checkbox-container">
                    <input type="checkbox" id="confirmacion" name="confirmacion" required>
                    <label for="confirmacion">Confirmo la edición del candidato</label>
                </div>

                <div class="button-container">
                    <button type="button" class="cancel" onclick="window.location.href='index.php?action=candidatos'">Cancelar</button>
                    <button type="submit" class="register">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </section>
</div>
</body>
</html>
