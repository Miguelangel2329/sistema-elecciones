<!-- list_votacion.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Lista de Votación</title>
    <link rel="stylesheet" href="public/css/list_candidatos.css">
</head>
<body>
    <h2>Elige tu candidato preferido</h2>
    <div class="candidatos-container">
        <?php foreach ($candidatos as $candidato): ?>
            <div class="candidato-card">
                <img src="public/images/<?php echo $candidato['foto_perfil']; ?>"alt="Logo del partido">
                <h3><?php echo htmlspecialchars($candidato['partido_nombre']); ?></h3>
                <p>Nombre del candidato: <?php echo htmlspecialchars($candidato['nombre'] . " " . $candidato['apellido']); ?></p>
                <form action="index.php?action=votar" method="POST">
                    <input type="hidden" name="id_candidato" value="<?php echo $candidato['id_candidato']; ?>">
                    <input type="hidden" name="id_eleccion" value="<?php echo $eleccion['id_elecciones']; ?>">
                    <input type="hidden" name="id_puesto" value="<?php echo $candidato['id_puesto']; ?>">
                    <input type="hidden" name="nombre_candidato" value="<?php echo $candidato['nombre']; ?>">
                    <button type="submit">Votar por este Candidato</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
