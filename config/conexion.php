<?php
$servidor = "localhost";
$usuario = "root";
$password = "";
$base_datos = "biblioteca-profe";

// Conexión a la base de datos MySQL
$conexion = mysqli_connect($servidor, $usuario, $password, $base_datos);

// Verificar la conexión
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
