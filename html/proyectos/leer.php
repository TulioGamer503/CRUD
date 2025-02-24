<?php
session_start();
require '../config/conexion.php';

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php"); 
    exit();
}

$idUsuario = $_SESSION['usuario_id'];
$query = "SELECT * FROM proyectos WHERE idUsuario = ?";
$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    die("Error en la preparación de la consulta: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $idUsuario);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if (!$resultado) {
    die("Error en la ejecución de la consulta: " . mysqli_error($conn));
}

$numProyectos = mysqli_num_rows($resultado);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Proyectos</title>
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
            <h4>Lista de Proyectos</h4>
        </div>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Regresar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="link">
    <a class="link-crear-tarea" href="crear.php">Crear nuevo Proyecto+</a>
</div>

<?php if ($numProyectos > 0): ?>
    <div class="container-info">
        <?php while ($proyecto = mysqli_fetch_assoc($resultado)) { ?>
            <div class="tarea-info">
                <div class="titulo">
                    <h2><?php echo htmlspecialchars($proyecto['nombreProyecto']); ?></h2>
                </div>
                <p><strong>Descripción: </strong><?php echo htmlspecialchars($proyecto['descripcion']); ?></p>
                <p><strong>Fecha Inicio: </strong><?php echo $proyecto['fechaInicio']; ?></p>
                <p><strong>Fecha Fin: </strong><?php echo $proyecto['fechaFin']; ?></p>
                <p>
                    <a href="editar.php?id=<?php echo $proyecto['idProyecto']; ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="eliminar.php?id=<?php echo $proyecto['idProyecto']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar este proyecto?');">Eliminar</a>
                </p>
            </div>
        <?php } ?>
    </div>
<?php else: ?>
    <div class="alert alert-warning" role="alert">
        No has creado ningún proyecto.
    </div>
<?php endif; ?>

</body>
</html>
