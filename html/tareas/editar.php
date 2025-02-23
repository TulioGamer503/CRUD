<?php
session_start();
require '../config/conexion.php';

// Verificar si se proporciona un ID de tarea válido
$idTarea = $_GET['id'] ?? $_POST['idTarea'] ?? null;

if (!$idTarea) {
    echo "ID de tarea no proporcionado.";
    exit();
}

// Obtener datos de la tarea si es una solicitud GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $query = "SELECT * FROM tareas WHERE idTarea = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $idTarea);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $tarea = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$tarea) {
        echo "Tarea no encontrada.";
        exit();
    }
}

// Procesar actualización si es una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $fechaVencimiento = $_POST['fechaVencimiento'] ?? '';
    $estado = $_POST['estado'] ?? '';
    $prioridad = $_POST['prioridad'] ?? '';

    $query = "UPDATE tareas SET titulo=?, descripcion=?, fechaVencimiento=?, estado=?, prioridad=? WHERE idTarea=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssssi", $titulo, $descripcion, $fechaVencimiento, $estado, $prioridad, $idTarea);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: dashboard.leer.php?mensaje=actualizado");
        exit();
    } else {
        echo "Error al actualizar la tarea: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Actualizar Tarea</h2>
        <form action="" method="post">
            <input type="hidden" name="idTarea" value="<?= $idTarea ?>">

            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($tarea['titulo'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" required><?= htmlspecialchars($tarea['descripcion'] ?? '') ?></textarea>
            </div>
            <div class="mb-3">
                <label for="fechaVencimiento" class="form-label">Fecha de Vencimiento</label>
                <input type="date" name="fechaVencimiento" class="form-control" value="<?= $tarea['fechaVencimiento'] ?? '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="prioridad" class="form-label">Prioridad</label>
                <select name="prioridad" class="form-control" required>
                    <option value="baja" <?= ($tarea['prioridad'] ?? '') == 'baja' ? 'selected' : '' ?>>Baja</option>
                    <option value="media" <?= ($tarea['prioridad'] ?? '') == 'media' ? 'selected' : '' ?>>Media</option>
                    <option value="alta" <?= ($tarea['prioridad'] ?? '') == 'alta' ? 'selected' : '' ?>>Alta</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select name="estado" class="form-control" required>
                    <option value="pendiente" <?= ($tarea['estado'] ?? '') == 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                    <option value="en progreso" <?= ($tarea['estado'] ?? '') == 'en progreso' ? 'selected' : '' ?>>En Progreso</option>
                    <option value="completada" <?= ($tarea['estado'] ?? '') == 'completada' ? 'selected' : '' ?>>Completada</option>
                    <option value="cancelada" <?= ($tarea['estado'] ?? '') == 'cancelada' ? 'selected' : '' ?>>Cancelada</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
</body>
</html>
