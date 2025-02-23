<?php
session_start();
require '../config/conexion.php'; // Archivo de conexión a la base de datos

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit();
}

// Verificar si se recibió el ID del comentario
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["idComentario"])) {
    $idComentario = $_POST["idComentario"];
    $usuario_id = $_SESSION["usuario_id"];

    // Verificar si el comentario pertenece al usuario actual
    $query = "SELECT idUsuario FROM comentarios WHERE idComentario = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $idComentario);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $comentario = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ($comentario && $comentario["idUsuario"] == $usuario_id) {
        // Eliminar el comentario
        $query = "DELETE FROM comentarios WHERE idComentario = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $idComentario);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION["mensaje"] = "Comentario eliminado correctamente.";
        } else {
            $_SESSION["error"] = "Error al eliminar el comentario.";
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION["error"] = "No puedes eliminar este comentario.";
    }
}

// Redirigir a la página de comentarios
header("Location: dashboard.leer.php");
exit();
