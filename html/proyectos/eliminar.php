<?php
session_start();
require '../config/conexion.php';

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php"); 
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $idProyecto = $_GET["id"];
    
    $query = "DELETE FROM proyectos WHERE idProyecto = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $idProyecto);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: leer.php");
        exit();
    } else {
        echo "Error al eliminar el proyecto.";
    }
}
?>
