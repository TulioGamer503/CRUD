<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../bd.php'); // Asegura que bd.php existe y tiene la conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["nombre"]) && !empty($_POST["correo"]) && !empty($_POST["contraseña"])) {
        $nombre = trim($_POST["nombre"]);
        $correo = trim($_POST["correo"]);
        $contraseña = password_hash($_POST["contraseña"], PASSWORD_DEFAULT);

        // Verificar si el correo ya está registrado
        $sql_check = "SELECT idUsuario FROM usuarios WHERE correo = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $correo);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            echo "<script>alert('El correo ya está registrado.'); window.location.href='../../html/login.php';</script>";
        } else {
            $sql = "INSERT INTO usuarios (nombre, correo, contraseña) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $nombre, $correo, $contraseña);

            if ($stmt->execute()) {
                // Redirige al login tras el registro exitoso
                header("Location: ../../html/login.php");
                exit();
            } else {
                echo "Error al registrar: " . $stmt->error;
            }

            $stmt->close();
        }

        $stmt_check->close();
    } else {
        echo "<script>alert('Todos los campos son obligatorios.'); window.history.back();</script>";
    }

    $conn->close();
}
?>
