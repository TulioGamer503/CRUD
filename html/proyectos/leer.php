<?php
session_start();
require '../config/conexion.php';

// Verifica que el usuario haya iniciado sesión
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../auth/login.php");
    exit();
}

$idUsuario = $_SESSION['usuario_id'];
$query = "SELECT * FROM proyectos WHERE idUsuario = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $idUsuario);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Proyectos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Tus Proyectos</h2>
        <a href="index.php" class="btn btn-primary mb-3">Regresar</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($proyecto = mysqli_fetch_assoc($resultado)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($proyecto['nombreProyecto']); ?></td>
                        <td><?php echo htmlspecialchars($proyecto['descripcion']); ?></td>
                        <td><?php echo $proyecto['fechaInicio']; ?></td>
                        <td><?php echo $proyecto['fechaFin']; ?></td>
                        <td>
                            <a href="actualizar.php?id=<?php echo $proyecto['idProyecto']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="eliminar.php?id=<?php echo $proyecto['idProyecto']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar este proyecto?');">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
