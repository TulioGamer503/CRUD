<?php
session_start();
require '../config/conexion.php';

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php"); 
    exit();
}

$idTarea = $_GET['id'] ?? null;
$comentarioData = null; 

// Obtener datos del comentario si el ID es válido
if ($idTarea) {
    $query = "SELECT * FROM comentarios WHERE idTarea = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $idTarea);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $comentarioData = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

// Si el formulario se envía (actualizar comentario)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idTarea = $_POST['idTarea'] ?? null;
    $comentario = $_POST['comentario'] ?? '';

    if ($idTarea && $comentario) {
        $query = "UPDATE comentarios SET comentario=? WHERE idTarea=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "si", $comentario, $idTarea);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../tareas/leer.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Error al actualizar el comentario.</div>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<div class='alert alert-warning'>Datos incompletos.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Comentario</title>
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
    <h2>Actualizar Comentario</h2>

    <?php if ($comentarioData): ?>
        <form action="editar.php" method="post">
            <input type="hidden" name="idTarea" value="<?= htmlspecialchars($idTarea) ?>">

            <div class="mb-3">
                <label for="comentario" class="form-label">Comentario</label>
                <input type="text" name="comentario" id="comentario" class="form-control" 
                       value="<?= htmlspecialchars($comentarioData['comentario'] ?? '') ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="leer.php" class="btn btn-secondary">Cancelar</a>
        </form>
    <?php else: ?>
        <div class="alert alert-danger">Error: No se encontró el comentario.</div>
    <?php endif; ?>
</div>

</body>
</html>
