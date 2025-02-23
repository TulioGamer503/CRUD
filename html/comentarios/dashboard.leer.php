<?php
session_start();

// Si el usuario no ha iniciado sesión, lo redirige al login
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit();
}

require '../config/conexion.php'; // Archivo de conexión a la base de datos

$query = "SELECT 
          c.idComentario,
          c.comentario,
          c.fechaComentario,
          c.idUsuario,
          c.idTarea,
          u.nombre AS nombreUsuario,
          t.titulo AS tituloTarea
        FROM comentarios c
        JOIN usuarios u ON c.idUsuario = u.idUsuario
        JOIN tareas t ON c.idTarea = t.idTarea
        ORDER BY c.fechaComentario DESC";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <hr>

        <h4>Lista de Comentarios</h4>
        <a href="index.php" class="btn btn-primary mb-3">Regresar</a>
        <ul class="list-group">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <!-- Mostrar nombre de la tarea -->
                            <h5 class="text-primary"><?= htmlspecialchars($row['tituloTarea']) ?></h5>
                            <!-- Mostrar nombre de usuario -->
                            <strong><?= htmlspecialchars($row['nombreUsuario']) ?>:</strong>
                            <!-- Mostrar comentario con saltos de línea -->
                            <p class="mb-0"><?= nl2br(htmlspecialchars($row['comentario'])) ?></p>
                            <!-- Mostrar fecha -->
                            <small class="text-muted"><?= $row['fechaComentario'] ?></small>
                        </div>
                        <?php if ($row['idUsuario'] == $_SESSION["usuario_id"]): ?>
    <div>
        <a href="editar_comentario.php?id=<?= $row['idComentario'] ?>" class="btn btn-warning btn-sm">
            Editar
        </a>
    </div>
<?php endif; ?>
                        <!-- Botón de eliminar solo para el autor -->
                        <?php if ($row['idUsuario'] == $_SESSION["usuario_id"]): ?>
                            <div>
                                <a href="eliminar_confirmacion.php?id=<?= $row['idComentario'] ?>" 
                                   class="btn btn-danger btn-sm">
                                    Eliminar
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>
