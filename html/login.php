<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </head>
  <body>
    <div class="container mt-5">
      <h2>Iniciar Sesión</h2>
      <form action="login.php" method="post">
        <div class="mb-3">
          <input type="email" name="correo" class="form-control" placeholder="Correo" required>
        </div>
        <div class="mb-3">
          <input type="password" name="contraseña" class="form-control" placeholder="Contraseña" required>
        </div>
        <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
      </form>
      <p class="mt-3">¿No tienes cuenta? <a href="registro.php">Haz clic aquí</a></p>
    </div>
  </body>
</html>
