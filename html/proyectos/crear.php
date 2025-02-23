<?php
session_start();
require '../config/conexion.php';

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreProyecto = $_POST['nombreProyecto'];
    $descripcion = $_POST['descripcion'];
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];
    $idUsuario = $_SESSION['usuario_id']; // ID del usuario que crea el proyecto

    $query = "INSERT INTO proyectos (nombreProyecto, descripcion, fechaInicio, fechaFin, idUsuario) 
              VALUES (?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssi", $nombreProyecto, $descripcion, $fechaInicio, $fechaFin, $idUsuario);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: leer.php");
        exit();
    } else {
        echo "Error al crear el proyecto.";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Proyecto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Crear Nuevo Proyecto</h2>
        <form action="crear.php" method="post">
            <div class="mb-3">
                <label for="nombreProyecto" class="form-label">Nombre del Proyecto</label>
                <input type="text" name="nombreProyecto" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label for="fechaInicio" class="form-label">Fecha de Inicio</label>
                <input type="date" name="fechaInicio" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="fechaFin" class="form-label">Fecha de Finalización</label>
                <input type="date" name="fechaFin" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Crear Proyecto</button>
            <a href="leer.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
