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
            <div class="chart-box">
            <div class="form-container">
                <h3>Editar ciudadano</h3>
                <form action="index.php?action=actualizar_ciudadano" method="post" enctype="multipart/form-data">
                <input type="hidden" name="cedula" value="<?php echo $ciudadano['cedula']; ?>">

                    <label for="cedula">No intente actualizar la cedula es unico</label>
                    <input type="text" id="cedula" name="cedula" value="<?php echo htmlspecialchars($ciudadano['cedula']); ?>" readonly required><br>

                    <label for="nombre">Ingrese el nombre</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($ciudadano['nombre']); ?>" required><br>

                    <label for="apellido">Ingrese el apellido</label>
                    <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($ciudadano['apellido']); ?>" required><br>

                    <label for="email">Ingrese el email</label>
                    <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($ciudadano['email']); ?>" required><br>

                    <label for="estado">Selecciona un estado:</label>
                    <select name="estado" id="estado">
                        <option value="1" <?php echo ($ciudadano['estado'] == 1) ? 'selected' : ''; ?>>Activo</option>
                        <option value="0" <?php echo ($ciudadano['estado'] == 0) ? 'selected' : ''; ?>>Inactivo</option>
                    </select>        

                    <div class="checkbox-container">
                        <input type="checkbox" id="confirmacion" name="confirmacion" required>
                        <label for="confirmacion">Estas seguro de editar el ciudadano</label>
                    </div>

                    <div class="button-container">
                        <button type="button" class="cancel" onclick="window.location.href='index.php?action=ciudadanos'">Cancelar</button>
                        <button type="submit" class="register">Guardar</button>
                    </div>
                </form>
            </div>
            </div>

        </section>
    </div>
</body>
</html>
