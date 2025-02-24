<?php
session_start();
require '../config/conexion.php';
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php"); 
    exit();
}
$idTarea = $_GET['id'] ?? null;

if ($idTarea) {
    $query = "SELECT * FROM tareas WHERE idTarea = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $idTarea);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $tarea = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fechaVencimiento = $_POST['fechaVencimiento'];
    $estado = $_POST['estado'];
    $prioridad = $_POST['prioridad'];

    $query = "UPDATE tareas SET titulo=?, descripcion=?, fechaVencimiento=?, estado=?, prioridad=? WHERE idTarea=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssssi", $titulo, $descripcion, $fechaVencimiento, $estado, $prioridad, $idTarea);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: leer.php");
        exit();
    } else {
        echo "Error al actualizar la tarea.";
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
            <ul class="navbar-nav">
            <li class="nav-item">
                    <a class="nav-link active" href="../index.php">Regresar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
    <div class="container mt-5">
        <h2>Actualizar Tarea</h2>
        <form action="editar.php?id=<?= $idTarea ?>" method="post">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($tarea['titulo']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" required><?= htmlspecialchars($tarea['descripcion']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="fechaVencimiento" class="form-label">Fecha de Vencimiento</label>
                <input type="date" name="fechaVencimiento" class="form-control" value="<?= $tarea['fechaVencimiento'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select name="estado" class="form-control" required>
                    <option value="pendiente" <?= $tarea['estado'] == 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                    <option value="en progreso" <?= $tarea['estado'] == 'en progreso' ? 'selected' : '' ?>>En Progreso</option>
                    <option value="completada" <?= $tarea['estado'] == 'completada' ? 'selected' : '' ?>>Completada</option>
                    <option value="cancelada" <?= $tarea['estado'] == 'cancelada' ? 'selected' : '' ?>>Cancelada</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="leer.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
