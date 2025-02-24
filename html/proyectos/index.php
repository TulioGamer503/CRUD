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
    <link rel="stylesheet" href="../css/style.css">
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
        <h4>Proyectos</h4>
        </div>

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
        
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Crear Proyecto</div>
                <div class="card-body">
                    <p class="card-text">Organiza tus pendientes y define tus prioridades.</p>
                    <a href="crear.php" class="btn btn-outline-secondary">Crear Proyecto</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Ver y Editar Proyecto</div>
                <div class="card-body">
                    <p class="card-text">Consulta, edita y actualiza tus proyectos fácilmente.</p>
                    <a href="leer.php" class="btn btn-outline-secondary">Ver Proyectos</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
