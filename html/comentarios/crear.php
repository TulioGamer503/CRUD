<?php
session_start();
require_once('../config/conexion.php'); // Incluye la conexión a la BD

// ✅ Verificar si la conexión existe
if (!$conn) {
    die("❌ Error de conexión: No se pudo conectar a la base de datos.");
}

// ✅ Redirigir al login si el usuario no ha iniciado sesión
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

$idTarea = isset($_GET["idTarea"]) ? intval($_GET["idTarea"]) : "";

// ✅ Obtener la lista de tareas
$sql = "SELECT idTarea, titulo FROM tareas";
$resultado = $conn->query($sql);
$tareas = [];

if ($resultado && $resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $tareas[] = $fila;
    }
} else {
    die("❌ Error: No se encontraron tareas.");
}

// ✅ Procesar el formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["idTarea"]) && !empty($_POST["comentario"])) {
        
        $idTarea = intval($_POST["idTarea"]); // Convertir a número entero
        $comentario = trim($_POST["comentario"]);
        $usuario_id = $_SESSION["usuario_id"]; // ID del usuario que comenta

        // ✅ Verificar si la tarea existe antes de insertar
        $sql_check = "SELECT idTarea FROM tareas WHERE idTarea = ?";
        $stmt_check = $conn->prepare($sql_check);

        if (!$stmt_check) {
            die("❌ Error en la consulta SQL: " . $conn->error);
        }

        $stmt_check->bind_param("i", $idTarea);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            // ✅ Insertar comentario en la base de datos
            $sql_insert = "INSERT INTO comentarios (idTarea, idUsuario, comentario) VALUES (?, ?, ?) ";
            $stmt_insert = $conn->prepare($sql_insert);

            if (!$stmt_insert) {
                die("❌ Error al preparar la inserción: " . $conn->error);
            }

            $stmt_insert->bind_param("iis", $idTarea, $usuario_id, $comentario);

            if ($stmt_insert->execute()) {
                header("Location: index.php?mensaje=Comentario agregado correctamente");
                exit();
            } else {
                die("❌ Error al agregar comentario: " . $stmt_insert->error);
            }

            $stmt_insert->close();
        } else {
            echo "⚠️ La tarea seleccionada no existe.";
        }

        $stmt_check->close();
    } else {
        echo "⚠️ Todos los campos son obligatorios.";
    }
}

// Cierra la conexión
$conn->close();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Comentario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Agregar Comentario</h2>
        <form action="crear.php" method="post">
            <div class="mb-3">
                <label for="idTarea" class="form-label">Tarea</label>
                <select name="idTarea" id="idTarea" class="form-select" required>
                    <option value="">Selecciona una tarea</option>
                    <?php foreach ($tareas as $tarea): ?>
                        <option value="<?= $tarea['idTarea'] ?>" <?= ($idTarea == $tarea['idTarea']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($tarea['titulo']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="comentario" class="form-label">Comentario</label>
                <textarea name="comentario" id="comentario" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar Comentario</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
