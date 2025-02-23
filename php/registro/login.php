<?php
require('../bd.php');
session_start();

// Activar mensajes de error para depuración (quitar en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["correo"]) && !empty($_POST["contraseña"])) {
        $correo = trim($_POST["correo"]);
        $contraseña = trim($_POST["contraseña"]);

        $sql = "SELECT idUsuario, nombre, contraseña FROM usuarios WHERE correo = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $correo);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows > 0) {
                $usuario = $resultado->fetch_assoc();
                if (password_verify($contraseña, $usuario["contraseña"])) {
                    $_SESSION["usuario_id"] = $usuario["idUsuario"];
                    $_SESSION["usuario_nombre"] = $usuario["nombre"];
                    
                    echo "Inicio de sesión exitoso. <a href='../../html/index.php'>Ir al panel</a>";
                } else {
                    echo "❌ Contraseña incorrecta.";
                }
            } else {
                echo "⚠️ No existe una cuenta con ese correo.";
            }

            $stmt->close();
        } else {
            echo "Error en la consulta SQL.";
        }
    } else {
        echo "⚠️ Todos los campos son obligatorios.";
    }

    $conn->close();
}
?>
