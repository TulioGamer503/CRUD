<?php
$host = "localhost"; 
$usuario = "root"; 
$clave = ""; 
$base_de_datos = "desafio";

$conn = new mysqli($host, $usuario, $clave, $base_de_datos);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>