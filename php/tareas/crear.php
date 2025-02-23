<?php
session_start();
require '../config/conexion.php'; // Archivo de conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fechaVencimiento = $_POST['fechaVencimiento'];
    $estado = $_POST['estado'];
    $prioridad = $_POST['prioridad'];
    $idProyecto = $_POST['idProyecto'];
    $idUsuarioAsignado = $_POST['idUsuarioAsignado'] ?? null;

    $query = "INSERT INTO tareas (titulo, descripcion, fechaVencimiento, estado, prioridad, idProyecto, idUsuarioAsignado) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssssi", $titulo, $descripcion, $fechaVencimiento, $estado, $prioridad, $idProyecto, $idUsuarioAsignado);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: leer.php");
        exit();
    } else {
        echo "Error al crear la tarea.";
    }

    mysqli_stmt_close($stmt);
}
?>
