<?php
session_start();

// Si el usuario no ha iniciado sesión, lo redirige al login
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../auth/login.php");
    exit();
}

require '../config/conexion.php'; // Archivo de conexión a la base de datos

$idTarea = $_GET['idTarea'] ?? 0;

$query = "SELECT c.*, u.nombre 
          FROM comentarios c
          JOIN usuarios u ON c.idUsuario = u.idUsuario
          WHERE c.idTarea = ? 
          ORDER BY c.fechaComentario DESC";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $idTarea);
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
        <h2>Comentarios</h2>

        <form action="crear.php" method="post">
            <input type="hidden" name="idTarea" value="<?= $idTarea; ?>">
            <div class="mb-3">
                <textarea name="comentario" class="form-control" placeholder="Escribe un comentario..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Comentario</button>
        </form>

        <hr>

        <h4>Lista de Comentarios</h4>
        <ul class="list-group">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <li class="list-group-item">
                    <strong><?= htmlspecialchars($row['nombre']); ?>:</strong>
                    <?= nl2br(htmlspecialchars($row['comentario'])); ?>
                    <small class="text-muted"> (<?= $row['fechaComentario']; ?>)</small>
                    <?php if ($row['idUsuario'] == $_SESSION["usuario_id"]) { ?>
                        <a href="eliminar.php?id=<?= $row['idComentario']; ?>&idTarea=<?= $idTarea; ?>" class="btn btn-danger btn-sm float-end" onclick="return confirm('¿Eliminar este comentario?');">Eliminar</a>
                    <?php } ?>
                </li>
            <?php } ?>
        </ul>
    </div>
</body>
</html>
