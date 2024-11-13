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
                <h3>Editar el puesto</h3>
                    <form action="index.php?action=actualizar_puesto" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_puesto" value="<?php echo $puesto['id_puesto']; ?>">
        
                        <label for="nombre">Nombre del puesto:</label>
                        <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($puesto['nombre']); ?>" required><br>
        
                        <label for="descripcion">Descripción:</label>
                        <textarea name="descripcion" id="descripcion" required><?php echo htmlspecialchars($puesto['descripcion']); ?></textarea><br>
                
                        <label for="estado">Selecciona un estado:</label>
                        <select name="estado" id="estado">
                            <option value="1" <?php echo ($puesto['estado'] == 1) ? 'selected' : ''; ?>>Activo</option>
                            <option value="0" <?php echo ($puesto['estado'] == 0) ? 'selected' : ''; ?>>Inactivo</option>
                        </select>        
                        <label>
                            <input type="checkbox" name="confirmar" required>
                            Estas seguro de registrar estos nuevos cambios
                        </label>
                        <div class="button-container">
                           <button class="register" type="submit">Guardar</button>
                           <button type="button" class="cancel" onclick="window.location.href='index.php?action=puestos'">Cancelar</button>
                        </div>
                    </form>
            </div>
            </div>

        </section>
    </div>
</body>
</html>
