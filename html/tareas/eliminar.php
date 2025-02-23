<?php
session_start();
require '../config/conexion.php';

// Verificar si se proporciona un ID válido
$idTarea = $_GET['id'] ?? null;

if (!$idTarea) {
    echo "Error: ID de tarea no proporcionado.";
    exit();
}

// Preparar y ejecutar la consulta segura
$query = "DELETE FROM tareas WHERE idTarea = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $idTarea);

if (mysqli_stmt_execute($stmt)) {
    header("Location: dashboard.leer.php?mensaje=eliminado");
    exit();
} else {
    echo "Error al eliminar la tarea: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
