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
    <title>Registrar Cambio en Historial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Registrar Cambio en Historial</h2>
        <form action="crear.php" method="post">
            <div class="mb-3">
                <label for="idTarea" class="form-label">ID de Tarea</label>
                <input type="text" name="idTarea" id="idTarea" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="estadoAnterior" class="form-label">Estado Anterior</label>
                <select name="estadoAnterior" id="estadoAnterior" class="form-control" required>
                    <option value="pendiente">Pendiente</option>
                    <option value="en progreso">En Progreso</option>
                    <option value="completada">Completada</option>
                    <option value="cancelada">Cancelada</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="estadoNuevo" class="form-label">Estado Nuevo</label>
                <select name="estadoNuevo" id="estadoNuevo" class="form-control" required>
                    <option value="pendiente">Pendiente</option>
                    <option value="en progreso">En Progreso</option>
                    <option value="completada">Completada</option>
                    <option value="cancelada">Cancelada</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambio</button>
        </form>
    </div>
</body>
</html>
