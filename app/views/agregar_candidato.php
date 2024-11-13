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
                <h3>Registrar un nuevo candidato</h3>
                <form action="index.php?action=guardar_candidato" method="post" enctype="multipart/form-data">
                    <label for="nombre">Ingrese el nombre</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Ingrese el nombre" required>

                    <label for="apellido">Ingrese su apellido</label>
                    <textarea id="apellido" name="apellido" placeholder="Ingrese su apellido" required></textarea>

                    <label for="id_partido">Selecciona el partido</label>
                    <select id="id_partido" name="id_partido" required>
                        <option value="">Selecciona un partido</option>
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
                    </select>

                    <label for="id_puesto">Selecciona un puesto</label>
                    <select id="id_puesto" name="id_puesto" required>
                        <option value="">Selecciona un puesto</option>
                        <?php
                            // Obtener la lista de puestos desde la base de datos
                            $query = "SELECT id_puesto, nombre FROM puestos WHERE estado = 1";
                            $stmt = $this->db->prepare($query);
                            $stmt->execute();
                            $puestos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($puestos as $puesto) {
                                echo "<option value='" . $puesto['id_puesto'] . "'>" . $puesto['nombre'] . "</option>";
                            }
                        ?>
                    </select>

                    <label for="foto_perfil">Subir imagen</label>
                    <input type="file" id="foto_perfil" name="foto_perfil" required>

                    <label for="estado">Selecciona un estado</label>
                    <select id="estado" name="estado" required>
                        <option value="">Selecciona un estado</option>
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>

                    <label for="nom-teni">Ingrese el nombre del teniente alacalde</label>
                    <input type="text" id="nom-teni" name="nom-teni" placeholder="Ingrese el nombre del teniente alacalde" required>

                    <label for="gra-teni">Ingrese en grado actual del teniente</label>
                    <textarea id="gra-teni" name="gra-teni" placeholder="Ingrese en grado actual del teniente" required></textarea>

                    <label for="nom-salu">Ingrese el nombre del(a) regidor(a) de salud</label>
                    <input type="text" id="nom-salu" name="nom-salu" placeholder="Ingrese el nombre del(a) regidor(a) salud" required>

                    <label for="gra-salu">Ingrese en grado actual del(a) regidor(a) de salud</label>
                    <textarea id="gra-salu" name="gra-salu" placeholder="Ingrese en grado actual del(a) regidor(a) salud" required></textarea>

                    <label for="nom-educ">Ingrese el nombre del(a) regidor(a) de educacion</label>
                    <input type="text" id="nom-educ" name="nom-educ" placeholder="Ingrese el nombre del(a) regidor(a) de educacion" required>

                    <label for="gra-educ">Ingrese en grado actual del(a) regidor(a) de educacion </label>
                    <textarea id="gra-educ" name="gra-educ" placeholder="Ingrese el nombre del(a) regidor(a) de educacion" required></textarea>

                    <label for="nom-dere">Ingrese el nombre del(a) regidor(a) de derecho</label>
                    <input type="text" id="nom-dere" name="nom-dere" placeholder="Ingrese el nombre del(a) regidor(a) derecho" required>

                    <label for="gra-dere">Ingrese en grado actual del(a) regidor(a) de derecho</label>
                    <textarea id="gra-dere" name="gra-dere" placeholder="Ingrese en grado actual del(a) regidor(a) derecho" required></textarea>

                    <label for="gra-comu">Ingrese en grado actual del(a) regidor(a) de comunicacion</label>
                    <textarea id="gra-comu" name="gra-comu" placeholder="Ingrese en grado actual del(a) regidor(a) comunicacion" required></textarea>

                    <label for="nom-comu">Ingrese el nombre del(a) regidor(a) de comunicacion</label>
                    <input type="text" id="nom-comu" name="nom-comu" placeholder="Ingrese el nombre del(a) regidor(a) de comunicacion" required>

                    <label for="gra-empr">Ingrese en grado actual del(a) regidor(a) de emprendimiento </label>
                    <textarea id="gra-empr" name="gra-empr" placeholder="Ingrese el nombre del(a) regidor(a) de emprendimiento" required></textarea>

                    <label for="nom-empr">Ingrese el nombre del(a) regidor(a) de emprendimento</label>
                    <input type="text" id="nom-empr" name="nom-empr" placeholder="Ingrese el nombre del(a) regidor(a) emprendimiento" required>

                    <label for="plan-trab">Ingrese su plan de trabajo</label>
                    <textarea id="plan-trab" name="plan-trab" placeholder="Ingrese su plan de trabajo" required></textarea>

                    <div class="checkbox-container">
                        <input type="checkbox" id="confirmacion" name="confirmacion" required>
                        <label for="confirmacion">Estas seguro de registrar un nuevo candidato</label>
                    </div>

                    <div class="button-container">
                        <button type="button" class="cancel" onclick="window.location.href='index.php?action=candidatos'">Cancelar</button>
                        <button type="submit" class="register">Registrar</button>
                    </div>
                </form>
            </div>
            </div>

        </section>
    </div>
</body>
</html>