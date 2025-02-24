<?php
session_start();
require '../config/conexion.php';

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php"); 
    exit();
}
$idTarea = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Verificar que el ID de la tarea sea válido
if ($idTarea <= 0) {
    die("ID de tarea no válido.");
}

// Obtener detalles de la tarea
$queryTarea = "SELECT titulo FROM tareas WHERE idTarea = ?";
$stmtTarea = mysqli_prepare($conn, $queryTarea);
mysqli_stmt_bind_param($stmtTarea, "i", $idTarea);
mysqli_stmt_execute($stmtTarea);
$resultTarea = mysqli_stmt_get_result($stmtTarea);
$tarea = mysqli_fetch_assoc($resultTarea);
mysqli_stmt_close($stmtTarea);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comentario = $_POST['comentario'];
    $usuario = $_SESSION["usuario_id"];
    
    $query = "INSERT INTO comentarios (comentario, fechaComentario, idTarea, idUsuario) VALUES (?, NOW(), ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sii", $comentario, $idTarea, $usuario);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../tareas/leer.php?idTarea=$idTarea");
        exit();
    } else {
        echo "Error al agregar el comentario.";
    }
    
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Comentario</title>
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
                    <a class="nav-link active" href="../tareas/leer.php">Regresar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <div class="container mt-5">
        <h2>Agregar Comentario</h2>
        <form action="crear.php?id=<?= $idTarea; ?>" method="post">
            <div class="mb-3">
                <label for="idTarea" class="form-label">ID de Tarea</label>
                <input type="text" name="idTarea" id="idTarea" class="form-control" value="<?= $idTarea; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="comentario" class="form-label">Comentario</label>
                <textarea name="comentario" id="comentario" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Comentario</button>
        </form>
    </div>
</body>
</html>
