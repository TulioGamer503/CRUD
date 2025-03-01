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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Gestión de Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="proyectos/index.php">proyectos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="comentarios/index.php">Comentarios</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link text-danger" href="../php/registro/logout.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h1 class="text-center">¡Bienvenido, <?php echo $_SESSION["usuario_nombre"]; ?>!</h1>
    <p class="text-center text-muted">Administra tu tiempo y mejora tu productividad.</p>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Crear Tareas</div>
                <div class="card-body">
                    <p class="card-text">Organiza tus pendientes y define tus prioridades.</p>
                    <a href="tareas/crear.php" class="btn btn-light">Ir a Crear</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Ver y Editar</div>
                <div class="card-body">
                    <p class="card-text">Consulta, edita y actualiza tus tareas fácilmente.</p>
                    <a href="tareas/dashboard.leer.php" class="btn btn-light">Ir a Leer</a>
                </div>
            </div>
        </div>
        <!--<div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">Eliminar Tareas</div>
                <div class="card-body">
                    <p class="card-text">Elimina tareas que ya no necesitas.</p>
                    <a href="tareas/eliminar.php" class="btn btn-light">Ir a Eliminar</a>
                </div>
            </div>
        </div>-->
    </div>
</div>

  </body>
</html>