<?php
session_start();
require '../config/conexion.php';

// Obtener proyectos y usuarios para los selects
$proyectos = mysqli_query($conn, "SELECT idProyecto, nombreProyecto FROM proyectos");
$usuarios = mysqli_query($conn, "SELECT idUsuario, nombre FROM usuarios");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fechaVencimiento = $_POST['fechaVencimiento'];
    $estado = $_POST['estado'];
    $prioridad = $_POST['prioridad'];
    $idProyecto = $_POST['idProyecto'];
    $idUsuarioAsignado = $_POST['idUsuarioAsignado'] ?? null;

    $query = "INSERT INTO tareas (titulo, descripcion, fechaVencimiento, estado, prioridad, idProyecto, idUsuarioAsignado) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssssi", $titulo, $descripcion, $fechaVencimiento, $estado, $prioridad, $idProyecto, $idUsuarioAsignado);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: leer.php");
        exit();
    } else {
        echo "Error al crear la tarea.";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style2.css">
    <title>Crear Tarea</title>
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
        <h4>Crear Tarea</h4>
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
        <h2>Crear Nueva Tarea</h2>
        <form action="crear.php" method="post">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" name="titulo" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label for="fechaVencimiento" class="form-label">Fecha de Vencimiento</label>
                <input type="date" name="fechaVencimiento" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select name="estado" class="form-control" required>
                    <option value="pendiente">Pendiente</option>
                    <option value="en progreso">En Progreso</option>
                    <option value="completada">Completada</option>
                    <option value="cancelada">Cancelada</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="prioridad" class="form-label">Prioridad</label>
                <select name="prioridad" class="form-control" required>
                    <option value="baja">Baja</option>
                    <option value="media">Media</option>
                    <option value="alta">Alta</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="idProyecto" class="form-label">Proyecto</label>
                <select name="idProyecto" class="form-control" required>
                    <?php while ($proyecto = mysqli_fetch_assoc($proyectos)) { ?>
                        <option value="<?= $proyecto['idProyecto'] ?>"><?= htmlspecialchars($proyecto['nombreProyecto']) ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="idUsuarioAsignado" class="form-label">Asignado a</label>
                <select name="idUsuarioAsignado" class="form-control">
                    <option value="">No asignado</option>
                    <?php while ($usuario = mysqli_fetch_assoc($usuarios)) { ?>
                        <option value="<?= $usuario['idUsuario'] ?>"><?= htmlspecialchars($usuario['nombre']) ?></option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Crear Tarea</button>
            <a href="../index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
