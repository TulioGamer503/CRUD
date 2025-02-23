<?php
session_start();

// Si el usuario no ha iniciado sesión, lo redirige al registro
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php"); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Proyectos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Gestión de Proyectos</h2>
        <div class="row">
            <div class="col-md-3">
                <a href="crear.php" class="btn btn-success w-100">Crear Proyecto</a>
            </div>
            <div class="col-md-3">
                <a href="leer.php" class="btn btn-primary w-100">Ver Proyectos</a>
            </div>
            <div class="col-md-3">
                <a href="editar.php" class="btn btn-warning w-100">Actualizar Proyecto</a>
            </div>
            <div class="col-md-3">
                <a href="eliminar.php" class="btn btn-danger w-100">Eliminar Proyecto</a>
            </div>
        </div>
    </div>
</body>
</html>
