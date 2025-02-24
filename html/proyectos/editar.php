<?php
session_start();
require '../config/conexion.php';

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php"); 
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $idProyecto = $_GET["id"];
    $query = "SELECT * FROM proyectos WHERE idProyecto = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $idProyecto);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $proyecto = mysqli_fetch_assoc($resultado);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idProyecto = $_POST["idProyecto"];
    $nombreProyecto = $_POST["nombreProyecto"];
    $descripcion = $_POST["descripcion"];
    $fechaInicio = $_POST["fechaInicio"];
    $fechaFin = $_POST["fechaFin"];

    $query = "UPDATE proyectos SET nombreProyecto=?, descripcion=?, fechaInicio=?, fechaFin=? WHERE idProyecto=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssi", $nombreProyecto, $descripcion, $fechaInicio, $fechaFin, $idProyecto);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: leer.php");
        exit();
    } else {
        echo "Error al actualizar el proyecto.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proyecto</title>
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
        <h4>Editar Proyecto</h4>
        </div>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Regresar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <div class="container mt-5">
        <h2>Editar Proyecto</h2>
        <form action="editar.php" method="post">
            <input type="hidden" name="idProyecto" value="<?php echo $proyecto['idProyecto']; ?>">
            <div class="mb-3">
                <label class="form-label">Nombre del Proyecto</label>
                <input type="text" name="nombreProyecto" class="form-control" value="<?php echo htmlspecialchars($proyecto['nombreProyecto']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" required><?php echo htmlspecialchars($proyecto['descripcion']); ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Fecha de Inicio</label>
                <input type="date" name="fechaInicio" class="form-control" value="<?php echo $proyecto['fechaInicio']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Fecha de Finalización</label>
                <input type="date" name="fechaFin" class="form-control" value="<?php echo $proyecto['fechaFin']; ?>">
            </div>
            <button type="submit" class="btn btn-success">Actualizar</button>
            <a href="leer.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
