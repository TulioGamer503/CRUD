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
    <title>Gestión de Comentarios</title>
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
        <h2 class="mb-4">Gestión de Comentarios</h2>
        <div class="row">
            <div class="col-md-4">
                <a href="crear.php" class="btn btn-success w-100">Añadir Comentario</a>
            </div>
            <div class="col-md-4">
                <a href="dashboard.leer.php" class="btn btn-primary w-100">Ver Comentarios</a>
            </div>
           
        </div>
    </div>
</body>
</html>
