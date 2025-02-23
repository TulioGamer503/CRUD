<?php
session_start();

// Si el usuario no ha iniciado sesión, lo redirige al login
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../auth/login.php");
    exit();
}

// Verificar que se pase un ID de comentario válido
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: dashboard.leer.php");
    exit();
}

$idComentario = $_GET["id"];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Comentario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Eliminar Comentario</h2>
        <p>¿Estás seguro de que deseas eliminar este comentario?</p>
        <form action="eliminar.php" method="post">
            <input type="hidden" name="idComentario" value="<?= htmlspecialchars($idComentario) ?>">
            <button type="submit" class="btn btn-danger">Eliminar</button>
            <a href="dashboard.leer.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
