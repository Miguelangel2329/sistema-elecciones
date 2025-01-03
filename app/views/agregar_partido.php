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
                <h3>Registrar un nuevo partido</h3>
                <form action="index.php?action=guardar_partido" method="post" enctype="multipart/form-data">
                    <label for="nombre">Ingrese el nombre</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Ingrese el nombre" required>

                    <label for="descripcion">Ingrese una descripción</label>
                    <textarea id="descripcion" name="descripcion" placeholder="Ingrese una descripcion" required></textarea>

                    <label for="logo">Subir imagen</label>
                    <input type="file" id="logo" name="logo" required>

                    <label for="estado">Selecciona un estado</label>
                    <select id="estado" name="estado" required>
                        <option value="">Selecciona un estado</option>
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>

                    <div class="checkbox-container">
                        <input type="checkbox" id="confirmacion" name="confirmacion" required>
                        <label for="confirmacion">Estas seguro de registrar un nuevo partido</label>
                    </div>

                    <div class="button-container">
                        <button type="button" class="cancel" onclick="window.location.href='index.php?action=partidos'">Cancelar</button>
                        <button type="submit" class="register">Registrar</button>
                    </div>
                </form>
            </div>
            </div>

        </section>
    </div>
</body>
</html>
