<?php
session_start();

// Si el usuario no ha iniciado sesión, lo redirige al registro
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php"); 
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
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="../index.php">Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="../proyectos/index.php">proyectos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../comentarios/index.php">Comentarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../historial/index.php">historial</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="../php/registro/logout.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
    <div class="container mt-5">
        <h2 class="mb-4">Gestión de Proyectos</h2>
        <div class="row">
            <div class="col-md-3">
                <a href="crear.php" class="btn btn-success w-100">Crear Proyecto</a>
            </div>
            <div class="col-md-3">
                <a href="leer.php" class="btn btn-primary w-100">Ver Proyectos</a>
            </div>
            <!--<div class="col-md-3">
                <a href="editar.php" class="btn btn-warning w-100">Actualizar Proyecto</a>
            </div>-->
            <div class="col-md-3">
                <a href="eliminar.php" class="btn btn-danger w-100">Eliminar Proyecto</a>
            </div>
        </div>
    </div>
</body>
</html>
