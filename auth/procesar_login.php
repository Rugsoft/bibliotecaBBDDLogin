<?php
require_once "../config/conexion.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$username = trim($_POST["username"] ?? "");
$password = trim($_POST["password"] ?? "");

if ($username == "" || $password == "") {
    header("Location: login.php?error=" . urlencode("Rellena todos los campos."));
    exit;
}

$sql = "SELECT id_admin, username, password_hash, nombre FROM administradores WHERE username = ?";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$admin = mysqli_fetch_assoc($resultado);
mysqli_stmt_close($stmt);

if ($admin && password_verify($password, $admin["password_hash"])) {
    $_SESSION["admin_logged_in"] = true;
    $_SESSION["admin_id"] = $admin["id_admin"];
    $_SESSION["admin_username"] = $admin["username"];
    $_SESSION["admin_nombre"] = $admin["nombre"];
    
    header("Location: ../index.php");
    exit;
} else {
    header("Location: login.php?error=" . urlencode("Usuario o contraseña incorrectos."));
    exit;
}
mysqli_close($conexion);
?>
