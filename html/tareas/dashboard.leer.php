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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Lista de Tareas</h2>
        <a href="../index.php" class="btn btn-primary mb-3">Regresar</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Proyecto</th>
                    <th>Asignado a</th>
                    <th>Estado</th>
                    <th>Prioridad</th>
                    <th>Vencimiento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['titulo']); ?></td>
                        <td><?= htmlspecialchars($row['nombreProyecto']); ?></td>
                        <td><?= htmlspecialchars($row['usuarioAsignado'] ?? 'No asignado'); ?></td>
                        <td><?= ucfirst($row['estado']); ?></td>
                        <td><?= ucfirst($row['prioridad']); ?></td>
                        <td><?= $row['fechaVencimiento']; ?></td>
                        <td>
                            <a href="editar.php?id=<?= $row['idTarea']; ?>" class="btn btn-warning">Editar</a>
                            <a href="eliminar.php?id=<?= $row['idTarea']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta tarea?')">Eliminar
</a>

                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
