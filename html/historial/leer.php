<?php
session_start();
require '../config/conexion.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../auth/login.php");
    exit();
}

// Obtener ID de la tarea
if (!isset($_GET["idTarea"])) {
    echo "ID de tarea no proporcionado.";
    exit();
}

$idTarea = $_GET["idTarea"];

// Obtener la información de la tarea
$queryTarea = "SELECT titulo FROM tareas WHERE idTarea = ?";
$stmtTarea = mysqli_prepare($conn, $queryTarea);
mysqli_stmt_bind_param($stmtTarea, "i", $idTarea);
mysqli_stmt_execute($stmtTarea);
$resultadoTarea = mysqli_stmt_get_result($stmtTarea);
$tarea = mysqli_fetch_assoc($resultadoTarea);

// Obtener el historial de cambios de la tarea
$queryHistorial = "SELECT h.estadoAnterior, h.estadoNuevo, h.fechaCambio, u.nombre 
                   FROM historial_tareas h
                   JOIN usuarios u ON h.idUsuario = u.idUsuario
                   WHERE h.idTarea = ? ORDER BY h.fechaCambio DESC";
$stmtHistorial = mysqli_prepare($conn, $queryHistorial);
mysqli_stmt_bind_param($stmtHistorial, "i", $idTarea);
mysqli_stmt_execute($stmtHistorial);
$resultadoHistorial = mysqli_stmt_get_result($stmtHistorial);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Cambios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Historial de Cambios - Tarea: <?php echo htmlspecialchars($tarea['titulo']); ?></h2>

        <h3 class="mt-4">Cambios Realizados:</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Estado Anterior</th>
                    <th>Estado Nuevo</th>
                    <th>Fecha de Cambio</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($historial = mysqli_fetch_assoc($resultadoHistorial)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($historial['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($historial['estadoAnterior']); ?></td>
                        <td><?php echo htmlspecialchars($historial['estadoNuevo']); ?></td>
                        <td><?php echo $historial['fechaCambio']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <a href="../tareas/leer.php?idTarea=<?php echo $idTarea; ?>" class="btn btn-primary">Volver a la Tarea</a>
    </div>
</body>
</html>
