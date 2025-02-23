CREATE DATABASE IF NOT EXISTS Desafio;
USE Desafio;

CREATE TABLE usuarios (
    idUsuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    contraseña VARCHAR(255) NOT NULL
);

CREATE TABLE proyectos (
    idProyecto INT AUTO_INCREMENT PRIMARY KEY,
    nombreProyecto VARCHAR(100) NOT NULL,
    descripcion TEXT,
    fechaInicio DATE,
    fechaFin DATE,
    idUsuario INT NOT NULL,
    FOREIGN KEY (idUsuario) REFERENCES usuarios(idUsuario) ON DELETE CASCADE
);

CREATE TABLE tareas (
    idTarea INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    fechaCreacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    fechaVencimiento DATE,
    estado ENUM('pendiente', 'en progreso', 'completada', 'cancelada') NOT NULL,
    prioridad ENUM('baja', 'media', 'alta') NOT NULL,
    idProyecto INT NOT NULL,
    idUsuarioAsignado INT,
    FOREIGN KEY (idProyecto) REFERENCES proyectos(idProyecto),
    FOREIGN KEY (idUsuarioAsignado) REFERENCES usuarios(idUsuario) ON DELETE SET NULL
);

CREATE TABLE comentarios (
    idComentario INT AUTO_INCREMENT PRIMARY KEY,
    idTarea INT NOT NULL,
    idUsuario INT NOT NULL,
    comentario TEXT NOT NULL,
    fechaComentario DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idTarea) REFERENCES tareas(idTarea) ON DELETE CASCADE,
    FOREIGN KEY (idUsuario) REFERENCES usuarios(idUsuario) ON DELETE CASCADE
);

CREATE TABLE historial_tareas (
    idHistorial INT AUTO_INCREMENT PRIMARY KEY,
    idTarea INT NOT NULL,
    idUsuario INT NOT NULL,
    estadoAnterior ENUM('pendiente', 'en progreso', 'completada', 'cancelada') NOT NULL,
    estadoNuevo ENUM('pendiente', 'en progreso', 'completada', 'cancelada') NOT NULL,
    fechaCambio DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idUsuario) REFERENCES usuarios(idUsuario) ON DELETE CASCADE,
    FOREIGN KEY (idTarea) REFERENCES tareas(idTarea) ON DELETE CASCADE
);

-- Verificar que la tabla historial_tareas se creó correctamente
SELECT * FROM historial_tareas;
