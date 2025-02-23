<?php
session_start();

// Si el usuario no ha iniciado sesión, lo redirige al registro
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php"); 
    exit();
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Eliminar Tarea</h2>
        <p>¿Estás seguro de que deseas eliminar esta tarea?</p>
        <form action="eliminar.php" method="post">
            <input type="hidden" name="idTarea" value="1">
            <button type="submit" class="btn btn-danger">Eliminar</button>
            <a href="leer.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
