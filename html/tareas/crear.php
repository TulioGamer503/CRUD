<?php
session_start();
require '../config/conexion.php';
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit();
}

// Obtener proyectos y usuarios para los selects
$proyectos = mysqli_query($conn, "SELECT idProyecto, nombreProyecto FROM proyectos");
$usuarios = mysqli_query($conn, "SELECT idUsuario, nombre FROM usuarios");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $fechaVencimiento = $_POST['fechaVencimiento'];
    $estado = $_POST['estado'];
    $prioridad = $_POST['prioridad'];
    $idProyecto = intval($_POST['idProyecto']);
    $idUsuarioAsignado = isset($_POST['idUsuarioAsignado']) && $_POST['idUsuarioAsignado'] !== "" ? intval($_POST['idUsuarioAsignado']) : null;

    // Verificar conexión
    if (!$conn) {
        die("Error en la conexión: " . mysqli_connect_error());
    }

    // Insertar la tarea en la base de datos
    $query = "INSERT INTO tareas (titulo, descripcion, fechaVencimiento, estado, prioridad, idProyecto, idUsuarioAsignado) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);

    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "ssssssi", $titulo, $descripcion, $fechaVencimiento, $estado, $prioridad, $idProyecto, $idUsuarioAsignado);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: dashboard.leer.php");
        exit();
    } else {
        echo "Error al crear la tarea: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
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
            <button type="submit" class="btn btn-success">Crear Tarea</button>
            <a href="dashboard.leer.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
