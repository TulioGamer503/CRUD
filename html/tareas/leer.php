<?php
session_start();
require '../config/conexion.php';
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit();
}

$query = "SELECT t.*, p.nombreProyecto, u.nombre AS usuarioAsignado
          FROM tareas t
          JOIN proyectos p ON t.idProyecto = p.idProyecto
          LEFT JOIN usuarios u ON t.idUsuarioAsignado = u.idUsuario
          ORDER BY t.fechaCreacion DESC";

$result = mysqli_query($conn, $query);
$numTareas = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tareas</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="../index.php">Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <h4>Lista de Tareas</h4>
        </div>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
            <li class="nav-item">
                    <a class="nav-link active" href="../index.php">Regresar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="link">
<a class="link-crear-tarea" href="crear.php">Crear nueva tarea +</a>
</div> 
<?php if ($numTareas > 0): ?>
    <div class="container-info">
<?php while ($row = mysqli_fetch_assoc($result)) { ?>
<div class="tarea-info">

    <div class="titulo">
<h2><?= htmlspecialchars($row['titulo']); ?></h2>
<p><strong>Vence: </strong><?= $row['fechaVencimiento']; ?></p>
</div>
<p><strong>Proyecto:</strong> <?= htmlspecialchars($row['nombreProyecto']); ?></br>
<strong>descripcion:</strong> <?= htmlspecialchars($row['descripcion']); ?> </br>
<strong>Encargado:</strong> <?= htmlspecialchars($row['usuarioAsignado'] ?? 'No asignado'); ?></br>
<strong>Estado:</strong> <?= ucfirst($row['estado']); ?></br>
<strong>Prioridad:</strong> <?= ucfirst($row['prioridad']); ?></br>

<a href="editar.php?id=<?= $row['idTarea']; ?>" class="btn btn-success" style="padding-top:3px; padding-bottom:3px" >Editar</a>
<a href="eliminar.php?id=<?php echo $row['idTarea']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar este proyecto?');">Eliminar</a>
<a href="../comentarios/leer.php?id=<?php echo $row['idTarea'];?>" class="btn btn-ligth btn-sm" style="border:1px solid rgb(150, 150, 148); padding-top:3px; padding-bottom:3px">Comentario</a>
</div>
<?php } ?>
<?php else: ?>
            <div class="alert alert-warning" role="alert">
                No haz creado ninguna tarea
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

