<?
require('../bd.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = trim($_POST["correo"]);
    $contraseña = trim($_POST["contraseña"]);

    $sql = "SELECT idUsuario, nombre, contraseña FROM usuarios WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        if (password_verify($contraseña, $usuario["contraseña"])) {
            $_SESSION["usuario_id"] = $usuario["idUsuario"];
            $_SESSION["usuario_nombre"] = $usuario["nombre"];
            echo "Inicio de sesión exitoso. <a href='index.php'>Ir al panel</a>";
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "No existe una cuenta con ese correo.";
    }

    $stmt->close();
    $conn->close();
}