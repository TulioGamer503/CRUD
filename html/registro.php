<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro</title>
    <link rel="stylesheet" href="css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </head>
  <body>
  <div class="contenedor-principal">

<div class="contenedor-imagen">
  <div class="titulo">
  <h1>HOLA TAREA</h1>
  </div>
</div>
<div class="contenedor-elementos">
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Iniciar Sesión</a>
                    </li>
                    
                </ul>
            </div>
        </div>
        </nav>
    <div class="container mt-5">
      <h2>Registro</h2>
      <form action="../php/registro/registro.php" method="post">
        <div class="mb-3">
          <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
        </div>
        <div class="mb-3">
          <input type="email" name="correo" class="form-control" placeholder="Correo" required>
        </div>
        <div class="mb-3">
          <input type="password" name="contraseña" class="form-control" placeholder="Contraseña" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrarse</button>
      </form>
      <p class="mt-3">¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
    </div>
    </div>
    </div>
  </body>
</html>
