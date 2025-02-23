<?php
session_start();

// Si el usuario no ha iniciado sesión, redirigirlo al login
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit();
}

require '../config/conexion.php'; // Conexión a la base de datos

// Verificar si el comentario existe
if (isset($_GET['id'])) {
    $comentario_id = $_GET['id'];

    // Obtener el comentario original de la base de datos
    $query = "SELECT comentario FROM comentarios WHERE idComentario = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $comentario_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $comentario);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Verificar si el comentario existe y pertenece al usuario
    if (!$comentario || !isset($_SESSION["usuario_id"])) {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}

// Procesar el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_comentario = $_POST['comentario'];

    // Actualizar el comentario en la base de datos
    $query = "UPDATE comentarios SET comentario = ? WHERE idComentario = ? AND idUsuario = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sii', $nuevo_comentario, $comentario_id, $_SESSION['usuario_id']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Redirigir después de la edición
    header("Location: dashboard.leer.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Comentario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h4>Editar Comentario</h4>
        <form action="editar_comentario.php?id=<?= $comentario_id ?>" method="POST">
            <div class="mb-3">
                <label for="comentario" class="form-label">Comentario</label>
                <textarea class="form-control" id="comentario" name="comentario" rows="4"><?= htmlspecialchars($comentario) ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="dashboard.leer.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
