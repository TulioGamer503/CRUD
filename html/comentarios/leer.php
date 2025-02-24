<?php
session_start();
require '../config/conexion.php';
// Verifica que el usuario haya iniciado sesión
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../auth/login.php");
    exit();
}

$idTarea = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Verificar que se haya recibido un idTarea válido
if ($idTarea <= 0) {
    header("Location: ../comentarios/leer.php");
}

// Consultar la existencia de comentarios
$query = "SELECT comentarios.idTarea, comentarios.comentario, comentarios.fechaComentario, 
                 tareas.titulo, usuarios.idUsuario, usuarios.nombre
          FROM comentarios
          JOIN tareas ON tareas.idTarea = comentarios.idTarea
          JOIN usuarios ON usuarios.idUsuario = comentarios.idUsuario
          WHERE comentarios.idTarea = ?";

$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    die("Error en la consulta SQL: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $idTarea);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Obtener el número de comentarios encontrados
$numComentarios = mysqli_num_rows($result);

// Obtener el título de la tarea
$queryTarea = "SELECT titulo FROM tareas WHERE idTarea = ?";
$stmtTarea = mysqli_prepare($conn, $queryTarea);
mysqli_stmt_bind_param($stmtTarea, "i", $idTarea);
mysqli_stmt_execute($stmtTarea);
$resultTarea = mysqli_stmt_get_result($stmtTarea);
$tarea = mysqli_fetch_assoc($resultTarea);
mysqli_stmt_close($stmtTarea);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentarios de la Tarea</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style.css">
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
        <h4>Lista de Comentarios</h4>
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

    <div class="container mt-5">
        <h2>Comentarios de la Tarea: <?= htmlspecialchars($tarea['titulo']); ?></h2>

        <?php if ($numComentarios > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Persona</th>
                        <th>Comentario</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nombre']); ?></td>
                            <td><?= nl2br(htmlspecialchars($row['comentario'])); ?></td>
                            <td><?= $row['fechaComentario']; ?></td>
                            <td>
                                <a href="editar.php?id=<?= $row['idTarea']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="eliminar.php?id=<?php echo $row['idTarea']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar este proyecto?');">Eliminar</a>

                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                No hay comentarios para esta tarea.
            </div>
            <a href="crear.php?id=<?= $idTarea; ?>" class="btn btn-primary">Crear Comentario</a>
        <?php endif; ?>
    </div>
</body>
</html>
