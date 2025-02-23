<?php
session_start();
require('../bd.php'); // Asegura la conexión a la base de datos

// Si el usuario no ha iniciado sesión, lo redirige al login
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

// Verifica si se recibió el ID de la tarea por POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["idTarea"])) {
    $idTarea = intval($_POST["idTarea"]); // Convierte el ID a entero para seguridad

    // Consulta preparada para eliminar la tarea
    $sql = "DELETE FROM tareas WHERE idTarea = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idTarea);

    if ($stmt->execute()) {
        echo "<script>alert('Tarea eliminada con éxito'); window.location='dashboard.leer.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar la tarea'); window.location='dashboard.leer.phpleer.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    // Redirigir si no se envió un ID válido
    header("Location: dashboard.leer.php");
    exit();
}
?>
